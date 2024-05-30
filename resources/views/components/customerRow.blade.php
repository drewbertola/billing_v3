@php
    $fmt = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
    $balance = $fmt->formatCurrency($customer->balance, 'USD');
    $lastInvDate = date('m/d/Y', strtotime($customer->lastInvDate));
@endphp


<tr @class([
        'archived' => $customer->archive === 'Y',
        'd-none' => $customer->archive === 'Y',
    ])>
    <td>
        <a href="" class="fw-bold text-decoration-none"
            hx-get="/customers/edit/{{$customer->id}}"
            hx-trigger="click"
            hx-target="#content"
            hx-push-url="true">{{$customer->name}}</a>
    </td>
    <td>{{$customer->primaryContact}}</td>
    <td class="text-center">
        <a href="" class="text-decoration-none"
            hx-get="/invoices/edit/{{$customer->lastInvId}}"
            hx-target="#content"
            hx-trigger="click">{{$lastInvDate}}</a>
    </td>
    <td class="text-end">
        <a href="" class="text-decoration-none"
            hx-get="/customers/balance/{{$customer->id}}"
            hx-target="#content"
            hx-trigger="click">{{$balance}}</a>
    </td>
    <td class="text-center">
        <a href=""
            hx-get="/invoices/edit/0/{{$customer->id}}"
            hx-target="#content"
            hx-trigger="click">
            <span class="bi bi-file-earmark-plus-fill text-danger"></span>
        </a>
    </td>
    <td class="text-center">
        <a href=""
            hx-get="/payments/edit/0/{{$customer->id}}"
            hx-target="#content"
            hx-trigger="click">
            <span class="bi bi-file-earmark-plus-fill text-success"></span>
        </a>
    </td>
</tr>
