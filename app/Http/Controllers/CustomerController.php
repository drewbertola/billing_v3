<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Mauricius\LaravelHtmx\Http\HtmxRequest;

class CustomerController extends Controller
{
    public function list(HtmxRequest $request)
    {
        $customers = [];

        if (Auth::user()) {
            $customers = Customer::getTableData();
        }

        return view('customerList', [
            'isHtmxRequest' => $request->isHtmxRequest(),
            'customers' => $customers,
        ]);
    }

    public function balance(HtmxRequest $request, $customerId)
    {
        $customer = Customer::where('id', $customerId)->select('name')->first();

        $invoices = Invoice::where('customerId', $customerId)->get();
        $payments = Payment::where('customerId', $customerId)->get();

        $entries = [];

        $invoiceTotal = 0;
        $paymentTotal = 0;

        foreach ($invoices as $i) {
            $i->type = 'Invoice';
            $i->amount = -1 * $i->amount;
            $entries[] = $i;
            $invoiceTotal += $i->amount;
        }

        foreach ($payments as $p) {
            $p->type = 'Payment';
            $entries[] = $p;
            $paymentTotal += $p->amount;
        }

        usort($entries, 'self::sortEntries');

        $balance = 0;

        foreach ($entries as $e) {
            $balance += $e->amount;
            $e->balance = $balance;
        }

        return view('customerBalance', [
            'isHtmxRequest' => $request->isHtmxRequest(),
            'transactions' => $entries,
            'customerName' => $customer->name,
            'invTotal' => $invoiceTotal,
            'pmtTotal' => $paymentTotal,
        ]);
    }

    public function edit(HtmxRequest $request, $customerId)
    {
        if (empty($customerId)) {
            $customer = [
                'id' => '0',
                'name' => '',
                'phoneMain' => '',
                'fax' => '',
                'primaryContact' => '',
                'primaryEmail' => '',
                'primaryPhone' => '',
                'billingContact' => '',
                'billingEmail' => '',
                'billingPhone' => '',
                'bAddress1' => '',
                'bAddress2' => '',
                'bCity' => '',
                'bState' => '',
                'bZip' => '',
                'sAddress1' => '',
                'sAddress2' => '',
                'sCity' => '',
                'sState' => '',
                'sZip' => '',
                'taxRate' => '0.00',
                'archive' => 'N',
            ];
        } else {
            $customer = Customer::find($customerId);
        }

        return view('customerForm', [
            'isHtmxRequest' => $request->isHtmxRequest(),
            'customer' => $customer,
        ]);
    }

    public function save(HtmxRequest $request, $customerId)
    {
        // handle requests from timed out logins
        if (empty(Auth::user())) {
            return redirect('/');
        }

        if (empty($request->input('name'))) {
            return view('saveResult', [
                'isHtmxRequest' => $request->isHtmxRequest(),
                'message' => 'The customer\'s Name is required.',
            ]);
        }

        if (empty($customerId)) {
            $customer = new Customer();
        } else {
            $customer = Customer::find($customerId);
        }

        $customer->name = $request->input('name');
        $customer->phoneMain = $request->input('phoneMain');
        $customer->fax = $request->input('fax');
        $customer->primaryContact = $request->input('primaryContact');
        $customer->primaryEmail = $request->input('primaryEmail');
        $customer->primaryPhone = $request->input('primaryPhone');
        $customer->billingContact = $request->input('billingContact');
        $customer->billingEmail = $request->input('billingEmail');
        $customer->billingPhone = $request->input('billingPhone');
        $customer->bAddress1 = $request->input('bAddress1');
        $customer->bAddress2 = $request->input('bAddress2');
        $customer->bCity = $request->input('bCity');
        $customer->bState = $request->input('bState');
        $customer->bZip = $request->input('bZip');
        $customer->sAddress1 = $request->input('sAddress1');
        $customer->sAddress2 = $request->input('sAddress2');
        $customer->sCity = $request->input('sCity');
        $customer->sState = $request->input('sState');
        $customer->sZip = $request->input('sZip');
        $customer->taxRate = $request->input('taxRate');
        $customer->archive = $request->input('archive') === 'on' ? 'Y' : 'N';

        $customer->save();

        return response(
            view('saveResult', [
                'message' => 'success'
            ]), 200, ['HX-Redirect' => '/customers']
        );
    }

    private static function sortEntries($a, $b)
    {
        if ($a->date === $b->date) {
            return 0;
        }

        return ($a->date < $b->date) ? -1 : 1;
    }
}
