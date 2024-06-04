<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavePaymentRequest;
use App\Models\Customer;
use App\Models\Payment;
use App\Http\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mauricius\LaravelHtmx\Http\HtmxRequest;

class PaymentController extends Controller
{
    use HttpResponses;

    public function list(HtmxRequest $request)
    {
        $payments = [];

        if (Auth::user()) {
            $payments = Payment::orderByDesc('id')->get();
        }

        if ($request->method() === 'POST') {
            if (empty($request->input('customerId'))) {
                $customers = Customer::select('id', 'name')->get();
            } else {
                $customers = Customer::select('id', 'name')->where('archive', 'N')->get();
            }

            $triggerHeader = json_encode([
                'open-edit' => [
                    'id' => $request->input('paymentId') ?? 0,
                    'customerId' => $request->input('customerId') ?? 0,
                    'invoiceOrPayment' => 'payment',
                    'customers' => $customers,
                    'methods' => ['Cash', 'Card', 'Check', 'Transfer'],
                ]
            ]);

            return response(
                view('paymentList', [
                    'isHtmxRequest' => $request->isHtmxRequest(),
                    'payments' => $payments,
                ]), 200, ['HX-Trigger' => $triggerHeader]
            );
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
                'method' => 'Cash',
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

        $data = $request->all();
        $rules = SavePaymentRequest::rules();
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return $this->modalSaveError($validator->errors(), 'paymentModal');
        }

        if (empty($paymentId)) {
            $payment = Payment::create($data);
        } else {
            $payment = Payment::find($paymentId);
            $payment->update($data);
        }

        return view('components.paymentRow', [
            'isHtmxRequest' => $request->isHtmxRequest(),
            'payment' => $payment,
        ]);
    }
}
