<x-layout :isHtmxRequest=$isHtmxRequest>
    @guest
        <x-loginForm />
    @endguest

    @auth
        @if ($payment['id'] === 0)
            <p>Add Payment</p>
        @else
            <p>Update Payment</p>
        @endif
        <p class="text-danger text-center fw-bold" id="saveResult"></p>
        <form class="m-4">
            @csrf
            <div class="row mb-2">
                <label class="col-form-label col-md-3" for="customerId">Customer</label>
                <div class="col-md-9 p-0">
                    <select class="form-select" name="customerId" id="customerId">
                        @foreach ($customers as $customer)
                            <option value="{{$customer['id']}}"
                                @if ($customer['id'] == $payment['customerId'])
                                    selected
                                @endif
                            >{{$customer['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <label class="col-form-label col-md-3" for="date">Date</label>
                <input class="col-md-9" type="date" name="date" id="date" value="{{$payment['date']}}" />
            </div>
            <div class="row mb-2">
                <label class="col-form-label col-md-3" for="amount">Amount</label>
                <input class="col-md-9" type="text" name="amount" id="amount" value="{{$payment['amount']}}" />
            </div>
            <div class="row mb-2">
                <label class="col-form-label col-md-3" for="method">Method</label>
                <div class="col-md-9 p-0">
                    <select class="form-select" name="method" id="method">
                        @foreach ($methods as $method)
                            <option value="{{$method}}"
                                @if ($method === $payment['method'])
                                    selected
                                @endif
                            >{{$method}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <label class="col-form-label col-md-3" for="number">Number</label>
                <input class="col-md-9" type="text" name="number" id="number" value="{{$payment['number']}}" />
            </div>
            <div class="form-group row justify-content-between mt-4">
                <button type="button" class="btn btn-secondary col-4 col-md-2 mt-2" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary col-4 col-md-2 mt-2" data-bs-dismiss="modal"
                    hx-post="/payments/save/{{$payment['id']}}"
                    hx-trigger="click"
                    hx-target="#paymentRow{{$payment['id']}}"
                    @if (empty($payment['id']))
                        hx-swap="afterend"
                    @else
                        hx-swap="outerHTML"
                    @endif
                >Save</button>
            </div>
    @endauth
</x-layout>
