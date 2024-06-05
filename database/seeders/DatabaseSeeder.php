<?php

namespace Database\Seeders;

use App\Http\Controllers\LineItemController;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\LineItem;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // add some customers
        Customer::factory()->count(9)->create();

        // add some payments
        Payment::factory()->count(60)->create();

        // add some invoices
        Invoice::factory()->count(60)->create();

        // add some tasks
        LineItem::factory()->count(180)->create();

        // update invoice amounts
        foreach(Invoice::all() as $invoice) {
            LineItemController::updateInvoiceAmount($invoice->id);
        }
    }
}
