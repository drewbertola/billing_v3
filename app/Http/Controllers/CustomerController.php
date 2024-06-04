<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveCustomerRequest;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Http\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mauricius\LaravelHtmx\Http\HtmxRequest;

class CustomerController extends Controller
{
    use HttpResponses;

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

        return view('components.customerBalance', [
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

        return view('components.customerForm', [
            'isHtmxRequest' => $request->isHtmxRequest(),
            'customer' => $customer,
        ]);
    }

    public function save(Request $request, $customerId)
    {
        // handle requests from timed out logins
        if (empty(Auth::user())) {
            return redirect('/');
        }

        $data = $request->all();
        $rules = SaveCustomerRequest::rules();
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return $this->modalSaveError($validator->errors(), 'customerModal');
        }

        if (empty($customerId)) {
            $customer = Customer::create($data);
        } else {
            $customer = Customer::find($customerId);
            $customer->update($data);
        }

        $tableData = Customer::getTableDataRow($customer->id);

        return view('components.customerRow', [
            'customer' => $tableData,
        ]);
    }

    private static function sortEntries($a, $b)
    {
        if ($a->date === $b->date) {
            return 0;
        }

        return ($a->date < $b->date) ? -1 : 1;
    }
}
