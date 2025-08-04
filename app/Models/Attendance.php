<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'date',
        'clock_in',
        'clock_out',
        'status',
        'notes',
        'work_hours',
        'overtime_hours',
        'late_minutes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'clock_in' => 'datetime',
        'clock_out' => 'datetime',
        'work_hours' => 'decimal:2',
        'overtime_hours' => 'decimal:2',
        'late_minutes' => 'integer',
    ];

    /**
     * Get the employee associated with the attendance.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Calculate total work hours.
     */
    public function calculateWorkHours(): float
    {
        if (!$this->clock_in || !$this->clock_out) {
            return 0;
        }

        $clockIn = $this->clock_in;
        $clockOut = $this->clock_out;

        // Calculate difference in hours
        $workHours = $clockIn->diffInMinutes($clockOut) / 60;

        return round($workHours, 2);
    }

    /**
     * Check if employee is currently clocked in.
     */
    public function isClockedIn(): bool
    {
        return $this->clock_in !== null && $this->clock_out === null;
    }

    /**
     * Check if employee has clocked out.
     */
    public function hasClockedOut(): bool
    {
        return $this->clock_out !== null;
    }

    /**
     * Calculate overtime hours (assuming 8-hour workday).
     */
    public function calculateOvertimeHours(): float
    {
        $workHours = $this->calculateWorkHours();
        $standardHours = 8;

        return max(0, $workHours - $standardHours);
    }

    /**
     * Check if employee was late (assuming 9 AM start time).
     */
    public function wasLate(): bool
    {
        if (!$this->clock_in) {
            return false;
        }

        $startTime = $this->date->copy()->setTime(9, 0, 0);
        return $this->clock_in->gt($startTime);
    }

    /**
     * Get late minutes.
     */
    public function getLateMinutes(): int
    {
        if (!$this->clock_in || !$this->wasLate()) {
            return 0;
        }

        $startTime = $this->date->copy()->setTime(9, 0, 0);
        return $this->clock_in->diffInMinutes($startTime);
    }

    /**
     * Get attendance status with color.
     */
    public function getStatusColor(): string
    {
        return match ($this->status) {
            'Present' => 'green',
            'Absent' => 'red',
            'Late' => 'yellow',
            'Half Day' => 'orange',
            default => 'gray',
        };
    }
}
