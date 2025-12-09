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
        Schema::create('cart_item_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_item_id')->constrained('cart_items')->cascadeOnDelete();
            $table->foreignId('bundle_item_id')->constrained('bundle_items')->restrictOnDelete();
            $table->foreignId('child_product_id')->nullable()->constrained('products')->restrictOnDelete();
            $table->foreignId('child_variant_id')->nullable()->constrained('variants')->restrictOnDelete();
            $table->string('type')->default('simple');
            $table->integer('qty')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_item_options');
    }
};
