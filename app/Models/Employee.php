<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'department',
        'designation',
        'email',
        'phone',
        'status',
        'rfid_tag',
        'biometric_code',
        'hire_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'hire_date' => 'date',
        'status' => 'string',
    ];

    /**
     * Get the user associated with the employee.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attendances for the employee.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the employee's full name through the user relationship.
     */
    public function getFullNameAttribute(): string
    {
        return $this->user ? $this->user->name : 'N/A';
    }

    /**
     * Check if employee is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'Active';
    }
}
