<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Mauricius\LaravelHtmx\Http\HtmxRequest;

class PaymentController extends Controller
{
    public function list(HtmxRequest $request)
    {
        $payments = [];

        if (Auth::user()) {
            $payments = Payment::orderByDesc('id')->get();
        }

        return view('paymentList', [
            'isHtmxRequest' => $request->isHtmxRequest(),
            'payments' => $payments,
        ]);
    }

    public function edit(HtmxRequest $request, $paymentId, $customerId = 0)
    {
        if (empty($paymentId)) {
            $customerName = empty($customerId) ? '' : Customer::find($customerId)->name;

            $payment = [
                'id' => 0,
                'customerId' => $customerId,
                'amount' => 0.00,
                'date' => date('Y-m-d'),
                'method' => '',
                'number' => '',
                'customer' => ['name' => $customerName],
            ];

            $customers = Customer::select('id', 'name')->where('archive', 'N')->get();
        } else {
            $payment = Payment::find($paymentId);

            $customers = Customer::select('id', 'name')->get();
        }

        $triggerHeader = json_encode([
            'completions' => [
                'customers' => $customers,
                'methods' => ['Cash', 'Card', 'Check', 'Transfer'],
            ],
        ]);

        return response(
            view('components.paymentForm', [
                'isHtmxRequest' => $request->isHtmxRequest(),
                'payment' => $payment,
            ]), 200, ['HX-Trigger' => $triggerHeader]);
    }

    public function save(HtmxRequest $request, $paymentId)
    {
        // handle requests from timed out logins
        if (empty(Auth::user())) {
            return redirect('/');
        }

        if (empty($paymentId)) {
            $payment = new Payment();
        } else {
            $payment = Payment::find($paymentId);
        }

        $payment->customerId = $request->input('customerId');
        $payment->amount = $request->input('amount');
        $payment->date = $request->input('date');
        $payment->method = $request->input('method');
        $payment->number = $request->input('number');

        $payment->save();

        return view('components.paymentRow', [
            'isHtmxRequest' => $request->isHtmxRequest(),
            'payment' => $payment,
        ]);
    }
}
