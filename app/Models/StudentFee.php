<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StudentFee extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'fee_structure_id', 'fee_discount_id', 'academic_year_id', 'amount_due', 'discount_amount', 'amount_paid', 'balance', 'status', 'due_date'];

    protected $casts = [
        'amount_due' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'balance' => 'decimal:2',
        'due_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function feeStructure(): BelongsTo
    {
        return $this->belongsTo(FeeStructure::class, 'fee_structure_id');
    }

    public function feeDiscount(): BelongsTo
    {
        return $this->belongsTo(FeeDiscount::class, 'fee_discount_id');
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function payments(): HasMany { return $this->hasMany(FeePayment::class); }
    public function invoices(): HasMany { return $this->hasMany(Invoice::class); }
}
