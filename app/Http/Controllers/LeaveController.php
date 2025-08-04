<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        //Admin and HR can see all leaves but employees wataona yao tu

        if($user ->hasAnyRole([
            'Admin','HR'
        ])){
            $leaves =  Leave::with('employee.user')->latest()->paginate(10);
        }else{
            $leaves = Leave::with('employee.user')
            ->whereHas('employee', fn($q)=>$q->where('user_id', $user->id))->latest()->paginate(10);
        }
        return view('leaves.index', compact('leaves'));
    }

    public function create(){
        return view('leaves.create');
    }

    public function store (Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|string',
            'reason' => 'nullable|string',
        ]);

        $employee = Auth::user()->employee;

        Leave::create([
            'employee_id' => $employee->id,
            'start_date'=> $request->start_date,
            'end_date' => $request->end_date,
            'type'=> $request->type,
            'reason' => $request->reason,
        ]);
        return redirect()->route('leaves.index')->with('success', 'Leave request submitted.');
    }

     public function edit(Leave $leave)
    {
        $this->authorizeLeaveAccess($leave);

        return view('leaves.edit', compact('leave'));
    }

    public function update(Request $request, Leave $leave)
    {
        $this->authorizeLeaveAccess($leave);

        $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected',
        ]);

        $leave->update(['status' => $request->status]);

        return redirect()->route('leaves.index')->with('success', 'Leave status updated.');
    }

    public function destroy(Leave $leave)
    {
        $this->authorizeLeaveAccess($leave);

        $leave->delete();

        return redirect()->route('leaves.index')->with('success', 'Leave request deleted.');
    }

    private function authorizeLeaveAccess(Leave $leave)
    {
        $user = Auth::user();
        if ($user->hasAnyRole(['Admin', 'HR'])) return;

        // Employee anaona leave yake tu
        if ($leave->employee->user_id !== $user->id) {
            abort(403);
        }
    }


}
