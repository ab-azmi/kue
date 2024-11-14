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
            $table->bigInteger('cogs')->nullable();
            $table->bigInteger('sellPrice')->nullable();
            $table->json('images')->nullable();
            $table->integer('stock')->default(0);

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
