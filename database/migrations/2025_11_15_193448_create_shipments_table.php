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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('shipper_id')->nullable()->constrained('shippers')->cascadeOnDelete();
            $table->foreignId('pickup_location_id')->nullable()->constrained('pickup_locations')->cascadeOnDelete();
            $table->foreignId('address_id')->nullable()->constrained('addresses')->cascadeOnDelete();
            $table->string('tracking_number')->nullable();
            $table->string('status')->default('pending');
            $table->text('carrier_metadata')->nullable();
            $table->datetime('picked_up_at')->nullable();
            $table->datetime('out_for_delivery_at')->nullable();
            $table->datetime('delivered_at')->nullable();
            $table->datetime('failed_at')->nullable();
            $table->datetime('returned_at')->nullable();
            $table->datetime('cancelled_at')->nullable();
            $table->datetime('estimated_delivery_at')->nullable();
            $table->float('cod_amount')->nullable();
            $table->float('cod_collected')->nullable();
            $table->datetime('cod_collected_at')->nullable();
            $table->float('cod_fee')->nullable();
            $table->float('shipping_fee')->nullable();
            $table->text('carrier_response')->nullable();
            $table->text('webhook_data')->nullable();
            $table->string('failed_reason')->nullable();
            $table->string('client_notes')->nullable();
            $table->string('carrier_notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
