<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->string('admission_number')->unique();
            $table->date('admission_date');
            $table->string('status')->default('active');
            $table->string('blood_group')->nullable();
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('religion')->nullable();
            $table->string('nationality')->nullable();
            $table->text('medical_notes')->nullable();
            $table->string('qr_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
