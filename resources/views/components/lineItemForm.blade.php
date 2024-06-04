@php
    $invoiceId = '#' . str_pad($lineItem['invoiceId'], 6, '0', STR_PAD_LEFT);
@endphp

@guest
    <x-loginForm />
@endguest

@auth
    @if ($lineItem['id'] === 0)
        <p>Add Line Item for Invoice {{$invoiceId}}</p>
    @else
        <p>Update Line Item</p>
    @endif
    <ul class="text-danger text-center fw-bold" id="saveResult"></ul>
    <form class="m-4">
        @csrf
        <input type="hidden" name="invoiceId" id="invoiceId" value="{{$lineItem['invoiceId']}}" />
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="description">Description</label>
            <input class="col-md-9" type="text" name="description" id="description" value="{{$lineItem['description']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="quantity">Quantity</label>
            <input class="col-md-9" type="text" name="quantity" id="quantity" value="{{$lineItem['quantity']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="price">Price</label>
            <input class="col-md-9" type="text" name="price" id="price" value="{{$lineItem['price']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="units">Units</label>
            <input class="col-md-9" type="text" name="units" id="units" value="{{$lineItem['units']}}" />
        </div>
        <div class="form-group row justify-content-between">
            <button type="button" class="btn btn-secondary col-4 col-md-2 mt-2"
                data-bs-target="#invoiceModal"
                data-bs-toggle="modal"
                data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary col-4 col-md-2 mt-2"
                data-bs-target="#invoiceModal"
                data-bs-toggle="modal"
                data-bs-dismiss="modal"
                hx-post=/line-items/save/{{$lineItem['id']}}
                hx-trigger="click"
                hx-target="#lineItemTableBody"
                hx-swap="innerHTML"
            >Save</button>
        </div>
    </form>
@endauth
