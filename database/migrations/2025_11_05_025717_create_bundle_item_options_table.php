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
        Schema::create('bundle_item_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bundle_item_id')->constrained('bundle_items')->cascadeOnDelete();
            $table->foreignId('variant_id')->constrained('variants')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bundle_item_options');
    }
};
