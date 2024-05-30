<?php

namespace App\Http\Controllers;

use Mauricius\LaravelHtmx\Http\HtmxRequest;

class LineItemController extends Controller
{
    public function list(HtmxRequest $request)
    {
        return view('lineItemList', [
            'isHtmxRequest' => $request->isHtmxRequest(),
        ]);
    }
}
