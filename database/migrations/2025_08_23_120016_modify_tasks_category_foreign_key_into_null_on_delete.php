<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['category_id']);

            $table->foreignId('category_id')->nullable()->change();

            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('tasks', function (Blueprint $table) {
            // Drop the current foreign key
            $table->dropForeign(['category_id']);

            // Make category_id not nullable again
            $table->foreignId('category_id')->nullable(false)->change();

            // Restore the original cascade delete constraint
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
        });
    }
};
