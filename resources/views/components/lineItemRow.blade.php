@php
    $fmt = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
    $price = $fmt->formatCurrency($lineItem['price'], 'USD');
    $ext = $fmt->formatCurrency($lineItem['price'] * $lineItem['quantity'], 'USD');
@endphp

<tr id="lineItemRow{{$lineItem['id']}}">
    <td class="text-center">{{$num}}</td>
    <td>{{$lineItem['description']}}</td>
    <td class="text-end">{{$lineItem['quantity']}}</td>
    <td class="text-end">{{$price}}</td>
    <td>{{$lineItem['units']}}</td>
    <td class="text-end">{{$ext}}</td>
    <td class="text-center">

        <button class="btn btn-white p-0 ms-auto float-end"
            title="Edit Line Item"
            data-bs-target="#lineItemModal"
            data-bs-toggle="modal"
            data-bs-dismiss="modal"
            hx-get="/line-items/edit/{{$lineItem['invoiceId']}}/{{$lineItem['id']}}"
            hx-target="#lineItemDialog"
            hx-trigger="click"
            hx-swap="innerHTML">
            <span class="bi bi-pencil-fill text-danger"></span>
        </button>
    </td>
</tr>
