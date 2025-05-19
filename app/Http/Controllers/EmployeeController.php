<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\Employment;
use Illuminate\Http\Request;
use Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $employee = Employee::where('status','Active')->paginate(5);
        $department = Department::all();
        $position = Position::all();
        $employment = Employment::all();
        return view('manage.manageEmployee')->with('employee', $employee)->with('department', $department)->with('position', $position)->with('employment', $employment);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $department = Department::all();
        $position = Position::all();
        $employment = Employment::all();
        return view('manage.addEmployee')->with('departments', $department)->with('positions', $position)->with('employments', $employment);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // return "Hello";
        $validator = Validator::make($request->all(), [
            "first_name" => "required",
            "middle_name" => "nullable",
            "last_name" => "required",
            "birthdate" => "required",
            "gender" => "required",
            "civil_status" => "required",
            "contact_number" => "required",
            "email" => "required",
            "address" => "required",
            "department_id" => "required",
            "position_id" => "required",
            "hire_date" => "required",
            "status" => "required",
            "employment_type_id" => "required"
        ]);
        if ($validator->fails()) {
            return redirect('/employees/create')->withErrors($validator)->withInput();
        }
        else{
            // return $request->all();
            Employee::create([
                "first_name" => $request->first_name,
                "middle_name" => $request->middle_name,
                "last_name" => $request->last_name,
                "birthdate" => $request->birthdate,
                "gender" => $request->gender,
                "civil_status" => $request->civil_status,
                "contact_number" => $request->contact_number,
                "email" => $request->email,
                "address" => $request->address,
                "department_id" => $request->department_id,
                "position_id" => $request->position_id,
                "hire_date" => $request->hire_date,
                "status" => $request->status,
                "employment_type_id" => $request->employment_type_id
            ]);
            $latest = $request->first_name . " " . $request->last_name;
            // $msg = "Client ".$latest." Added Successfully!";
            // Log::info($msg);
            return redirect('/employees/create')->with('success', 'Employee '.$latest. ' Added Successfully!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $employee = Employee::find($id);
        $department = Department::all();
        $position = Position::all();
        $employment = Employment::all();
        return view('manage.viewEmployee')->with('employee', $employee)->with('department', $department)->with('position', $position)->with('employment', $employment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $employee = Employee::find($id);
        $department = Department::all();
        $position = Position::all();
        $employment = Employment::all();
        return view('manage.editEmployee')->with('employee', $employee)->with('departments', $department)->with('positions', $position)->with('employments', $employment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $employee = Employee::find($id);
        $department = Department::all();
        $position = Position::all();
        $employment = Employment::all();
        $validator = Validator::make($request->all(), [
            "first_name" => "required",
            "middle_name" => "nullable",
            "last_name" => "required",
            "birthdate" => "required",
            "gender" => "required",
            "civil_status" => "required",
            "contact_number" => "required",
            "email" => "required",
            "address" => "required",
            "department_id" => "required",
            "position_id" => "required",
            "hire_date" => "required",
            "status" => "required",
            "employment_type_id" => "required"
        ]);
        if ($validator->fails()) {
            return redirect('/employees/'.$employee->id.'/edit')->withErrors($validator)->withInput()->with('employee', $employee)->with('department', $department)->with('position', $position)->with('employment', $employment);
        }
        else{
            // return $request->all();
            $employee->first_name = $request->first_name;
            $employee->middle_name = $request->middle_name;
            $employee->last_name = $request->last_name;
            $employee->birthdate = $request->birthdate;
            $employee->gender = $request->gender;
            $employee->civil_status = $request->civil_status;
            $employee->contact_number = $request->contact_number;
            $employee->email = $request->email;
            $employee->address = $request->address;
            $employee->department_id = $request->department_id;
            $employee->position_id = $request->position_id;
            $employee->hire_date = $request->hire_date;
            $employee->status = $request->status;
            $employee->employment_type_id = $request->employment_type_id;
            $employee->save();
            $latest = $request->first_name . " " . $request->last_name;
            // $msg = "Client ".$latest." Added Successfully!";
            // Log::info($msg);
            return redirect('/employees/'.$employee->id)->with('success', 'Employee '.$latest. ' Updated Successfully!')->with('employee', $employee)->with('department', $department)->with('position', $position)->with('employment', $employment);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function archive($id)
    {
        //
        $status = 'Archived';
        $employee = Employee::find($id);
        $employee->status = $status;
        $employee->save();
        $latest = $employee->first_name . " " . $employee->last_name;
        return redirect('/employees')->with('success', 'Employee '.$latest. ' Archived Successfully!');
    }

    public function restore($id)
    {
        //
        $status = 'Active';
        $employee = Employee::find($id);
        $employee->status = $status;
        $employee->save();
        $latest = $employee->first_name . " " . $employee->last_name;
        return redirect('/archives')->with('success', 'Employee '.$latest. ' Restored Successfully!');
    }
}
