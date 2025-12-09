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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->foreignId('gender_id')->nullable()->constrained('genders')->nullOnDelete();
            $table->string('sku')->nullable();
            $table->string('type')->default('simple');
            $table->string('name');
            $table->string('slug');
            $table->text('details');
            $table->float('rating')->nullable();
            $table->float('base_price')->nullable();
            $table->float('price')->nullable();
            $table->float('sale_price')->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('orders_count')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_desc')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_featured')->default(0);
            $table->boolean('is_stockable')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
