<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class School extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'logo', 'address', 'phone', 'email', 'license_key', 'license_expires_at', 'license_active', 'settings'];

    protected $casts = [
        'license_expires_at' => 'date',
        'license_active' => 'boolean',
        'settings' => 'array',
    ];

    public function users(): HasMany { return $this->hasMany(User::class); }
    public function academicYears(): HasMany { return $this->hasMany(AcademicYear::class); }
    public function schoolClasses(): HasMany { return $this->hasMany(SchoolClass::class); }
    public function subjects(): HasMany { return $this->hasMany(Subject::class); }
    public function rooms(): HasMany { return $this->hasMany(Room::class); }
    public function staff(): HasMany { return $this->hasMany(Staff::class); }
    public function students(): HasMany { return $this->hasMany(Student::class); }
    public function feeStructures(): HasMany { return $this->hasMany(FeeStructure::class); }
    public function exams(): HasMany { return $this->hasMany(Exam::class); }
    public function books(): HasMany { return $this->hasMany(Book::class); }
    public function vehicles(): HasMany { return $this->hasMany(Vehicle::class); }
    public function notifications(): HasMany { return $this->hasMany(Notification::class); }
}
