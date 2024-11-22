<?php

use Database\Migrations\Traits\HasCustomMigration;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use HasCustomMigration;


    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaction_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transactionId');
            $table->foreign('transactionId')->references('id')->on('transactions')->cascadeOnDelete();

            $table->foreignId('cakeVariantId');
            $table->foreign('cakeVariantId')->references('id')->on('cake_variants')->cascadeOnDelete();
            
            $table->integer('quantity')->default(1);
            $table->float('price')->nullable();
            $table->float('discount')->nullable();
            $table->float('totalPrice')->nullable();

            $this->getDefaultTimestamps($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_orders');
    }
};
