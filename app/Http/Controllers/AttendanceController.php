<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;


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

    public function exportCSV()
{
    $employee = Auth::user()->employee;
    $attendances = Attendance::where('employee_id', $employee->id)->get();

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="attendance.csv"',
    ];

    $callback = function () use ($attendances) {
        $file = fopen('php://output', 'w');
        fputcsv($file, ['Date', 'Clock In', 'Clock Out', 'Status']);

        foreach ($attendances as $att) {
            fputcsv($file, [
                $att->date->format('Y-m-d'),
                $att->clock_in ? $att->clock_in->format('H:i:s') : '',
                $att->clock_out ? $att->clock_out->format('H:i:s') : '',
                $att->status,
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

public function exportPDF()
{
    $employee = Auth::user()->employee;
    $attendances = Attendance::where('employee_id', $employee->id)->get();

    $pdf = Pdf::loadView('attendance.pdf', compact('attendances'));

    return $pdf->download('attendance.pdf');
}
}
