<x-layout :isHtmxRequest=$isHtmxRequest>
    @guest
        <x-loginForm />
    @endguest

    @auth
        <div class="modal fade modal-lg" id="invoiceModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body" id="invoiceDialog">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-lg" id="lineItemModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body" id="lineItemDialog">
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-auto mt-4">
            <div class="clearfix">
                <p class="float-start me-4">Invoices</p>

                <a href="" class="float-end"
                    data-bs-toggle="modal"
                    data-bs-target="#invoiceModal"
                    hx-get="/invoices/edit/0"
                    hx-target="#invoiceDialog"
                    hx-trigger="click"
                    hx-swap="innerHTML"
                    title="Add Invoice"
                ><span class="bi bi-file-earmark-plus-fill fs-4"></span></a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mx-auto mb-5" id="invoiceTable">
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
                        <tr id="invoiceRow0"></tr>
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
