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
        Schema::create('line_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoiceId')->nullable(false)->default(0);
            $table->bigInteger('partId')->nullable(true)->default(0);
            $table->decimal('price', 10, 2)->nullable(false)->default(0.00);
            $table->string('units', 16)->nullable(false)->default('');
            $table->decimal('quantity', 6, 2)->nullable(false)->default(0.00);
            $table->enum('taxable', ['Y', 'N'])->nullable(false)->default('N');
            $table->decimal('discount', 4, 2)->nullable(false)->default(0.00);
            $table->string('description', 64)->nullable(false)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_item');
    }
};
