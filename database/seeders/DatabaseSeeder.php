<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\User;
use App\Models\AcademicYear;
use App\Models\Term;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Staff;
use App\Models\Student;
use App\Models\StudentEnrolment;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. School
        $school = School::create([
            'name' => 'Demo School',
            'slug' => 'demo-school',
            'address' => '123 Education St',
            'phone' => '1234567890',
            'email' => 'admin@demoschool.com',
            'license_key' => 'DEMO-123',
            'license_expires_at' => Carbon::now()->addYear(),
            'license_active' => true,
        ]);

        // 2. Admin User
        $admin = User::create([
            'school_id' => $school->id,
            'name' => 'Super Admin',
            'email' => 'admin@school.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        // 3. Academic Years (3 years)
        $years = [];
        for ($i = -1; $i <= 1; $i++) {
            $start = Carbon::now()->addYears($i)->startOfYear();
            $end = $start->copy()->endOfYear();
            $isCurrent = ($i === 0);
            
            $year = AcademicYear::create([
                'school_id' => $school->id,
                'name' => $start->year . '/' . ($start->year + 1),
                'start_date' => $start,
                'end_date' => $end,
                'is_current' => $isCurrent,
            ]);
            $years[] = $year;

            // 4. Terms (2 per year)
            Term::create([
                'academic_year_id' => $year->id,
                'name' => 'Term 1',
                'start_date' => $start,
                'end_date' => $start->copy()->addMonths(5),
                'is_current' => $isCurrent,
            ]);
            Term::create([
                'academic_year_id' => $year->id,
                'name' => 'Term 2',
                'start_date' => $start->copy()->addMonths(6),
                'end_date' => $end,
                'is_current' => false,
            ]);
        }

        $currentYear = $years[1]; // The one with is_current = true

        // 5. Classes (5)
        for ($i = 1; $i <= 5; $i++) {
            $class = SchoolClass::create([
                'school_id' => $school->id,
                'name' => "Class {$i}",
                'order_index' => $i,
            ]);

            // Sections (2 per class)
            foreach (['A', 'B'] as $secName) {
                Section::create([
                    'school_class_id' => $class->id,
                    'name' => $secName,
                    'capacity' => 40,
                ]);
            }
        }

        // 6. Subjects (10)
        $subjects = [];
        for ($i = 1; $i <= 10; $i++) {
            $subjects[] = Subject::create([
                'school_id' => $school->id,
                'name' => "Subject {$i}",
                'code' => "SUB0{$i}",
                'type' => $i <= 7 ? 'core' : 'elective',
                'credit_hours' => 3,
            ]);
        }

        // 7. Staff (5 total, 3 teachers)
        $staffMembers = [];
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'school_id' => $school->id,
                'name' => "Staff Member {$i}",
                'email' => "staff{$i}@school.com",
                'password' => Hash::make('password'),
            ]);

            $isTeacher = ($i <= 3);
            $staff = Staff::create([
                'user_id' => $user->id,
                'school_id' => $school->id,
                'staff_number' => "STF00{$i}",
                'designation' => $isTeacher ? 'Teacher' : 'Admin Staff',
                'joining_date' => Carbon::now()->subYears(2),
                'employment_type' => 'permanent',
                'basic_salary' => 3000.00,
                'is_teacher' => $isTeacher,
                'status' => 'active',
            ]);
            $staffMembers[] = $staff;
        }

        // 8. Students (20)
        $sections = Section::all();
        for ($i = 1; $i <= 20; $i++) {
            $user = User::create([
                'school_id' => $school->id,
                'name' => "Student {$i}",
                'email' => "student{$i}@school.com",
                'password' => Hash::make('password'),
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'school_id' => $school->id,
                'admission_number' => "ADM" . str_pad($i, 4, '0', STR_PAD_LEFT),
                'admission_date' => Carbon::now()->subMonths(6),
                'status' => 'active',
                'date_of_birth' => Carbon::now()->subYears(10),
                'gender' => $i % 2 == 0 ? 'male' : 'female',
            ]);

            // Enrolment
            StudentEnrolment::create([
                'student_id' => $student->id,
                'section_id' => $sections->random()->id,
                'academic_year_id' => $currentYear->id,
                'status' => 'active',
            ]);
        }
    }
}
