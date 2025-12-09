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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->text('details')->nullable();
            $table->string('discount_type')->default('fixed');
            $table->decimal('discount_value')->default(0);
            $table->integer('min_order_value')->default(0);
            $table->integer('max_discount_value')->default(0);
            $table->integer('usage_limit')->default(100);
            $table->integer('usage_limit_client')->default(1);
            $table->integer('used_times')->default(0);
            $table->boolean('is_active')->default(true);
            $table->date('start_date')->default(now());
            $table->date('end_date')->default(now()->addMonth(1));
            $table->text('products')->nullable();
            $table->text('categories')->nullable();
            $table->text('brands')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
