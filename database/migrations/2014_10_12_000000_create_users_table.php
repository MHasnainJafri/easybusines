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
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phonenumber')->unique()->nullable();
            $table->string('image')->nullable();
            // $table->timestamp('email_verified_at')->nullable();
            // $table->string('password')->nullable();
            // $table->rememberToken();
            $table->integer('amount')->default('0');
            $table->integer('status')->default('0');
            $table->string('referal_code')->nullable();
            $table->string('referal_id')->nullable();
            $table->string('pin')->nullable();
            $table->string('confirm_pin')->nullable();
            $table->string('otp')->nullable();

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
