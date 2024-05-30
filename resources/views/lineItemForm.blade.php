@php
    $invoiceId = '#' . str_pad($lineItem['invoiceId'], 6, '0', STR_PAD_LEFT);
@endphp

<x-layout :isHtmxRequest=$isHtmxRequest>
    @guest
        <x-loginForm />
    @endguest

    @auth
        @if ($lineItem['id'] === 0)
            <p>Add Line Item for Invoice {{$invoiceId}}</p>
        @else
            <p>Update Line Item</p>
        @endif
        <p class="text-danger text-center fw-bold" id="saveResult"></p>
        <form class="col-md-6 mx-auto">
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
            <div class="form-group row justify-content-end">
                <button type="submit" class="btn btn-primary col-4 col-md-2 mt-2"
                    hx-post=/line-items/save/{{$lineItem['id']}}
                    hx-trigger="click"
                    hx-target="#saveResult">Save</button>
            </div>
        </form>
    @endauth
</x-layout>
