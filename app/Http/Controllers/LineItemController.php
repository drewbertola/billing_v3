<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\LineItem;
use Illuminate\Support\Facades\Auth;
use Mauricius\LaravelHtmx\Http\HtmxRequest;

class LineItemController extends Controller
{
    public function edit(HtmxRequest $request, $invoiceId, $lineItemId)
    {
        if (empty($lineItemId)) {
            $lineItem = [
                'id' => 0,
                'invoiceId' => $invoiceId,
                'price' => '0.00',
                'units' => '',
                'quantity' => 0,
                'description' => '',
            ];
        } else {
            $lineItem = LineItem::find($lineItemId);
        }

        return view('lineItemForm', [
            'isHtmxRequest' => $request->isHtmxRequest(),
            'lineItem' => $lineItem,
        ]);
    }

    public function save(HtmxRequest $request, $lineItemId)
    {
        // handle requests from timed out logins
        if (empty(Auth::user())) {
            return redirect('/');
        }

        if (empty($lineItemId)) {
            $lineItem = new LineItem();
        } else {
            $lineItem = LineItem::find($lineItemId);
        }

        $lineItem->invoiceId = $request->input('invoiceId');
        $lineItem->price = $request->input('price');
        $lineItem->units = $request->input('units');
        $lineItem->quantity = $request->input('quantity');
        $lineItem->description = $request->input('description');

        $lineItem->save();

        // Importantly, update the total 'amount' for the associated invoice
        $this->updateInvoiceAmount($lineItem->invoiceId);

        return response(
            view('saveResult', [
                'message' => 'success'
            ]), 200, ['HX-Redirect' => '/invoices/edit/' . $lineItem->invoiceId]
        );
    }

    private function updateInvoiceAmount($invoiceId)
    {
        $invoice = Invoice::find($invoiceId);

        $lineItems = LineItem::where('invoiceId', $invoiceId)->select('price', 'quantity')->get();

        $amount = 0.00;

        foreach ($lineItems as $lineItem) {
            $amount += $lineItem->price * $lineItem->quantity;
        }

        $invoice->amount = $amount;

        $invoice->save();
    }
}
