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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transactionId');
            $table->foreign('transactionId')->references('id')->on('transactions')->cascadeOnDelete();

            $table->foreignId('cakeId');
            $table->foreign('cakeId')->references('id')->on('cakes')->cascadeOnDelete();
            
            $table->bigInteger('price')->nullable();
            $table->integer('quantity')->default(1);
            $table->bigInteger('discount')->nullable();

            $this->getDefaultTimestamps($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
