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
        Schema::create('return_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('address_id')->constrained('addresses')->cascadeOnDelete();
            $table->foreignId('dropoff_location_id')->constrained('pickup_locations')->cascadeOnDelete();
            $table->string('status')->default('pending');
            $table->float('total_refund_amount')->default(0);
            $table->float('return_fee')->default(0);
            $table->float('shipping_fee')->default(0);
            $table->text('details')->nullable();
            $table->boolean('is_refunded')->default(0);
            $table->boolean('is_all_approved')->nullable();
            $table->text('admin_notes')->nullable();
            $table->text('client_notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_orders');
    }
};
