<x-layout :isHtmxRequest=$isHtmxRequest>
    @guest
        <x-loginForm />
    @endguest

    @auth
        <div class="modal fade modal-lg" id="customerModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body" id="customerDialog">
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-auto mt-4">
            <div class="clearfix">
                <p class="float-start me-4">Customers</p>
                <div class="form-check form-check-inline form-switch ml-5">
                    <input class="form-check-input mr-3"
                        id="showArchived"
                        type="checkbox"
                        onclick="billing.toggleShowArchived()"
                    />
                    <label class="form-check-label" for="showArchived">Show Archived</label>
                </div>
                <a href="" class="float-end"
                    data-bs-toggle="modal"
                    data-bs-target="#customerModal"
                    hx-get="/customers/edit/0"
                    hx-trigger="click"
                    hx-target="#customerDialog"
                    hx-swap="innerHTML"
                    title="Add Customer"
                ><span class="bi bi-file-earmark-plus-fill fs-4"></span></a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mx-auto mb-5" id="customerTable">
                    <thead>
                        <th class="text-center">Customer</th>
                        <th class="text-center">Primary Contact</th>
                        <th class="text-center">Last Invoice</th>
                        <th class="text-center">Balance</th>
                        <th class="text-center">Inv</th>
                        <th class="text-center">Pmt</th>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <x-customerRow :customer=$customer />
                        @endforeach
                        <tr id="customerRow0"></tr>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
    @endauth
</x-layout>
