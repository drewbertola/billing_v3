@php
    $id = str_pad($trans['id'], 6, '0', STR_PAD_LEFT);
    $fmt = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
    $amount = $fmt->formatCurrency($trans['amount'], 'USD');
    $balance = $fmt->formatCurrency($trans['balance'], 'USD');
    $date = date('m/d/Y', strtotime($trans['date']));
@endphp

<tr>
    <td>{{$trans['type']}}</td>
    <td class="text-end">{{$id}}</td>
    <td class="text-end">{{$date}}</td>
    <td class="text-end">
        @if ($trans['type'] === 'Invoice')
            {{$amount}}
        @endif
    </td>
    <td class="text-end">
        @if ($trans['type'] === 'Payment')
            {{$amount}}
        @endif
    </td>
    <td class="text-end">{{$balance}}</td>
</tr>
