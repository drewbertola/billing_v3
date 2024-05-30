@php
    $fmt = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
    $totalInv = $fmt->formatCurrency($invTotal, 'USD');
    $totalPmt = $fmt->formatCurrency($pmtTotal, 'USD');
    $balance = $fmt->formatCurrency($invTotal + $pmtTotal, 'USD');
@endphp

<x-layout :isHtmxRequest=$isHtmxRequest>
    @guest
        <x-loginForm />
    @endguest

    @auth
        <div class="table-responsive col-md-8 mx-auto">
            <p>Balance Sheet for <span class="fw-bold">{{$customerName}}</span></p>
            <table class="table table-sm table-bordered table-hover rounded">
                <thead>
                    <tr>
                        <th class="text-center">Trans Type</th>
                        <th class="text-center">#</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Invoiced</th>
                        <th class="text-center">Paid</th>
                        <th class="text-center">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <x-customerBalanceRow :trans=$transaction />
                    @endforeach
                </tbody>
                <tfoot>
                    <th colspan="3">Totals:</th>
                    <th class="text-end">{{$totalInv}}</th>
                    <th class="text-end">{{$totalPmt}}</th>
                    <th class="text-end">{{$balance}}</th>
                </tfoot>
            </table>
        </div>



    @endauth
</x-layout>
