<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_enrolments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->string('status')->default('active');
            $table->boolean('is_promoted')->default(false);
            $table->unique(['student_id', 'section_id', 'academic_year_id'], 'enrolments_unique');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_enrolments');
    }
};
