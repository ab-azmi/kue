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
            $table->integer('stock')->default(0);
            $table->float('profitMargin')->nullable();
            $table->float('COGS')->nullable();
            $table->float('sellingPrice')->nullable();
            $table->json('images')->nullable();

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
