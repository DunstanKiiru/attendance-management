<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('user')->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $users = User::role('Employee')->doesntHave('employee')->get();
        return view('employees.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'department' => 'required',
            'designation' => 'required',
            'hire_date' => 'required|date'
        ]);

        // Ensure the user has the 'Employee' role
        $user = User::findOrFail($data['user_id']);
        if (!$user->hasRole('Employee')) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['user_id' => 'Only users with the Employee role can be assigned to employees.']);
        }

        // Check if user already has an employee record
        if ($user->employee()->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['user_id' => 'This user is already assigned to an employee record.']);
        }

        Employee::create($data);
        return redirect()->route('employees.index')->with('success', 'Employee created');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'department' => 'required', 'designation' => 'required',
            'hire_date' => 'required|date', 'status' => 'required'
        ]);

        $employee->update($data);
        return redirect()->route('employees.index')->with('success', 'Employee updated');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Deleted');
    }
}
