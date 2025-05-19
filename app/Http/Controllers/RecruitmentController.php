<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosting;
use App\Models\Application;
use App\Models\Applicant;
use App\Models\Interview;
use App\Models\Department;
use App\Models\ApplicationNote;
use App\Models\ApplicantDocument;
use App\Models\Position;
use App\Models\RecruitmentStat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;

class RecruitmentController extends Controller
{
    /**
     * Display the recruitment management dashboard
     */
    public function index()
    {
        // Get statistics for dashboard
        $stats = [
            'openPositions' => JobPosting::where('status', 'open')->count(),
            'newApplications' => Application::where('status', 'new')->count(),
            'interviewsScheduled' => Interview::where('status', 'scheduled')->count(),
            // Changed to not reference filled_date since it doesn't exist
            'positionsFilled' => JobPosting::where('status', 'filled')->count(),
        ];

        // Get open positions
        $openPositions = JobPosting::with(['department', 'position'])
            ->where('status', 'open')
            ->where('is_active', true)
            ->where('application_deadline', '>=', now())
            ->get()
            ->map(function ($position) {
                $position->applicant_count = Application::where('job_posting_id', $position->id)->count();
                $position->interview_count = Interview::whereHas('application', function ($query) use ($position) {
                    $query->where('job_posting_id', $position->id);
                })->count();
                return $position;
            });

        // Get applications with pagination
        $applications = Application::with(['applicant', 'jobPosting.department'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // Get departments for filters
        $departments = Department::all();

        // Get calendar data
        $currentMonth = Carbon::now()->startOfMonth();
        $calendarDays = $this->generateCalendarDays($currentMonth);

        // Get upcoming interviews
        $interviews = Interview::with(['application.applicant', 'application.jobPosting', 'interviewer'])
            ->where('interview_date', '>=', now())
            ->where('status', 'scheduled')
            ->orderBy('interview_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        // Get report data
        $reportData = $this->getReportData();

        $positions = Position::all(); // Fetch all positions

        $employmentTypes = \DB::table('employments')->get();

        // Get HR department ID
        $hrDepartment = Department::where('department_name', 'HR')->first();
        $hrEmployees = [];
        if ($hrDepartment) {
            $hrEmployees = Employee::where('department_id', $hrDepartment->id)
                ->where('status', 'Active')
                ->get(['id', 'first_name', 'last_name']);
        }

        return view('recruitment.manageRecruitment', compact(
            'stats',
            'openPositions',
            'applications',
            'departments',
            'currentMonth',
            'calendarDays',
            'interviews',
            'reportData',
            'positions',
            'employmentTypes',
            'hrEmployees'
        ));
    }

    /**
     * Generate calendar days for the given month
     */
    private function generateCalendarDays($month)
    {
        $startOfCalendar = $month->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY);
        $endOfCalendar = $month->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        $days = [];
        $currentDay = $startOfCalendar->copy();

        while ($currentDay <= $endOfCalendar) {
            $date = $currentDay->copy();
            $isCurrentMonth = $currentDay->month === $month->month;
            
            // Check if there are interviews on this day
            $interviewCount = Interview::whereDate('interview_date', $currentDay->toDateString())->count();
            
            $days[] = [
                'date' => $date,
                'day' => $currentDay->day,
                'isCurrentMonth' => $isCurrentMonth,
                'hasEvents' => $interviewCount > 0,
                'eventCount' => $interviewCount
            ];

            $currentDay->addDay();
        }

        return $days;
    }

    /**
     * Get report data for the dashboard
     */
    private function getReportData()
    {
        // Get the latest recruitment stats or create default ones
        $latestStats = RecruitmentStat::latest('date')->first();

        if (!$latestStats) {
            $latestStats = new RecruitmentStat([
                'total_applications' => Application::count(),
                'avg_time_to_hire' => 18, // Default value
                'acceptance_rate' => 85, // Default value
                'cost_per_hire' => 1250, // Default value
            ]);
        }

        return [
            'summary' => [
                'totalApplications' => $latestStats->total_applications,
                'avgTimeToHire' => $latestStats->avg_time_to_hire,
                'acceptanceRate' => $latestStats->acceptance_rate,
                'costPerHire' => $latestStats->cost_per_hire,
            ]
        ];
    }

    /**
     * Show the job listings page
     */
    public function jobListings()
    {
        $jobPostings = JobPosting::with(['department', 'position'])
            ->where('status', 'open')
            ->where('is_active', true)
            ->where('application_deadline', '>=', now())
            ->paginate(10);

        $departments = Department::all();

        return view('recruitment.jobListings', compact('jobPostings', 'departments'));
    }

    /**
     * Show a specific job posting
     */
    public function showJob($id)
    {
        $jobPosting = JobPosting::with('department')->findOrFail($id);

        // Check if job is still open
        if ($jobPosting->status !== 'open' || !$jobPosting->is_active || $jobPosting->application_deadline < now()) {
            return redirect()->route('recruitment.jobs')->with('error', 'This position is no longer accepting applications.');
        }

        return view('recruitment.jobDetails', compact('jobPosting'));
    }

    /**
     * Show the application form for a job
     */
    public function applicationForm($jobId)
    {
        $jobPosting = JobPosting::with('department')->findOrFail($jobId);

        // Check if job is still open
        if ($jobPosting->status !== 'open' || !$jobPosting->is_active || $jobPosting->application_deadline < now()) {
            return redirect()->route('recruitment.jobs')->with('error', 'This position is no longer accepting applications.');
        }

        return view('recruitment.applicationForm', compact('jobPosting'));
    }

    /**
     * Submit a job application
     */
    public function submitApplication(Request $request, $jobId)
    {
        $jobPosting = JobPosting::findOrFail($jobId);

        // Check if job is still open
        if ($jobPosting->status !== 'open' || !$jobPosting->is_active || $jobPosting->application_deadline < now()) {
            return redirect()->route('recruitment.jobs')->with('error', 'This position is no longer accepting applications.');
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'years_of_experience' => 'nullable|integer',
            'current_employer' => 'nullable|string|max:255',
            'current_position' => 'nullable|string|max:255',
            'education' => 'nullable|string',
            'skills' => 'nullable|string',
            'certifications' => 'nullable|string',
            'cover_letter' => 'nullable|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'additional_documents.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create or update applicant
        $applicant = Applicant::updateOrCreate(
            ['email' => $request->email],
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'country' => $request->country,
                'years_of_experience' => $request->years_of_experience,
                'current_employer' => $request->current_employer,
                'current_position' => $request->current_position,
                'education' => $request->education,
                'skills' => $request->skills,
                'certifications' => $request->certifications,
            ]
        );

        // Create application
        $application = new Application([
            'job_posting_id' => $jobId,
            'cover_letter' => $request->cover_letter,
            'status' => 'new',
            'applied_date' => now(),
            'application_code' => strtoupper(substr($applicant->last_name, 0, 3) . date('Ymd') . str_pad($applicant->id, 4, '0', STR_PAD_LEFT)),
        ]);

        $applicant->applications()->save($application);

        // Upload resume
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('applicant_documents/' . $applicant->id, 'public');
            
            ApplicantDocument::create([
                'applicant_id' => $applicant->id,
                'document_type' => 'resume',
                'file_name' => $request->file('resume')->getClientOriginalName(),
                'file_path' => $resumePath,
                'file_size' => $request->file('resume')->getSize(),
                'mime_type' => $request->file('resume')->getMimeType(),
                'uploaded_at' => now(),
            ]);
        }

        // Upload additional documents
        if ($request->hasFile('additional_documents')) {
            foreach ($request->file('additional_documents') as $document) {
                $documentPath = $document->store('applicant_documents/' . $applicant->id, 'public');
                
                ApplicantDocument::create([
                    'applicant_id' => $applicant->id,
                    'document_type' => 'additional',
                    'file_name' => $document->getClientOriginalName(),
                    'file_path' => $documentPath,
                    'file_size' => $document->getSize(),
                    'mime_type' => $document->getMimeType(),
                    'uploaded_at' => now(),
                ]);
            }
        }

        // Generate application tracking code
        $trackingCode = strtoupper(substr($applicant->last_name, 0, 3) . $application->id . substr(md5($application->id), 0, 5));

        return redirect()->route('recruitment.application.submitted', ['trackingCode' => $trackingCode])
            ->with('success', 'Your application has been submitted successfully!');
    }

    /**
     * Show the application submitted page
     */
    public function applicationSubmitted($trackingCode)
    {
        // Extract application ID from tracking code
        $applicationId = (int)substr($trackingCode, 3, -5);

        // Find application with all needed relationships
        $application = Application::with([
            'applicant',
            'jobPosting.position',
            'jobPosting.department'
        ])->find($applicationId);

        if (!$application) {
            return redirect()->route('recruitment.job.listings')->with('error', 'Application not found.');
        }

        return view('recruitment.applicationSuccess', compact('trackingCode', 'application'));
    }

    /**
     * Show the application tracking page
     */
    public function trackApplication()
    {
        return view('recruitment.trackApplication');
    }

    /**
     * Check application status
     */
    public function checkApplicationStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tracking_code' => 'required|string',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Parse tracking code to get application ID
        $trackingCode = $request->tracking_code;
        $applicationId = substr($trackingCode, 3, strpos($trackingCode, substr(md5(''), 0, 5)) - 3);

        // Find application
        $application = Application::with(['applicant', 'jobPosting'])
            ->whereHas('applicant', function ($query) use ($request) {
                $query->where('email', $request->email);
            })
            ->find($applicationId);

        if (!$application) {
            return redirect()->back()->with('error', 'No application found with the provided tracking code and email.');
        }

        return view('recruitment.application-status', compact('application'));
    }

