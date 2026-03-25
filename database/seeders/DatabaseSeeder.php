<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Staff;
use App\Models\Student;
use App\Models\StudentEnrolment;
use App\Models\Subject;
use App\Models\Term;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $roles = ['super_admin', 'admin', 'teacher', 'student', 'accountant', 'parent'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // 1. School
        $school = School::create([
            'name'               => 'Demo School',
            'slug'               => 'demo-school',
            'address'            => '123 Education Street, Johannesburg',
            'phone'              => '+27 11 123 4567',
            'email'              => 'admin@demoschool.com',
            'license_key'        => 'DEMO-2025-XXXXXX',
            'license_expires_at' => Carbon::now()->addYear(),
            'license_active'     => true,
        ]);

        // 2. Super Admin (no school_id required)
        $superAdmin = User::create([
            'name'       => 'Super Admin',
            'email'      => 'admin@school.com',
            'password'   => Hash::make('password'),
            'is_active'  => true,
        ]);
        $superAdmin->assignRole('super_admin');

        // 3. Academic Years
        $years = [];
        for ($i = -1; $i <= 1; $i++) {
            $start = Carbon::now()->addYears($i)->startOfYear();
            $end   = $start->copy()->endOfYear();
            $isCurrent = ($i === 0);

            $year    = AcademicYear::create([
                'school_id'  => $school->id,
                'name'       => $start->year . '/' . ($start->year + 1),
                'start_date' => $start,
                'end_date'   => $end,
                'is_current' => $isCurrent,
            ]);
            $years[] = $year;

            Term::create([
                'academic_year_id' => $year->id,
                'name'             => 'Term 1',
                'start_date'       => $start,
                'end_date'         => $start->copy()->addMonths(5),
                'is_current'       => $isCurrent,
            ]);
            Term::create([
                'academic_year_id' => $year->id,
                'name'             => 'Term 2',
                'start_date'       => $start->copy()->addMonths(6),
                'end_date'         => $end,
                'is_current'       => false,
            ]);
        }

        $currentYear = $years[1];

        // 4. Classes & Sections
        $classes = [];
        for ($i = 1; $i <= 5; $i++) {
            $class     = SchoolClass::create([
                'school_id'   => $school->id,
                'name'        => "Grade {$i}",
                'order_index' => $i,
            ]);
            $classes[] = $class;

            foreach (['A', 'B'] as $secName) {
                Section::create([
                    'school_class_id' => $class->id,
                    'name'            => $secName,
                    'capacity'        => 40,
                ]);
            }
        }

        // 5. Subjects
        $subjectNames = ['Mathematics', 'English', 'Science', 'History', 'Geography', 'Art', 'Music', 'Physical Education', 'Computer Science', 'Life Skills'];
        $subjects     = [];
        foreach ($subjectNames as $idx => $subjectName) {
            $subjects[] = Subject::create([
                'school_id'    => $school->id,
                'name'         => $subjectName,
                'code'         => strtoupper(substr($subjectName, 0, 3)) . str_pad($idx + 1, 2, '0', STR_PAD_LEFT),
                'type'         => $idx < 7 ? 'core' : 'elective',
                'credit_hours' => 3,
            ]);
        }

        // 6. Staff (5 total, 3 teachers)
        $staffMembers = [];
        for ($i = 1; $i <= 5; $i++) {
            $isTeacher = ($i <= 3);
            $staffUser = User::create([
                'school_id' => $school->id,
                'name'      => "Staff Member {$i}",
                'email'     => "staff{$i}@school.com",
                'password'  => Hash::make('password'),
                'is_active' => true,
            ]);
            $staffUser->assignRole($isTeacher ? 'teacher' : 'admin');

            $staff          = Staff::create([
                'user_id'         => $staffUser->id,
                'school_id'       => $school->id,
                'staff_number'    => 'STF' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'designation'     => $isTeacher ? 'Teacher' : 'Admin Staff',
                'joining_date'    => Carbon::now()->subYears(2),
                'employment_type' => 'full_time',
                'basic_salary'    => 8000.00,
                'is_teacher'      => $isTeacher,
                'status'          => 'active',
            ]);
            $staffMembers[] = $staff;
        }

        // 7. Students (20)
        $sections = Section::all();
        for ($i = 1; $i <= 20; $i++) {
            $studentUser = User::create([
                'school_id' => $school->id,
                'name'      => "Student {$i}",
                'email'     => "student{$i}@school.com",
                'password'  => Hash::make('password'),
                'is_active' => true,
            ]);
            $studentUser->assignRole('student');

            $student = Student::create([
                'user_id'          => $studentUser->id,
                'school_id'        => $school->id,
                'admission_number' => 'ADM' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'admission_date'   => Carbon::now()->subMonths(6),
                'status'           => 'active',
                'date_of_birth'    => Carbon::now()->subYears(rand(10, 17)),
                'gender'           => $i % 2 === 0 ? 'male' : 'female',
            ]);

            StudentEnrolment::create([
                'student_id'       => $student->id,
                'section_id'       => $sections->random()->id,
                'academic_year_id' => $currentYear->id,
                'status'           => 'active',
            ]);
        }
    }
}
