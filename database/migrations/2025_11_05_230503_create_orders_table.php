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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->foreignId('address_id')->nullable()->constrained('addresses')->onDelete('set null');
            $table->foreignId('shipping_rate_id')->nullable()->constrained('shipping_rates')->onDelete('set null');
            $table->foreignId('pickup_location_id')->nullable()->constrained('pickup_locations')->onDelete('set null');
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods')->onDelete('set null');
            $table->foreignId('order_status_id')->nullable()->constrained('order_statuses')->onDelete('set null');
            $table->string('source')->nullable();
            $table->boolean('is_cod')->default(false);
            $table->decimal('cod_amount', 10, 2)->nullable();
            $table->decimal('cod_fee', 10, 2)->nullable();
            $table->string('cod_type')->nullable();
            $table->decimal('subtotal_amount', 10, 2);
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('shipping_fee', 10, 2)->nullable();
            $table->decimal('tax_rate', 10, 2)->nullable();
            $table->decimal('tax_amount', 10, 2)->nullable();
            $table->decimal('points_used', 10, 2)->nullable();
            $table->decimal('points_rate', 10, 2)->nullable();
            $table->decimal('points_to_cash', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->string('coupon_code')->nullable();
            $table->text('admin_notes')->nullable();
            $table->text('client_notes')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('device_info')->nullable();
            $table->boolean('is_done')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->boolean('has_returned_items')->default(false);
            $table->boolean('is_canceled')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
