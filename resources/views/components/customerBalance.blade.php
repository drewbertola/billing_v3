@php
    $fmt = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
    $totalInv = $fmt->formatCurrency($invTotal, 'USD');
    $totalPmt = $fmt->formatCurrency($pmtTotal, 'USD');
    $balance = $fmt->formatCurrency($invTotal + $pmtTotal, 'USD');
@endphp

@guest
    <x-loginForm />
@endguest

@auth
    <div class="table-responsive m-4">
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
        <button class="btn btn-secondary float-end" data-bs-dismiss="modal">Close</button>
    </div>



@endauth
