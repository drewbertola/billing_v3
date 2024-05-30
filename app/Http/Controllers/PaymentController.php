<?php

namespace App\Http\Controllers;

use Mauricius\LaravelHtmx\Http\HtmxRequest;

class PaymentController extends Controller
{
    public function list(HtmxRequest $request)
    {
        return view('paymentList', [
            'isHtmxRequest' => $request->isHtmxRequest(),
        ]);
    }
}
