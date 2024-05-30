<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\LineItem;
use Illuminate\Support\Facades\Auth;
use Mauricius\LaravelHtmx\Http\HtmxRequest;

class InvoiceController extends Controller
{
    public function list(HtmxRequest $request)
    {
        $invoices = [];

        if (Auth::user()) {
            $invoices = Invoice::orderByDesc('id')->get();
        }

        return view('invoiceList', [
            'isHtmxRequest' => $request->isHtmxRequest(),
            'invoices' => $invoices,
        ]);
    }

    public function toggleEmailed(HtmxRequest $request, $invoiceId)
    {
        $invoice = [];

        if (Auth::user()) {
            $invoice = Invoice::find($invoiceId);

            $invoice->emailed = $invoice->emailed === 'Y' ? 'N' : 'Y';
            $invoice->save();
        }

        return view('components.invoiceRow', [
            'isHtmxRequest' => $request->isHtmxRequest(),
            'invoice' => $invoice,
        ]);
    }

    public function edit(HtmxRequest $request, $invoiceId, $customerId = 0)
    {
        if (empty($invoiceId)) {
            $invoice = [
                'id' => 0,
                'customerId' => $customerId,
                'amount' => 0.00,
                'date' => date('Y-m-d'),
                'emailed' => 'N',
                'note' => '',
            ];
            $lineItems = [];
            $customers = Customer::select('id', 'name')->where('archive', 'N')->get();
        } else {
            $invoice = Invoice::find($invoiceId);
            $lineItems = LineItem::where('invoiceId', $invoiceId)->get();
            $customers = Customer::select('id', 'name')->get();
        }

        return view('invoiceForm', [
            'isHtmxRequest' => $request->isHtmxRequest(),
            'invoice' => $invoice,
            'lineItems' => $lineItems,
            'customers' => $customers,
        ]);
    }

    public function save(HtmxRequest $request, $invoiceId)
    {
        // handle requests from timed out logins
        if (empty(Auth::user())) {
            return redirect('/');
        }

        if (empty($invoiceId)) {
            $invoice = new Invoice();
        } else {
            $invoice = Invoice::find($invoiceId);
        }

        // NOTE: $invoice->amount is not saved here.  This is done when
        // line items are saved.
        $invoice->customerId = $request->input('customerId');
        $invoice->date = $request->input('date');
        $invoice->emailed = $request->input('emailed') === 'on' ? 'Y' : 'N';
        $invoice->note = $request->input('note');

        $invoice->save();

        return response(
            view('saveResult', [
                'message' => 'success'
            ]), 200, ['HX-Redirect' => '/invoices']
        );
    }

    public function pdf($invoiceId)
    {
        $invoice = Invoice::where('id', $invoiceId)->first();
        $lineItems = LineItem::where('invoiceId', $invoiceId)->get();
        $customer = Customer::where('id', $invoice->customerId)->first();

        $result = \App\Pdf\Invoice::render($invoice, $lineItems, $customer);

        return response(
            $result->pdf,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $result->file . '"',
            ]
        );
    }
}
