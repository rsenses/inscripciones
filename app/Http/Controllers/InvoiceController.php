<?php

namespace App\Http\Controllers;

use App\Events\InvoiceCreated;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::whereNull('billed_at')
            ->whereNull('number')
            ->get();

        return view('invoices.index', [
            'invoices' => $invoices
        ]);
    }

    /**
     * Export all pending invoices
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        $invoices = Invoice::whereNull('billed_at')
            ->whereNull('number')
            ->get();

        if ($invoices) {
            $counter = 1;
            $fileName = 'bills-' . strftime('%Y%m%d%H%M', time()) . '.txt';
            Storage::put('invoices/' . $fileName, '');

            foreach ($invoices as $invoice) {
                $checkout = $invoice->checkout;
                $address = $invoice->address;

                $taxId = strtoupper($address->tax_id);
                $taxType = $address->tax_type;
                
                $corporation = $checkout->product->partners[0]->corporation;

                if ($taxType == 'CIF') {
                    $type = 'ATIC';
                } elseif ($taxType == 'Pasaporte' || $taxType == 'Extranjero') {
                    $type = 'COEX';
                } elseif ($taxType == 'NIF' || $taxType == 'NIE') {
                    $type = 'ATIN';
                } else {
                    $type = 'ATIN';
                }

                $vat = $type === 'COEX' ? 0.00 : 21.00;

                if (strlen($taxId) > 9) {
                    $taxId = substr($taxId, 0, 9);
                } elseif (strlen($taxId) < 9) {
                    $taxId = str_pad($taxId, 9, '0', STR_PAD_LEFT);
                }

                if (strlen($address->zip) > 5) {
                    $address->zip = substr($address->zip, 0, 5);
                }
                if (strlen($address->zip) < 9) {
                    $address->zip = str_pad($address->zip, 5, '0', STR_PAD_LEFT);
                }

                if ($taxType == 'CIF') {
                    $clientCode = '@' . $taxId;
                } elseif ($taxType == 'Pasaporte' || $taxType == 'Extranjero') {
                    $clientCode = 'CEX' . str_pad($checkout->user->id, 7, '0', STR_PAD_LEFT);
                } else {
                    $clientCode = '0' . $taxId;
                }

                if ($checkout->method === 'transfer') {
                    $method = 7;
                } else {
                    $method = 6;
                }

                $conditions = 'ZU01';

                $concept = substr(strip_tags(trim(preg_replace('/\t+/', '', $checkout->product->name))), 0, 132);

                $input = [
                    $counter,
                    $checkout->amount > 0 ? 'ZAT' : 'ZAB',
                    str_pad($corporation, 4, '0', STR_PAD_LEFT),
                    str_pad($corporation, 4, '0', STR_PAD_LEFT),
                    '02',
                    '08',
                    $clientCode,
                    ' ',
                    ' ',
                    ' ',
                    strftime('%d.%m.%Y', strtotime(date('Y-m-d H:i:s'))),
                    $vat > 0 ? 'SDPATROCPUB' : 'SDPATROCPUB0',
                    $checkout->id,
                    $checkout->amount > 0 ? 'L2N' : 'G2N',
                    $checkout->product->product_id,
                    ' ',
                    $checkout->quantity,
                    number_format(((abs($checkout->amount) / (1 + ($vat / 100))) / $checkout->quantity), 2, ',', ''),
                    $checkout->quantity,
                    $method,
                    $conditions,
                    ' ',
                    ' ',
                    'C10',
                    ' ',
                    $concept,
                    $type,
                    $clientCode,
                    $address->name,
                    $address->contact,
                    $address->street ?: ' ',
                    $address->street_number ?: ' ', // Debe existir?
                    $address->city,
                    $address->zip,
                    $address->country,
                    ' ',
                    ' ',
                    $checkout->user->email,
                    $address->name,
                    $address->contact,
                    $address->street,
                    $address->street_number, // Debe existir?
                    $address->city,
                    $address->zip,
                    $address->country,
                    ' ',
                    ' ',
                    $checkout->user->email,
                    '999999',
                    'C10',
                    $taxId,
                    $address->country . $taxId,
                    ' ',
                    ' ',
                    ' ',
                    ' ',
                    ' ',
                    ' ',
                    ' ',
                    ' ',
                    ' ',
                    ' ',
                    '430700',
                    ' ',
                    $conditions,
                    'X',
                    $method,
                    '0001',
                    ' ',
                    'MY',
                    'MY',
                    'A',
                    ' ',
                    ' ',
                    ' ',
                    $conditions,
                    '02',
                    0,
                    0,
                    $checkout->iban,
                    ' ',
                    ' ',
                    ' ',
                    ' ',
                    $address->ofcont ? $address->ofcont : ' ',
                    $address->gestor ? $address->gestor : ' ',
                    $address->untram ? $address->untram : ' ',
                ];

                $invoice->billed_at = Carbon::now();
                $invoice->save();

                file_put_contents(storage_path() . '/app/invoices/' . $fileName, implode("\t", $input) . PHP_EOL, FILE_APPEND);
                ++$counter;
            }

            return Storage::download('invoices/' . $fileName);
        }
    }

    /**
     * Import all pending invoices
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $request->validate([
            'import' => 'required|mimes:csv,txt',
        ]);

        $fileName = $request->file('import')->store('invoices/import');
        $path = Storage::disk('local')->path($fileName);
        $data = array_map(function($v) {
            return str_getcsv($v, ";");
        }, file($path));

        foreach($data as $index => $import) {
            if ((isset($import[1]) && $import[1] == 'Factura') || $index === 0) {
                continue;
            }

            $price = str_replace(' ', '', $import[3]);
            $price = floatval(str_replace(',', '.', str_replace('.', '', $price)));
            $vat = floatval(str_replace(',', '.', str_replace('.', '', $import[5])));
            $finalPrice = $price + $vat;

            if (round($finalPrice - floor($finalPrice), 2) === 0.99) {
                $finalPrice = number_format(floor($finalPrice) + 1, 2, '.', '');
            } else {
                $finalPrice = number_format($finalPrice, 2, '.', '');
            }

            $invoice = Invoice::where('checkout_id', $import[0])->first();

            if ($invoice) {
                $invoice->number = $import[1];
                $invoice->billed_at = date('Y-m-d H:i:s', strtotime($import[2]));

                $invoice->save();

                InvoiceCreated::dispatch($invoice);
            } else {
                $errors[$index]['id'] = $import[0];
                $errors[$index]['price'] = $finalPrice;
            }
        }

        if (!empty($errors)) {
            $errorMessage = '';

            foreach ($errors as $error) {
                $errorMessage .= 'Compra ' . $error['id'] . ' con precio ' . $error['price'] . '<br />';
            }
            return redirect()->back()->with('danger', '<strong>Errores en el archivo</strong>:<br />' . $errorMessage);
        } else {
            return redirect()->back()->with('success', '<strong>Facturas añadidas correctamente</strong>');
        }
    }
}
