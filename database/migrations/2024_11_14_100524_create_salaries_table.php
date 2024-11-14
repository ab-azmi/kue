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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->string('basic_salary');
            $table->string('tax')->nullable();
            $table->string('overtime')->nullable();
            $table->string('total_salary');

            $table->foreignId('userId');
            $table->foreign('userId')->references('id')->on('users')->cascadeOnDelete();
            $this->getDefaultTimestamps($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
