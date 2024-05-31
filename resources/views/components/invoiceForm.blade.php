@php
    $fmt = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
    $amount = $fmt->formatCurrency($invoice['amount'], 'USD');
@endphp

<x-layout :isHtmxRequest=$isHtmxRequest>
    @guest
        <x-loginForm />
    @endguest

    @auth
        @if ($invoice['id'] === 0)
            <p>Add Invoice</p>
        @else
            <p>Update Invoice</p>
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
                                @if ($customer['id'] == $invoice['customerId'])
                                    selected
                                @endif
                            >{{$customer['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <label class="col-form-label col-md-3" for="date">Date</label>
                <input class="col-md-9" type="date" name="date" id="date" value="{{$invoice['date']}}" />
            </div>
            <div class="row mb-2">
                <label class="col-form-label col-md-3" for="amount">Amount</label>
                <input class="col-md-9" type="text" name="amount" id="amount" value="{{$amount}}" disabled />
            </div>
            <div class="clearfix">
                <p class="fw-bold me-auto float-start">Line Items</p>
                <button class="btn btn-white p-0 ms-auto float-end"
                    title="Add Line Item"
                    data-bs-target="#lineItemModal"
                    data-bs-toggle="modal"
                    data-bs-dismiss="modal"
                    hx-get="/line-items/edit/{{$invoice['id']}}/0"
                    hx-target="#lineItemDialog"
                    hx-trigger="click"
                    hx-swap="innerHTML">
                    <span class="bi bi-file-earmark-plus-fill text-primary fs-5"></span>
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mx-auto mb-4" id="lineItemTable">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Description</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Price</th>
                            <th>Units</th>
                            <th class="text-end">Ext</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody id="lineItemTableBody">
                        <tr id="lineItemRow0"></tr>
                        <x-lineItemBody :lineItems=$lineItems />
                    </tbody>
                </table>
            </div>
            <p class="fw-bold me-auto">Notes</p>
            <div class="row mb-2 mx-2">
                <textarea class="form-control" name="note" id="note" rows="6">{{$invoice['note']}}</textarea>
            </div>
            <div class="form-group row justify-content-between">
                <button type="button" class="btn btn-secondary col-4 col-md-2 mt-2"
                    data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary col-4 col-md-2 mt-2"
                    data-bs-dismiss="modal"
                    hx-post="/invoices/save/{{$invoice['id']}}"
                    hx-trigger="click"
                    hx-target="#invoiceRow{{$invoice['id']}}"
                    @if (empty($invoice['id']))
                        hx-swap="afterend"
                    @else
                        hx-swap="outerHTML"
                    @endif
                >Save</button>
            </div>
        </form>
    @endauth
</x-layout>