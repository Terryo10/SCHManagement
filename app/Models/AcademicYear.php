<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = ['school_id', 'name', 'start_date', 'end_date', 'is_current'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function terms(): HasMany { return $this->hasMany(Term::class); }
    public function enrolments(): HasMany { return $this->hasMany(StudentEnrolment::class); }
    public function classSubjects(): HasMany { return $this->hasMany(ClassSubject::class); }
    public function exams(): HasMany { return $this->hasMany(Exam::class); }
    public function fees(): HasMany { return $this->hasMany(StudentFee::class); }
    public function payrolls(): HasMany { return $this->hasMany(Payroll::class); }
    public function scopeCurrent($query) { return $query->where("is_current", true); }
}
