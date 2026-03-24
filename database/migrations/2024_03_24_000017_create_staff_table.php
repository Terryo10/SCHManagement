<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->string('staff_number')->unique();
            $table->string('designation');
            $table->string('department')->nullable();
            $table->date('joining_date');
            $table->string('employment_type');
            $table->text('qualification')->nullable();
            $table->decimal('basic_salary', 10, 2);
            $table->boolean('is_teacher')->default(false);
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
