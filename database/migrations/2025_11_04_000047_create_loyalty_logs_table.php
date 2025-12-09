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
        Schema::create('loyalty_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loyalty_account_id')->constrained('loyalty_accounts')->cascadeOnDelete();
            $table->string('reference_id')->nullable();
            $table->string('reference_type')->nullable();
            $table->string('type')->nullable();
            $table->float('points_before')->default(0);
            $table->float('points')->default(0);
            $table->float('points_after')->default(0);
            $table->date('expires_at')->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_logs');
    }
};
