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
        Schema::create('ingridients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit');
            $table->bigInteger('pricePerUnit');
            $table->string('expirationDate');
            $table->integer('quantity');
            $table->string('supplier')->nullable();
            $this->getDefaultTimestamps($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingridients');
    }
};
