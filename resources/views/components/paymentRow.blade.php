@php
    $id = '#' . str_pad($payment->id, 6, '0', STR_PAD_LEFT);
    $fmt = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
    $amount = $fmt->formatCurrency($payment->amount, 'USD');
    $date = date('m/d/Y', strtotime($payment->date));
@endphp

<tr id="paymentRow{{$payment['id']}}">
    <td class="text-end">{{$id}}</td>
    <td>{{$payment->customer->name}}</td>
    <td class="text-end">{{$date}}</td>
    <td class="text-end">{{$amount}}</td>
    <td>{{$payment->method}}</td>
    <td>{{$payment->number}}</td>
    <td class="text-center">
        <a href=""
            data-bs-toggle="modal"
            data-bs-target="#paymentModal"
            hx-get="/payments/edit/{{$payment->id}}"
            hx-target="#paymentDialog"
            hx-trigger="click"
            hx-swap="innerHTML">
            <span class="bi bi-pencil-fill text-danger"></span>
        </a>
    </td>
</tr>