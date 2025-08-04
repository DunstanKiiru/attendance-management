<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        $attendances = Attendance::where('employee_id', $employee->id)->latest()->get();
        return view('attendance.index', compact('attendances'));
    }

    public function clockIn(Request $request)
    {
        $employee = Auth::user()->employee;
        $today = now()->toDateString();

        $attendance = Attendance::firstOrCreate(
            ['employee_id' => $employee->id, 'date' => $today],
            ['clock_in' => now(), 'status' => 'Present']
        );

        return back()->with('success', 'Clocked in!');
    }

    public function clockOut(Request $request)
    {
        $employee = Auth::user()->employee;
        $today = now()->toDateString();

        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        if ($attendance && !$attendance->clock_out) {
            $attendance->update(['clock_out' => now()]);
        }

        return back()->with('success', 'Clocked out!');
    }
}
