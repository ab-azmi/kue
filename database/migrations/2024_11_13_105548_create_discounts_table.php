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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->date('start_date')->default(now());
            $table->date('end_date')->default(now()->addDay());
            $table->string('value');

            $table->foreignId('cakeId');
            $table->foreign('cakeId')->references('id')->on('cakes')->cascadeOnDelete();
            $this->getDefaultTimestamps($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
