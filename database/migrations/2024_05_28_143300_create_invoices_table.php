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
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customerId')->nullable(false)->default(0);
            $table->decimal('amount', 10, 2)->nullable(false)->default(0.00);
            $table->date('date')->nullable(false)->default('2000-01-01');
            $table->enum('emailed', ['Y', 'N'])->nullable(false)->default('N');
            $table->text('note')->nullable(false)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
