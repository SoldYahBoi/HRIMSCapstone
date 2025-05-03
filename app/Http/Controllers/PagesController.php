<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\Employment;
use App\Models\Child;
use App\Models\BirthCertificate;
use App\Models\Mother;
use App\Models\Father;
use App\Models\Informant;
use App\Models\Marriage;
use App\Models\BirthAttendant;
use App\Models\CityMunicipality;
use App\Models\Province;
use App\Models\Country;
use App\Models\Official;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
    public function dashboard()
    {
        $totalEmployee = Employee::where('status', 'Active')->count();
        return view('manage.dashboard')->with('totalEmployee', $totalEmployee);
    }
    public function archives()
    {
        $employee = Employee::whereIn('status', ['Archived', 'Resigned', 'Terminated'])->paginate(5);
        $department = Department::all();
        $position = Position::all();
        $employment = Employment::all();
        return view('manage.archives')->with('employee', $employee)->with('department', $department)->with('position', $position)->with('employment', $employment);
    }
    public function archive(Request $request, string $id)
    {
        $employee = Employee::find($id);
        $employee->status = "Inactive";
        $employee->save();
        $latest = $employee->first_name . " " . $employee->last_name;
        return redirect('/admin')->with('success', 'Employee '.$latest. ' Archived Successfully!');
    }

    public function certArchives()
    {
        $birthCertificates = BirthCertificate::where('status','Archived')->paginate(5);
        $count = BirthCertificate::where('status','Archived')->count();
        $child = Child::all();
        $mother = Mother::all();
        $father = Father::all();
        $marriage = Marriage::all();
        $birthAttendant = BirthAttendant::all();
        $informant = Informant::all();
        $official = Official::all();
        $cityMunicipality = CityMunicipality::all();
        
        // $deathCertificates = DeathCertificate::paginate(5);
        return view('certificates.certArchives')->with('birthCertificates', $birthCertificates)
            ->with('child', $child)
            ->with('mother', $mother)
            ->with('father', $father)
            ->with('marriage', $marriage)
            ->with('birthAttendant', $birthAttendant)
            ->with('informant', $informant)
            ->with('official', $official)
            ->with('cityMunicipality', $cityMunicipality)
            ->with('count', $count);
    }
}
