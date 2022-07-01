<?php

namespace App\Http\Controllers;

use App\Notifications\InvoiceCreated as InvoiceCreatedNotification;
use App\Models\Campaign;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    const PARTNERS_UE = [1, 2, 3, 4, 5];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $campaignId = $request->campaign;

        $invoices = Invoice::whereNull('billed_at')
            ->whereNull('number')
            ->where('to_bill', true)
            ->whereHas('checkout', function ($q) use ($campaignId) {
                $q->where('amount', '>', 0);
                $q->where('status', 'paid');
                if ($campaignId) {
                    $q->where(function ($q) use ($campaignId) {
                        $q->whereHas('products', function ($q) use ($campaignId) {
                            $q->where('campaign_id', $campaignId);
                            $q->whereHas('campaign', function ($q) {
                                $q->whereIn('partner_id', self::PARTNERS_UE);
                            });
                        });
                    });
                }
            })
            ->get();

        $billed = Invoice::whereNotNull('billed_at')
            ->whereNotNull('number')
            ->whereHas('checkout', function ($q) use ($campaignId) {
                if ($campaignId) {
                    $q->whereHas('products', function ($q) use ($campaignId) {
                        $q->where('campaign_id', $campaignId);
                        $q->whereHas('campaign', function ($q) {
                            $q->whereIn('partner_id', self::PARTNERS_UE);
                        });
                    });
                }
            })
            ->orderBy('billed_at', 'DESC')
            ->get();

        $campaigns = Campaign::whereIn('partner_id', self::PARTNERS_UE)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('invoices.index', [
            'invoices' => $invoices,
            'billed' => $billed,
            'campaigns' => $campaigns,
            'campaignId' => $campaignId,
        ]);
    }

    /**
     * Export all paid invoices
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        $invoices = Invoice::whereNull('billed_at')
            ->whereNull('number')
            ->where('to_bill', true)
            ->whereHas('checkout', function ($q) {
                $q->where('status', 'paid');
                $q->whereHas('products', function ($q) {
                    $q->whereHas('campaign', function ($q) {
                        $q->whereIn('partner_id', self::PARTNERS_UE);
                    });
                });
            })
            ->get();

        if ($invoices) {
            $counter = 1;
            $fileName = 'bills-' . date('YmdHM', time()) . '.txt';
            Storage::put('invoices/' . $fileName, "\xEF\xBB\xBF");

            foreach ($invoices as $invoice) {
                $checkout = $invoice->checkout;
                $products = $invoice->checkout->products()->distinct()->get();
                $address = $invoice->address;

                $taxId = strtoupper($address->tax_id);
                $taxType = $address->tax_type;
                
                $corporation = $checkout->campaign->partner->corporation;

                if ($taxType == 'CIF') {
                    $type = 'ATIC';
                } elseif ($taxType == 'Pasaporte' || $taxType == 'Extranjero') {
                    $type = 'COEX';
                } elseif ($taxType == 'NIF' || $taxType == 'NIE') {
                    $type = 'ATIN';
                } else {
                    $type = 'ATIN';
                }

                // $vat = $type === 'COEX' ? 0.00 : 21.00;
                $vat = 21.00;

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
                    $clientCode = 'CEX9' . str_pad($checkout->user->id, 6, '0', STR_PAD_LEFT);
                } else {
                    $clientCode = '0' . $taxId;
                }

                if ($checkout->method === 'transfer') {
                    $method = 7;
                } else {
                    $method = 6;
                }

                $conditions = 'ZU01';

                $deals = $checkout->deals;

                foreach ($products as $product) {
                    // TODO
                    $concept = substr(strip_tags(trim(preg_replace('/\t+/', '', $product->name))), 0, 132);
                    $quantity = $checkout->productQuantity($product->id);

                    $class = '';
                    if ($product->order) {
                        $class = 'ZCF';
                    } else {
                        $class = $checkout->amount > 0 ? 'ZAT' : 'ZAB';
                    }

                    $type = '';
                    if ($product->order) {
                        $type = $checkout->amount > 0 ? 'ZL2N' : 'ZG2N';
                    } else {
                        $type = $checkout->amount > 0 ? 'L2N' : 'G2N';
                    }

                    $class = '';
                    if ($product->order) {
                        $class = 'ZCF';
                    } else {
                        $class = $checkout->amount > 0 ? 'ZAT' : 'ZAB';
                    }

                    $type = '';
                    if ($product->order) {
                        $type = $checkout->amount > 0 ? 'ZL2N' : 'ZG2N';
                    } else {
                        $type = $checkout->amount > 0 ? 'L2N' : 'G2N';
                    }

                    $input = [
                        $counter,
                        $class,
                        str_pad($corporation, 4, '0', STR_PAD_LEFT),
                        str_pad($corporation, 4, '0', STR_PAD_LEFT),
                        '02',
                        '08',
                        $clientCode,
                        ' ',
                        ' ',
                        ' ',
                        date('d.m.Y', strtotime(date('Y-m-d H:i:s'))),
                        $vat > 0 ? 'SDPATROCPUB' : 'SDPATROCPUB0',
                        $checkout->id,
                        $type,
                        $product->product_id,
                        $product->order,
                        $quantity,
                        number_format((abs($product->price) / (1 + ($vat / 100))), 2, ',', ''),
                        $quantity,
                        $method,
                        $conditions,
                        ' ',
                        ' ',
                        'C10',
                        ' ',
                        $concept,
                        $type,
                        $clientCode,
                        strtoupper($address->name),
                        strtoupper($address->contact),
                        strtoupper($address->street ?: ' '),
                        strtoupper($address->street_number ?: ' '), // Debe existir?
                        strtoupper($address->city),
                        strtoupper($address->zip),
                        strtoupper($address->country),
                        ' ',
                        ' ',
                        strtoupper($checkout->user->email),
                        strtoupper($address->name),
                        strtoupper($address->contact),
                        strtoupper($address->street),
                        strtoupper($address->street_number), // Debe existir?
                        strtoupper($address->city),
                        strtoupper($address->zip),
                        strtoupper($address->country),
                        ' ',
                        ' ',
                        strtoupper($checkout->user->email),
                        '999999',
                        'C10',
                        $taxId,
                        strtoupper($address->country . $taxId),
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

                    file_put_contents(storage_path() . '/app/invoices/' . $fileName, implode("\t", $input) . PHP_EOL, FILE_APPEND);
                }

                if ($deals && $checkout->amount > 0) {
                    foreach ($deals as $deal) {
                        $input = [
                            $counter,
                            'ZAT',
                            str_pad($corporation, 4, '0', STR_PAD_LEFT),
                            str_pad($corporation, 4, '0', STR_PAD_LEFT),
                            '02',
                            '08',
                            $clientCode,
                            ' ',
                            ' ',
                            ' ',
                            date('d.m.Y', strtotime(date('Y-m-d H:i:s'))),
                            $vat > 0 ? 'SDPATROCPUB' : 'SDPATROCPUB0',
                            $checkout->id,
                            'G2N',
                            $products[0]->product_id,
                            ' ',
                            1,
                            number_format(((abs($deal->amount) / (1 + ($vat / 100))) / 1), 2, ',', ''),
                            1,
                            $method,
                            $conditions,
                            ' ',
                            ' ',
                            'C10',
                            ' ',
                            $deal->discount->concept,
                            $type,
                            $clientCode,
                            strtoupper($address->name),
                            strtoupper($address->contact),
                            strtoupper($address->street ?: ' '),
                            strtoupper($address->street_number ?: ' '), // Debe existir?
                            strtoupper($address->city),
                            strtoupper($address->zip),
                            strtoupper($address->country),
                            ' ',
                            ' ',
                            strtoupper($checkout->user->email),
                            strtoupper($address->name),
                            strtoupper($address->contact),
                            strtoupper($address->street),
                            strtoupper($address->street_number), // Debe existir?
                            strtoupper($address->city),
                            strtoupper($address->zip),
                            strtoupper($address->country),
                            ' ',
                            ' ',
                            strtoupper($checkout->user->email),
                            '999999',
                            'C10',
                            $taxId,
                            strtoupper($address->country . $taxId),
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

                        file_put_contents(storage_path() . '/app/invoices/' . $fileName, implode("\t", $input) . PHP_EOL, FILE_APPEND);
                    }
                }

                $invoice->billed_at = Carbon::now();
                $invoice->save();

                ++$counter;
            }

            $headers = [
                'Content-Encoding: UTF-8',
                'Content-Type' => 'text/plain',
            ];

            return Storage::download('invoices/' . $fileName, null, $headers);
        }
    }

    /**
     * Import all paid invoices
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
        $data = array_map(function ($v) {
            return str_getcsv($v, ";");
        }, file($path));

        foreach ($data as $index => $import) {
            if ((isset($import[1]) && $import[1] == 'Factura') || $index === 0) {
                continue;
            }

            $invoice = Invoice::where('checkout_id', $import[0])
                ->first();

            if ($invoice) {
                if (!$invoice->number && $import[1]) {
                    $invoice->number = $import[1];
                    $invoice->billed_at = date('Y-m-d H:i:s', strtotime($import[2]));

                    $invoice->save();

                    $invoice->checkout->user->notify(new InvoiceCreatedNotification($invoice));
                }
            } else {
                $errors[$index]['id'] = $import[0];
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
