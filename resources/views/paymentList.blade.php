<x-layout :isHtmxRequest=$isHtmxRequest>
    @guest
        <x-loginForm />
    @endguest

    @auth
        <div class="modal fade modal-lg" id="paymentModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body" id="paymentDialog">
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-auto mt-4">
            <div class="clearfix">
                <p class="float-start me-4">Payments</p>
                <a href="" class="float-end"
                    data-bs-toggle="modal"
                    data-bs-target="#paymentModal"
                    hx-get="/payments/edit/0"
                    hx-target="#paymentDialog"
                    title="Add Payment"
                ><span class="bi bi-file-earmark-plus-fill fs-4"></span></a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mx-auto mb-5" id="paymentTable">
                    <thead>
                        <th class="text-center">Payment #</th>
                        <th class="text-center">Customer</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Method</th>
                        <th class="text-center">Number</th>
                        <th class="text-center">View</th>
                    </thead>
                    <tbody>
                        <tr id="paymentRow0"></tr>
                        @foreach ($payments as $payment)
                            <x-paymentRow :payment=$payment />
                        @endforeach
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
    @endauth
</x-layout>
