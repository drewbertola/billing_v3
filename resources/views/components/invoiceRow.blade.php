@php
    $id = '#' . str_pad($invoice->id, 6, '0', STR_PAD_LEFT);
    $fmt = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
    $amount = $fmt->formatCurrency($invoice->amount, 'USD');
    $date = date('m/d/Y', strtotime($invoice->date));
@endphp

<tr id="dataRow{{$invoice['id']}}">
    <td class="text-end">{{$id}}</td>
    <td>{{$invoice->customer->name}}</td>
    <td class="text-end">{{$date}}</td>
    <td class="text-end">{{$amount}}</td>
    <td class="text-center">
        <a href=""
            hx-get="/invoices/toggle-emailed/{{$invoice['id']}}"
            hx-target="#dataRow{{$invoice['id']}}"
            hx-trigger="click"
            hx-swap="outerHTML">
            <span @class([
                    'bi',
                    'bi-envelope-fill',
                    'text-success' => $invoice['emailed'] === 'Y',
                    'text-secondary' => $invoice['emailed'] === 'N',
                ])></span>
        </a>
    </td>
    <td class="text-center">
        <a href="/invoices/pdf/{{$invoice->id}}" target="_blank">
            <span class="bi bi-file-pdf-fill text-primary"></span>
        </a>
    </td>
    <td class="text-center">
        <a href=""
            hx-get="/invoices/edit/{{$invoice->id}}"
            hx-target="#content"
            hx-trigger="click"
            hx-push-url="true">
            <span class="bi bi-pencil-fill text-danger"></span>
        </a>
    </td>

</tr>
