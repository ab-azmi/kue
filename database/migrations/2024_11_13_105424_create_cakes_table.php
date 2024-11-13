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
            $table->string('profitMargin')->nullable();
            $table->string('cogs')->nullable();
            $table->string('sellPrice');
            $table->json('images')->nullable();

            $table->foreignId('cakeVariantId');
            $table->foreign('cakeVariantId')->references('id')->on('cake_variants')->constrained()->onDelete('cascade');
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
