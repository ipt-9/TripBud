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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('theme')->default('light');
            $table->string('language')->default('en');
            $table->boolean('notifications')->default(true);
            $table->string('profile_image')->default('default');
            $table->enum('subscription_plan', ['free', 'premium', 'business'])->default('free');
            $table->enum('payment_method', ['credit_card', 'paypal', 'bank_transfer'])->nullable();
            $table->string('payment_method_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
