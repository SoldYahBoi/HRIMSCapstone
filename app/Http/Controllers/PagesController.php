<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\Employment;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
    public function dashboard()
    {
        return view('dashboard');
    }
    public function archives()
    {
        $employee = Employee::whereIn('status', ['Archived', 'Resigned', 'Terminated'])->paginate(5);
        $department = Department::all();
        $position = Position::all();
        $employment = Employment::all();
        return view('archives')->with('employee', $employee)->with('department', $department)->with('position', $position)->with('employment', $employment);
    }
    public function archive(Request $request, string $id)
    {
        $employee = Employee::find($id);
        $employee->status = "Inactive";
        $employee->save();
        $latest = $employee->first_name . " " . $employee->last_name;
        return redirect('/admin')->with('success', 'Employee '.$latest. ' Archived Successfully!');
    }
}
