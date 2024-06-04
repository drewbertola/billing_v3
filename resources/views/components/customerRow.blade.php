@php
    $fmt = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
    $balance = $fmt->formatCurrency($customer->balance, 'USD');
    $lastInvDate = empty($customer->lastInvDate) ? '' : date('m/d/Y', strtotime($customer->lastInvDate));
@endphp


<tr id="customerRow{{$customer->id}}"
    @class([
        'archived' => $customer->archive === 'Y',
        'd-none' => $customer->archive === 'Y',
    ])>
    <td>
        <a href="" class="fw-bold text-decoration-none"
            data-bs-toggle="modal"
            data-bs-target="#customerModal"
            hx-get="/customers/edit/{{$customer->id}}"
            hx-trigger="click"
            hx-target="#customerDialog"
            hx-swap="innerHTML"
            title="Update Customer">{{$customer->name}}</a>
    </td>
    <td>{{$customer->primaryContact}}</td>
    <td class="text-center">
        <a href="" class="text-decoration-none"
            hx-post="/invoices"
            hx-vals='{"invoiceId": "{{$customer->lastInvId}}", "_token" : "{{csrf_token()}}"}'
            hx-target="#content"
            hx-trigger="click"
            hx-push-url="true">{{$lastInvDate}}</a>
    </td>
    <td class="text-end">
        <a href="" class="text-decoration-none"
            data-bs-toggle="modal"
            data-bs-target="#customerModal"
            hx-get="/customers/balance/{{$customer->id}}"
            hx-target="#customerDialog"
            hx-trigger="click"
            hx-swap="innerHTML">{{$balance}}</a>
    </td>
    <td class="text-center">
        <a href=""
            hx-post="/invoices"
            hx-vals='{"customerId": "{{$customer->id}}", "_token" : "{{csrf_token()}}"}'
            hx-target="#content"
            hx-trigger="click"
            hx-push-url="true">
            <span class="bi bi-file-earmark-plus-fill text-danger"></span>
        </a>
    </td>
    <td class="text-center">
        <a href=""
            hx-post="/payments"
            hx-vals='{"customerId": "{{$customer->id}}", "_token" : "{{csrf_token()}}"}'
            hx-target="#content"
            hx-trigger="click"
            hx-push-url="true">
            <span class="bi bi-file-earmark-plus-fill text-success"></span>
        </a>
    </td>
</tr>
