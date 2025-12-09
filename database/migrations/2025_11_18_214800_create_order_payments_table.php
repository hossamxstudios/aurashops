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
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('payment_method_id')->constrained('payment_methods')->cascadeOnDelete();
            $table->foreignId('shipment_id')->nullable()->constrained('shipments')->cascadeOnDelete();
            $table->foreignId('bank_account_id')->nullable()->constrained('bank_accounts')->cascadeOnDelete();
            $table->string('transaction_id')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('gateway_name')->nullable();
            $table->text('gateway_response')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('paid', 10, 2)->default(0);
            $table->decimal('rest', 10, 2)->default(0);
            $table->decimal('collection_fee', 10, 2)->default(0);
            $table->decimal('net_amount', 10, 2)->default(0);
            $table->string('remittance_status')->default('pending');
            $table->text('remittance_reference')->nullable();
            $table->string('remittance_date')->default(now());
            $table->boolean('is_done')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
