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
        Schema::create('shippers', function (Blueprint $table) {
            $table->id();
            $table->string('carrier_name');
            $table->text('api_endpoint');
            $table->text('api_key');
            $table->text('api_secret')->nullable();
            $table->text('api_password')->nullable();
            $table->string('delivery_time');
            $table->string('delivery_days');
            $table->float('cod_fee')->default(0);
            $table->string('cod_fee_type')->default('fixed');
            $table->float('cod_min');
            $table->float('cod_max');
            $table->boolean('is_support_cod')->default(1);
            $table->boolean('is_active')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippers');
    }
};
