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
        // 1. Services Table
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('icon')->default('fa-stethoscope');
            $table->string('badge')->nullable();
            $table->text('short_desc')->nullable();
            $table->json('features')->nullable();
            $table->string('opd_timings')->nullable();
            $table->string('starting_fee')->nullable();
            $table->timestamps();
        });

        // 2. Doctors Table
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('qualification');
            $table->string('role');
            $table->string('experience');
            $table->string('timings');
            $table->string('fee')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Patients Table
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('mr_number')->unique();
            $table->string('name');
            $table->string('age')->nullable();
            $table->string('gender')->default('Female');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->text('medical_notes')->nullable();
            $table->timestamps();
        });

        // 4. Appointments Table
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('token_number')->nullable();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete();
            $table->string('patient_name');
            $table->string('patient_phone')->nullable();
            $table->string('patient_age')->nullable();
            $table->string('patient_gender')->default('Female');
            $table->string('service_name');
            $table->string('doctor_name')->nullable();
            $table->date('appointment_date');
            $table->string('slot')->default('Morning');
            $table->string('status')->default('Waiting'); // Waiting, In-Consultation, Completed, Cancelled
            $table->decimal('fee', 10, 2)->nullable();
            $table->timestamps();
        });

        // 5. Token Queue Table (Real-time OPD Reception Desk)
        Schema::create('token_queues', function (Blueprint $table) {
            $table->id();
            $table->string('token_number');
            $table->string('patient_name');
            $table->string('phone')->nullable();
            $table->string('service');
            $table->string('queue_time');
            $table->string('status')->default('Waiting'); // Waiting, In-Consultation, Completed
            $table->timestamps();
        });

        // 6. Diagnostic Reports Table
        Schema::create('diagnostic_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_id')->unique(); // e.g. REP-101
            $table->string('token_number')->nullable();
            $table->string('mrn')->nullable();
            $table->string('patient_name');
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('doctor')->nullable();
            $table->string('category'); // Laboratory Testing, Ultrasound Services, ECG Services
            $table->string('test_name');
            $table->date('report_date');
            $table->string('status')->default('Ready');
            $table->text('impression')->nullable();
            $table->string('consultant')->nullable();
            $table->timestamps();
        });

        // 7. Report Parameter Items
        Schema::create('report_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnostic_report_id')->constrained('diagnostic_reports')->cascadeOnDelete();
            $table->string('param');
            $table->string('value');
            $table->string('normal_range')->nullable();
            $table->timestamps();
        });

        // 8. Pharmacy Items Table
        Schema::create('pharmacy_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('generic_name')->nullable();
            $table->string('category')->default('General');
            $table->integer('stock_qty')->default(0);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacy_items');
        Schema::dropIfExists('report_items');
        Schema::dropIfExists('diagnostic_reports');
        Schema::dropIfExists('token_queues');
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('services');
    }
};
