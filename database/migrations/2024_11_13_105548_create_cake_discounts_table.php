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
        Schema::create('cake_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cakeId');
            $table->foreign('cakeId')->references('id')->on('cakes')->cascadeOnDelete();

            $table->string('name');
            $table->date('fromDate');
            $table->date('toDate');
            $table->float('value');
            $table->text('description')->nullable();

            $this->getDefaultTimestamps($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cake_discounts');
    }
};
