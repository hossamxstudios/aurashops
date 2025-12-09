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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referred_by_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->foreignId('skin_tone_id')->nullable()->constrained('skin_tones')->onDelete('set null');
            $table->foreignId('skin_type_id')->nullable()->constrained('skin_types')->onDelete('set null');
            $table->string('first_name')->default('First Name');
            $table->string('last_name')->default('Last Name');
            $table->string('phone')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('gender')->nullable()->default('male');
            $table->date('birthdate')->nullable();
            $table->string('code')->nullable();
            $table->boolean('is_blocked')->default(0);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
