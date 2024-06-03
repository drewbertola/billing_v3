<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64)->nullable(false)->default('');
            $table->string('bAddress1', 64)->nullable(false)->default('');
            $table->string('bAddress2', 64)->nullable(false)->default('');
            $table->string('bCity', 32)->nullable(false)->default('');
            $table->string('bState', 32)->nullable(false)->default('');
            $table->string('bZip', 16)->nullable(false)->default('');
            $table->string('sAddress1', 64)->nullable(false)->default('');
            $table->string('sAddress2', 64)->nullable(false)->default('');
            $table->string('sCity', 32)->nullable(false)->default('');
            $table->string('sState', 32)->nullable(false)->default('');
            $table->string('sZip', 16)->nullable(false)->default('');
            $table->string('phoneMain', 16)->nullable(false)->default('');
            $table->string('fax', 16)->nullable(false)->default('');
            $table->string('billingContact', 32)->nullable(false)->default('');
            $table->string('billingEmail', 64)->nullable(false)->default('');
            $table->string('billingPhone', 16)->nullable(false)->default('');
            $table->string('primaryContact', 32)->nullable(false)->default('');
            $table->string('primaryEmail', 64)->nullable(false)->default('');
            $table->string('primaryPhone', 16)->nullable(false)->default('');
            $table->decimal('taxRate', 4, 2)->nullable(false)->default(0.00);
            $table->enum('archive', ['Y', 'N'])->nullable(false)->default('N');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
