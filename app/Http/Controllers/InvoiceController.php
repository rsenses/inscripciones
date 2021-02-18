<?php

namespace App\Http\Controllers;

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

                $concept = $invoice->concept ?: $checkout->product->name;
                $concept = substr(strip_tags(trim(preg_replace('/\t+/', '', $concept))), 0, 132);

                $input = [
                    $counter,
                    'ZCF',
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
                    $checkout->amount > 0 ? 'ZL2N' : 'ZG2N',
                    ' ',
                    $checkout->product->sap,  // Debe existir?
                    $checkout->quantity,
                    number_format(((abs($checkout->amount) / (1 + ($vat / 100))) / $checkout->quantity), 2, ',', ''),
                    $checkout->quantity,
                    $checkout->method === 'transfer' ? 7 : 6,
                    'ZU01',
                    ' ',
                    ' ',
                    'C20',
                    'COF',
                    $concept,
                    $type,
                    $clientCode,
                    $address->name,
                    $address->contact, // Debe existir?
                    $address->street ?: ' ',
                    $address->street_number ?: ' ', // Debe existir?
                    $address->city,
                    $address->zip,
                    $address->country,
                    ' ',
                    ' ',
                    $checkout->user->email,
                    $address->name,
                    $address->contact, // Debe existir?
                    $address->street,
                    $address->street_number, // Debe existir?
                    $address->city,
                    $address->zip,
                    $address->country,
                    ' ',
                    ' ',
                    ' ',
                    '999999',
                    'C20',
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
                    'ZU01',
                    'X',
                    7,
                    '0001',
                    ' ',
                    ' ',
                    ' ',
                    'A',
                    ' ',
                    ' ',
                    ' ',
                    'ZU01',
                    '02',
                    1,
                    0,
                    $checkout->iban, // Debe existir?
                    ' ',
                    ' ',
                    ' ',
                    ' ',
                    ' ',
                    ' ',
                    ' ',
                ];

                $invoice->billed_at = Carbon::now();
                $invoice->save();

                file_put_contents(storage_path() . '/app/invoices/' . $fileName, implode("\t", $input), FILE_APPEND);
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
    public function import()
    {
        //
    }
}
