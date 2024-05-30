<x-layout :isHtmxRequest=$isHtmxRequest>
    @guest
        <x-loginForm />
    @endguest

    @auth
        <div class="mx-auto mt-4">
            <div class="clearfix">
                <p class="float-start me-4">Invoices</p>

                <a href="" class="float-end"
                    hx-get="/invoices/edit/0"
                    hx-target="#content"
                    hx-push-url="true"
                    title="Add Invoice"
                ><span class="bi bi-file-earmark-plus-fill fs-4"></span></a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mx-auto mb-5" id="customerTable">
                    <thead>
                        <th class="text-center">Invoice #</th>
                        <th class="text-center">Customer</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Sent</th>
                        <th class="text-center">PDF</th>
                        <th class="text-center">View</th>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                            <x-invoiceRow :invoice=$invoice />
                        @endforeach
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
    @endauth
</x-layout>
