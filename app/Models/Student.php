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

class Student extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = ['user_id', 'school_id', 'admission_number', 'admission_date', 'status', 'blood_group', 'date_of_birth', 'gender', 'religion', 'nationality', 'medical_notes', 'qr_code'];

    protected $casts = [
        'admission_date' => 'date',
        'date_of_birth' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function enrolments(): HasMany { return $this->hasMany(StudentEnrolment::class); }
    public function attendances(): HasMany { return $this->hasMany(Attendance::class); }
    public function marks(): HasMany { return $this->hasMany(Mark::class); }
    public function fees(): HasMany { return $this->hasMany(StudentFee::class); }
    public function submissions(): HasMany { return $this->hasMany(AssignmentSubmission::class); }
    public function guardians(): BelongsToMany { return $this->belongsToMany(Guardian::class, "student_guardian")->withPivot("is_primary"); }
    public function scopeActive($query) { return $query->where("status", "active"); }
}
