<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveInvoiceRequest;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\LineItem;
use App\Http\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mauricius\LaravelHtmx\Http\HtmxRequest;

class InvoiceController extends Controller
{
    use HttpResponses;

    public function list(HtmxRequest $request)
    {
        $invoices = [];

        if (Auth::user()) {
            $invoices = Invoice::orderByDesc('id')->get();
        }

        if ($request->method() === 'POST') {
            if (empty($request->input('customerId'))) {
                $customers = Customer::select('id', 'name')->get();
            } else {
                $customers = Customer::select('id', 'name')->where('archive', 'N')->get();
            }

            $triggerHeader = json_encode([
                'open-edit' => [
                    'id' => $request->input('invoiceId') ?? 0,
                    'customerId' => $request->input('customerId') ?? 0,
                    'invoiceOrPayment' => 'invoice',
                    'customers' => $customers,
                ]
            ]);

            return response(
                view('invoiceList', [
                    'isHtmxRequest' => $request->isHtmxRequest(),
                    'invoices' => $invoices,
                ]), 200, ['HX-Trigger' => $triggerHeader]
            );
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
            $customerName = empty($customerId) ? '' : Customer::find($customerId)->name;

            $invoice = [
                'id' => 0,
                'customerId' => $customerId,
                'amount' => 0.00,
                'date' => date('Y-m-d'),
                'emailed' => 'N',
                'note' => '',
                'customer' => ['name' => $customerName],
            ];

            $lineItems = [];
            $customers = Customer::select('id', 'name')->where('archive', 'N')->get();
        } else {
            $invoice = Invoice::find($invoiceId);
            $lineItems = LineItem::where('invoiceId', $invoiceId)->get();
            $customers = Customer::select('id', 'name')->get();
        }

        $triggerHeader = json_encode([
            'completions' => [
                'customers' => $customers,
            ],
        ]);

        return response(
            view('components.invoiceForm', [
                'isHtmxRequest' => $request->isHtmxRequest(),
                'invoice' => $invoice,
                'lineItems' => $lineItems,
            ]), 200, ['HX-Trigger' => $triggerHeader]
        );
    }

    public function save(HtmxRequest $request, $invoiceId)
    {
        // handle requests from timed out logins
        if (empty(Auth::user())) {
            return redirect('/');
        }

        $data = $request->all();
        $rules = SaveInvoiceRequest::rules();
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return $this->modalSaveError($validator->errors(), 'invoiceModal');
        }

        if (empty($invoiceId)) {
            $invoice = Invoice::create($data);
        } else {
            $invoice = Invoice::find($invoiceId);
            $invoice->update($data);
        }

        if (stripos($request->getCurrentUrl(), '/customers')) {
            return view('components.customerRow', [
                'customer' => Customer::getTableDataRow($invoice->customerId),
            ]);
        }

        return view('components.invoiceRow', [
            'isHtmxRequest' => $request->isHtmxRequest(),
            'invoice' => $invoice,
        ]);
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
