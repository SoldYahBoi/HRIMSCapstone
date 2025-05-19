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
use App\Models\Deceased;
use App\Models\DeathCause;
use App\Models\DeathAttendant;
use App\Models\DeathInformant;
use App\Models\CorpseDisposal;
use App\Models\DeathCertificate;
use App\Models\JobPosting;

class PagesController extends Controller
{
    //
    public function dashboard()
    {
        // Employee Statistics
        $totalEmployee = Employee::where('status', 'Active')->count();
        $presentToday = Employee::where('status', 'Active')->count(); // You might want to implement actual attendance tracking
        $onLeave = Employee::where('status', 'On Leave')->count();
        $openPositions = JobPosting::where('status', 'Open')->count();

        // Department Overview
        $departments = Department::withCount(['employees' => function($query) {
            $query->where('status', 'Active');
        }])->get();

        // Recent Activities (Last 5 employee changes)
        $recentActivities = Employee::with(['department', 'position'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        // Recent Employees
        $recentEmployees = Employee::with(['department', 'position'])
            ->where('status', 'Active')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Compliance Status (Example: Employees with complete documents)
        $totalEmployees = Employee::count();
        $completeDocuments = Employee::where('status', 'Active')->count(); // You might want to implement actual document tracking
        $pendingDocuments = Employee::where('status', 'Pending')->count();
        $overdueDocuments = Employee::where('status', 'Overdue')->count();

        // Calculate compliance percentage
        $compliancePercentage = $totalEmployees > 0 ? 
            round(($completeDocuments / $totalEmployees) * 100) : 0;

        return view('manage.dashboard', compact(
            'totalEmployee',
            'presentToday',
            'onLeave',
            'openPositions',
            'departments',
            'recentActivities',
            'recentEmployees',
            'completeDocuments',
            'pendingDocuments',
            'overdueDocuments',
            'compliancePercentage'
        ));
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


        $deathCertificates = DeathCertificate::where('status','Archived')->paginate(5);
        $deceased = Deceased::all();
        $deathCause = DeathCause::all();
        $deathAttendant = DeathAttendant::all();
        $deathInformant = DeathInformant::all();
        $corpseDisposal = CorpseDisposal::all();
        $count2 = DeathCertificate::where('status','Archived')->count();
        
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
            ->with('count', $count)
            ->with('deathCertificates', $deathCertificates)
            ->with('deceased', $deceased)
            ->with('deathCause', $deathCause)
            ->with('deathAttendant', $deathAttendant)
            ->with('deathInformant', $deathInformant)
            ->with('corpseDisposal', $corpseDisposal)
            ->with('count2', $count2);
    }

    public function home()
    {
        return view('home');
    }
}
