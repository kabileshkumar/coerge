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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            
            // Personal Information
            $table->string('full_name');
            $table->string('email');
            $table->string('phone_code');
            $table->string('mobile_number');
            $table->string('password');
            
            // Appointment Details
            $table->string('appointment_type');
            $table->text('symptoms')->nullable();
            $table->string('preferred_doctor')->nullable();
            $table->string('preferred_time')->nullable();
            $table->date('preferred_date')->nullable();
            $table->text('additional_notes')->nullable();
            
            // Medical Information
            $table->text('medical_history')->nullable();
            $table->text('current_medications')->nullable();
            
            // Payment Information
            $table->decimal('appointment_fee', 8, 2)->default(0);
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('payment_transaction_id')->nullable();
            
            // Status and Metadata
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->json('terms_conditions')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['email', 'status']);
            $table->index('preferred_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
