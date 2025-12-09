<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the existing foreign key constraint
        Schema::table('order_item_options', function (Blueprint $table) {
            $table->dropForeign(['bundle_item_id']);
        });

        // Add the new foreign key with nullOnDelete
        Schema::table('order_item_options', function (Blueprint $table) {
            $table->foreign('bundle_item_id')->references('id')->on('bundle_items')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the new foreign key
        Schema::table('order_item_options', function (Blueprint $table) {
            $table->dropForeign(['bundle_item_id']);
        });

        // Restore the old foreign key with restrictOnDelete
        Schema::table('order_item_options', function (Blueprint $table) {
            $table->foreign('bundle_item_id')->references('id')->on('bundle_items')->restrictOnDelete();
        });
    }
};
