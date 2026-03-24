<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Staff extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;
    protected $table = 'staff';

    protected $fillable = ['user_id', 'school_id', 'staff_number', 'designation', 'department', 'joining_date', 'employment_type', 'qualification', 'basic_salary', 'is_teacher', 'status'];

    protected $casts = [
        'joining_date' => 'date',
        'basic_salary' => 'decimal:2',
        'is_teacher' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function timetables(): HasMany { return $this->hasMany(Timetable::class, "teacher_id"); }
    public function markedAttendances(): HasMany { return $this->hasMany(Attendance::class, "staff_id"); }
    public function markedMarks(): HasMany { return $this->hasMany(Mark::class, "teacher_id"); }
    public function leaveRequests(): HasMany { return $this->hasMany(LeaveRequest::class); }
    public function payrolls(): HasMany { return $this->hasMany(Payroll::class); }
    public function issuedBooks(): HasMany { return $this->hasMany(BookIssue::class, "staff_id"); }
}
