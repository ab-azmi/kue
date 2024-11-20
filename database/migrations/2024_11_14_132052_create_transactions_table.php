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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employeeId');
            $table->foreign('employeeId')->references('id')->on('employees')->cascadeOnDelete();

            $table->integer('quantity')->nullable();
            $table->string('code')->nullable();
            $table->float('tax')->nullable();
            $table->float('orderPrice')->nullable();
            $table->float('totalPrice')->nullable();
            $table->float('totalDiscount')->nullable();
            $this->getDefaultTimestamps($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
