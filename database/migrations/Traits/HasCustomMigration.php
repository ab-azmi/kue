<?php

namespace Database\Migrations\Traits;

use Illuminate\Database\Schema\Blueprint;

trait HasCustomMigration
{
    /**
     * @return void
     */
    public function getDefaultTimestamps(Blueprint $table)
    {
        $table->timestamp('createdAt')->nullable();
        $table->timestamp('updatedAt')->nullable();
        $table->softDeletes('deletedAt');
    }

    /**
     * @return void
     */
    public function getDefaultCreatedBy(Blueprint $table)
    {
        $table->char('createdBy')->nullable();
        $table->string('createdByName')->nullable();
    }
}
