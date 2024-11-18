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
        Schema::create('cake_ingridients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cakeId');
            $table->foreign('cakeId')->references('id')->on('cakes')->constrained()->onDelete('cascade');
            $table->foreignId('ingridientId');
            $table->foreign('ingridientId')->references('id')->on('ingridients')->constrained()->onDelete('cascade');
            
            $table->integer('quantity');
            $table->string('unit');
            $this->getDefaultTimestamps($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cake_ingridients');
    }
};
