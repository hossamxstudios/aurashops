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
        Schema::create('return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('return_order_id')->constrained('return_orders')->cascadeOnDelete();
            $table->foreignId('order_item_id')->constrained('order_items')->cascadeOnDelete();
            $table->foreignId('reason_id')->constrained('return_reasons')->cascadeOnDelete();
            $table->text('details')->nullable();
            $table->float('refund_amount')->default(0);
            $table->boolean('is_approved')->nullable();
            $table->float('unit_price')->default(0);
            $table->integer('qty')->default(1);
            $table->float('subtotal')->default(1);
            $table->boolean('is_refunded')->default(0);
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
        Schema::dropIfExists('return_items');
    }
};
