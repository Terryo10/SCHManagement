<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TransportRoute extends Model
{
    use HasFactory;

    protected $fillable = ['school_id', 'vehicle_id', 'name', 'start_point', 'end_point', 'fee_amount'];

    protected $casts = [
        'fee_amount' => 'decimal:2',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function stops(): HasMany { return $this->hasMany(RouteStop::class); }
    public function studentTransport(): HasMany { return $this->hasMany(StudentTransport::class); }
}