    /**
     * Get job positions
     */
    public function getPositions()
    {
        $positions = JobPosting::with('department')
            ->where('status', 'open')
            ->where('is_active', true)
            ->where('application_deadline', '>=', now())
            ->get();

        return response()->json(['positions' => $positions]);
    }

    /**
     * Get a specific job position
     */
    public function getPosition($id)
    {
        $jobPosting = JobPosting::with('department')->findOrFail($id);
        return response()->json(['jobPosting' => $jobPosting]);
    }

    /**
     * Create a new job position
     */
    public function createPosition(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'position_id' => 'required|exists:positions,id',
                'department_id' => 'required|exists:departments,id',
                'location' => 'required|string|max:255',
                'employment_type' => 'required|string|max:255',
                'description' => 'required|string',
                'requirements' => 'required|string',
                'benefits' => 'nullable|string',
                'salary_range' => 'nullable|string|max:255',
                'application_deadline' => 'required|date|after:today',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false, 
                    'message' => $validator->errors()->first()
                ], 422);
            }

            DB::beginTransaction();

            $jobPosting = new JobPosting();
            $jobPosting->position_id = $request->position_id;
            $jobPosting->department_id = $request->department_id;
            $jobPosting->location = $request->location;
            $jobPosting->employment_type = $request->employment_type;
            $jobPosting->description = $request->description;
            $jobPosting->requirements = $request->requirements;
            $jobPosting->benefits = $request->benefits;
            $jobPosting->salary_range = $request->salary_range;
            $jobPosting->application_deadline = $request->application_deadline;
            $jobPosting->is_active = true;
            $jobPosting->status = 'open';
            $jobPosting->save();

            DB::commit();

            return response()->json([
                'success' => true, 
                'message' => 'Position created successfully', 
                'jobPosting' => $jobPosting
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating position: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Error creating position: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a job position
     */
    public function updatePosition(Request $request, $id)
    {
        try {
            $jobPosting = JobPosting::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'position_id' => 'required|exists:positions,id',
                'department_id' => 'required|exists:departments,id',
                'location' => 'required|string|max:255',
                'employment_type' => 'required|string|max:255',
                'description' => 'required|string',
                'requirements' => 'required|string',
                'benefits' => 'nullable|string',
                'salary_range' => 'nullable|string|max:255',
                'application_deadline' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false, 
                    'message' => $validator->errors()->first()
                ], 422);
            }

            DB::beginTransaction();

            // Update position if title changed
            $position = Position::find($jobPosting->position_id);
            if ($position->position_name !== $request->position_title) {
                $position = Position::firstOrCreate(
                    ['position_name' => $request->position_title],
                    ['department_id' => $request->department_id]
                );
                $jobPosting->position_id = $position->id;
            }

            // Update job posting
            $jobPosting->department_id = $request->department_id;
            $jobPosting->location = $request->location;
            $jobPosting->employment_type = $request->employment_type;
            $jobPosting->description = $request->description;
            $jobPosting->requirements = $request->requirements;
            $jobPosting->benefits = $request->benefits;
            $jobPosting->salary_range = $request->salary_range;
            $jobPosting->application_deadline = $request->application_deadline;
            $jobPosting->save();

            DB::commit();

            return response()->json([
                'success' => true, 
                'message' => 'Position updated successfully', 
                'jobPosting' => $jobPosting
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating position: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Error updating position: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a job position
     */
    public function deletePosition($id)
    {
        $jobPosting = JobPosting::findOrFail($id);
        
        // Check if there are applications for this position
        $applicationCount = Application::where('job_posting_id', $id)->count();
        
        if ($applicationCount > 0) {
            // Don't delete, just mark as inactive
            $jobPosting->update([
                'is_active' => false,
                'status' => 'closed'
            ]);
            
            return response()->json(['success' => true, 'message' => 'Position has been closed because it has applications.']);
        } else {
            // No applications, safe to delete
            $jobPosting->delete();
            
            return response()->json(['success' => true, 'message' => 'Position deleted successfully.']);
        }
    }

    /**
     * Get applications for a specific position
     */
    public function getPositionApplications($positionId)
    {
        $jobPosting = JobPosting::findOrFail($positionId);
        $applications = Application::with(['applicant', 'jobPosting.department'])
            ->where('job_posting_id', $positionId)
            ->get();

        return response()->json(['success' => true, 'jobPosting' => $jobPosting, 'applications' => $applications]);
    }

    /**
     * Get a specific application
     */
    public function getApplication($id)
    {
        $application = Application::with(['applicant', 'jobPosting', 'notes.user'])
            ->findOrFail($id);
            
        $documents = ApplicantDocument::where('applicant_id', $application->applicant_id)->get();

        return response()->json(['success' => true, 'application' => $application, 'documents' => $documents]);
    }

    /**
     * Update application status
     */
    public function updateApplicationStatus(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:new,reviewing,interview,hired,rejected',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $oldStatus = $application->status;
        $newStatus = $request->status;
        
        $application->status = $newStatus;
        
        // If status changed to reviewing, update reviewed_date and reviewed_by
        if ($newStatus === 'reviewing' && $oldStatus !== 'reviewing') {
            $application->reviewed_date = now();
            $application->reviewed_by = Auth::id();
        }
        
        // If status changed to hired, update job posting status
        if ($newStatus === 'hired' && $oldStatus !== 'hired') {
            $jobPosting = JobPosting::find($application->job_posting_id);
            $jobPosting->status = 'filled';
            $jobPosting->save();
            
            // Reject other applications for this position
            Application::where('job_posting_id', $application->job_posting_id)
                ->where('id', '!=', $application->id)
                ->where('status', '!=', 'rejected')
                ->update(['status' => 'rejected']);
        }
        
        $application->save();

        return response()->json(['success' => true, 'message' => 'Application status updated successfully']);
    }

    /**
     * Add a note to an application
     */
    public function addApplicationNote(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'note_content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $note = new ApplicationNote([
            'user_id' => Auth::id(),
            'content' => $request->note_content,
        ]);

        $application->notes()->save($note);
        
        // Load user relationship for the response
        $note->load('user');
        
        // Add created_by_name for the frontend
        $note->created_by_name = $note->user->name;

        return response()->json(['success' => true, 'message' => 'Note added successfully', 'note' => $note]);
    }

    /**
     * Schedule an interview
     */
    public function scheduleInterview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'application_id' => 'required|exists:applications,id',
            'interviewer_id' => 'required|exists:employees,id',
            'interview_date' => 'required|date|after_or_equal:today',
            'interview_time' => 'required',
            'interview_duration' => 'required|integer|min:15',
            'interview_location' => 'required|string|max:255',
            'interview_type' => 'required|in:in-person,phone,video',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        // Calculate end time
        $startTime = Carbon::parse($request->interview_time);
        $endTime = $startTime->copy()->addMinutes((int)$request->interview_duration);

        // Create interview
        $interview = Interview::create([
            'application_id' => $request->application_id,
            'interviewer_id' => $request->interviewer_id,
            'interview_date' => $request->interview_date,
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
            'location' => $request->interview_location,
            'interview_type' => $request->interview_type,
            'status' => 'scheduled',
            'feedback' => $request->notes,
        ]);

        // Update application status
        $application = Application::find($request->application_id);
        $application->status = 'interview';
        $application->save();

        return response()->json(['success' => true, 'message' => 'Interview scheduled successfully', 'interview' => $interview]);
    }

    /**
     * Get interviews for a specific date
     */
    public function getInterviewsByDate($date)
    {
        $interviews = Interview::with(['application.applicant', 'application.jobPosting.position', 'interviewer'])
            ->whereDate('interview_date', $date)
            ->orderBy('start_time')
            ->get();

        // Force serialization of nested position
        foreach ($interviews as $interview) {
            if ($interview->application && $interview->application->jobPosting) {
                $interview->application->jobPosting->position;
            }
        }

        // Convert to array to ensure all relationships are included
        return response()->json(['success' => true, 'interviews' => $interviews->toArray()]);
    }

    /**
     * Get a specific interview
     */
    public function getInterview($id)
    {
        $interview = Interview::with(['application.applicant', 'application.jobPosting', 'interviewer'])
            ->findOrFail($id);

        return response()->json(['success' => true, 'interview' => $interview]);
    }

    /**
     * Update an interview
     */
    public function updateInterview(Request $request, $id)
    {
        $interview = Interview::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'interview_date' => 'required|date',
            'interview_time' => 'required',
            'interview_duration' => 'required|integer|min:15',
            'interview_location' => 'required|string|max:255',
            'interviewer_id' => 'required|exists:users,id',
            'interview_type' => 'required|in:in-person,phone,video',
            'status' => 'required|in:scheduled,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        // Calculate end time
        $startTime = Carbon::parse($request->interview_time);
        $endTime = $startTime->copy()->addMinutes($request->interview_duration);

        // Update interview
        $interview->update([
            'interview_date' => $request->interview_date,
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
            'location' => $request->interview_location,
            'interviewer_id' => $request->interviewer_id,
            'interview_type' => $request->interview_type,
            'status' => $request->status,
            'feedback' => $request->notes,
        ]);

        return response()->json(['success' => true, 'message' => 'Interview updated successfully', 'interview' => $interview]);
    }

    /**
     * Cancel an interview
     */
    public function cancelInterview($id)
    {
        $interview = Interview::findOrFail($id);
        $interview->status = 'cancelled';
        $interview->save();

        return response()->json(['success' => true, 'message' => 'Interview cancelled successfully']);
    }

    /**
     * Get calendar data for a specific month
     */
    public function getCalendar($year, $month)
    {
        $currentMonth = Carbon::createFromDate($year, $month, 1);
        $calendarDays = $this->generateCalendarDays($currentMonth);

        return response()->json([
            'success' => true,
            'calendarDays' => $calendarDays,
            'currentMonth' => $currentMonth->format('F Y')
        ]);
    }

    /**
     * Get report data for a specific date range
     */
    // public function getReportData(Request $request)
    // {
    //     $startDate = $request->input('start_date', Carbon::now()->subMonths(6)->format('Y-m-d'));
    //     $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

    //     // Get application counts by department
    //     $applicationsByDepartment = DB::table('applications')
    //         ->join('job_postings', 'applications.job_posting_id', '=', 'job_postings.id')
    //         ->join('departments', 'job_postings.department_id', '=', 'departments.id')
    //         ->whereBetween('applications.created_at', [$startDate, $endDate])
    //         ->select('departments.department_name', DB::raw('count(*) as count'))
    //         ->groupBy('departments.department_name')
    //         ->get();

    //     // Get application counts by date
    //     $applicationsByDate = DB::table('applications')
    //         ->whereBetween('created_at', [$startDate, $endDate])
    //         ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
    //         ->groupBy('date')
    //         ->orderBy('date')
    //         ->get();

    //     // Get hiring funnel data
    //     $hiringFunnel = [
    //         'total' => Application::whereBetween('created_at', [$startDate, $endDate])->count(),
    //         'reviewing' => Application::whereBetween('created_at', [$startDate, $endDate])->where('status', 'reviewing')->count(),
    //         'interview' => Application::whereBetween('created_at', [$startDate, $endDate])->where('status', 'interview')->count(),
    //         'hired' => Application::whereBetween('created_at', [$startDate, $endDate])->where('status', 'hired')->count(),
    //     ];

    //     // Get time to fill by department
    //     $timeToFillByDepartment = DB::table('applications')
    //         ->join('job_postings', 'applications.job_posting_id', '=', 'job_postings.id')
    //         ->join('departments', 'job_postings.department_id', '=', 'departments.id')
    //         ->where('applications.status', 'hired')
    //         ->whereBetween('applications.created_at', [$startDate, $endDate])
    //         ->select(
    //             'departments.department_name',
    //             DB::raw('AVG(DATEDIFF(applications.updated_at, applications.created_at)) as avg_days')
    //         )
    //         ->groupBy('departments.department_name')
    //         ->get();

    //     // Get summary statistics
    //     $summary = [
    //         'totalApplications' => Application::whereBetween('created_at', [$startDate, $endDate])->count(),
    //         'avgTimeToHire' => Application::where('status', 'hired')
    //             ->whereBetween('created_at', [$startDate, $endDate])
    //             ->select(DB::raw('AVG(DATEDIFF(updated_at, created_at)) as avg_days'))
    //             ->first()->avg_days ?? 0,
    //         'acceptanceRate' => 85, // This would need to be calculated based on offers extended vs. accepted
    //         'costPerHire' => 1250, // This would need to be calculated based on recruitment costs
    //     ];

    //     $data = [
    //         'applicationsByDepartment' => $applicationsByDepartment,
    //         'applicationsByDate' => $applicationsByDate,
    //         'hiringFunnel' => $hiringFunnel,
    //         'timeToFillByDepartment' => $timeToFillByDepartment,
    //         'summary' => $summary,
    //     ];

    //     return response()->json(['success' => true, 'data' => $data]);
    // }

    /**
     * Export report data
     */
    public function exportReportData(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonths(6)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Get applications for export
        $applications = Application::with(['applicant', 'jobPosting.department'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Generate CSV data
        $csvData = [];
        $csvData[] = [
            'Application ID',
            'Applicant Name',
            'Email',
            'Phone',
            'Position',
            'Department',
            'Applied Date',
            'Status',
            'Days in Process',
        ];

        foreach ($applications as $application) {
            $daysInProcess = Carbon::parse($application->created_at)->diffInDays(
                $application->status === 'hired' || $application->status === 'rejected'
                    ? $application->updated_at
                    : Carbon::now()
            );

            $csvData[] = [
                $application->id,
                $application->applicant->first_name . ' ' . $application->applicant->last_name,
                $application->applicant->email,
                $application->applicant->phone,
                $application->jobPosting->title,
                $application->jobPosting->department->department_name,
                $application->created_at->format('Y-m-d'),
                ucfirst($application->status),
                $daysInProcess,
            ];
        }

        // Create CSV file
        $filename = 'recruitment_report_' . date('Y-m-d') . '.csv';
        $tempFile = tempnam(sys_get_temp_dir(), 'csv');
        $file = fopen($tempFile, 'w');

        foreach ($csvData as $row) {
            fputcsv($file, $row);
        }

        fclose($file);

        // Return file for download
        return response()->download($tempFile, $filename, [
            'Content-Type' => 'text/csv',
        ])->deleteFileAfterSend(true);
    }

    /**
     * Download a document
     */
    public function downloadDocument($id)
    {
        $document = ApplicantDocument::findOrFail($id);
        
        if (!Storage::disk('public')->exists($document->file_path)) {
            return redirect()->back()->with('error', 'Document not found.');
        }
        
        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }

    /**
     * Track application status via API
     */
    public function trackApplicationStatus($applicationCode)
    {
        try {
            $application = Application::with(['jobPosting.department', 'jobPosting.position', 'interviews'])
                ->where('application_code', $applicationCode)
                ->first();

            if (!$application) {
                return response()->json([
                    'success' => false,
                    'message' => 'No application found with the provided code.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'application' => $application
            ]);

        } catch (\Exception $e) {
            \Log::error('Error tracking application: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while tracking your application.'
            ], 500);
        }
    }

    public function getHrInterviewers()
    {
        $hrDepartment = \App\Models\Department::where('department_name', 'HR')->first();
        $employees = [];
        if ($hrDepartment) {
            $employees = \App\Models\Employee::where('department_id', $hrDepartment->id)
                ->where('status', 'Active')
                ->get(['id', 'first_name', 'last_name']);
        }
        return response()->json(['employees' => $employees]);
    }
}