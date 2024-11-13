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
        Schema::create('cakes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('profit_margin')->nullable();
            $table->string('cogs');
            $table->string('sell_price');
            $table->json('images')->nullable();

            $table->foreignId('cake_variant_id')->constrained();
            $this->getDefaultTimestamps($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cakes');
    }
};
