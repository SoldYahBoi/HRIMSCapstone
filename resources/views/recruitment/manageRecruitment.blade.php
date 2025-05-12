@extends('layout.mainLayout')

@section('title')
    Recruitment Management
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/recruit/recruit.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page-title')
    Recruitment Management
@endsection

@section('page-actions')
    <div class="page-actions">
        <button id="addPositionBtn" class="btn btn-primary">
            <i class="fas fa-plus" aria-hidden="true"></i> Post New Position
        </button>
    </div>
@endsection

@section('content')
<div class="recruitment-dashboard">
    <!-- Stats Overview -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-title">Open Positions</div>
            <div class="stat-card-value">{{ $stats['openPositions'] }}</div>
            <div class="stat-card-icon"><i class="fas fa-briefcase" aria-hidden="true"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-card-title">New Applications</div>
            <div class="stat-card-value">{{ $stats['newApplications'] }}</div>
            <div class="stat-card-icon"><i class="fas fa-file-alt" aria-hidden="true"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-card-title">Interviews Scheduled</div>
            <div class="stat-card-value">{{ $stats['interviewsScheduled'] }}</div>
            <div class="stat-card-icon"><i class="fas fa-calendar-check" aria-hidden="true"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-card-title">Positions Filled</div>
            <div class="stat-card-value">{{ $stats['positionsFilled'] }}</div>
            <div class="stat-card-icon"><i class="fas fa-user-check" aria-hidden="true"></i></div>
        </div>
    </div>

    <!-- Main Content Tabs -->
    <div class="recruitment-tabs">
        <div class="tab-nav">
            <button class="tab-btn active" data-tab="positions">
                <i class="fas fa-briefcase" aria-hidden="true"></i> Open Positions
            </button>
            <button class="tab-btn" data-tab="applications">
                <i class="fas fa-file-alt" aria-hidden="true"></i> Applications
            </button>
            <button class="tab-btn" data-tab="interviews">
                <i class="fas fa-calendar-alt" aria-hidden="true"></i> Interviews
            </button>
            <button class="tab-btn" data-tab="reports">
                <i class="fas fa-chart-bar" aria-hidden="true"></i> Reports
            </button>
        </div>

        <!-- Open Positions Tab -->
        <div id="positions" class="tab-content active">
            <div class="tab-header">
                <h3>Open Positions</h3>
                <div class="tab-actions">
                    <div class="search-container">
                        <input type="text" id="positionSearch" class="form-control" placeholder="Search positions...">
                        <button class="btn btn-outline search-btn">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="filter-container">
                        <select id="departmentFilter" class="form-control">
                            <option value="all">All Departments</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="positions-grid">
                @forelse($openPositions as $position)
                    <div class="position-card">
                        <div class="position-header">
                            <span class="department-badge dept-{{ strtolower($position->department->department_name) }}">{{ $position->department->department_name }}</span>
                            <div class="position-actions">
                                <button class="btn-icon edit-position" data-id="{{ $position->id }}" title="Edit Position">
                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                </button>
                                <button class="btn-icon delete-position" data-id="{{ $position->id }}" title="Delete Position">
                                    <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <h4 class="position-title">{{ $position->position->position_name }}</h4>
                        <div class="position-meta">
                            <span><i class="fas fa-map-marker-alt" aria-hidden="true"></i> {{ $position->location }}</span>
                            <span><i class="fas fa-clock" aria-hidden="true"></i> {{ $position->employment_type }}</span>
                        </div>
                        <p class="position-description">
                            {{ Str::limit($position->description, 150) }}
                        </p>
                        <div class="position-stats">
                            <div class="stat">
                                <span class="stat-value">{{ $position->applicant_count }}</span>
                                <span class="stat-label">Applicants</span>
                            </div>
                            <div class="stat">
                                <span class="stat-value">{{ $position->interview_count }}</span>
                                <span class="stat-label">Interviews</span>
                            </div>
                            <div class="stat">
                                <span class="stat-value">{{ \Carbon\Carbon::parse($position->application_deadline)->format('M d') }}</span>
                                <span class="stat-label">Deadline</span>
                            </div>
                        </div>
                        <div class="position-footer">
                            <button class="btn btn-outline view-applicants" data-id="{{ $position->id }}">
                                <i class="fas fa-users" aria-hidden="true"></i> View Applicants
                            </button>
                            <button class="btn btn-primary">
                                <i class="fas fa-share-alt" aria-hidden="true"></i> Share
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-briefcase" aria-hidden="true"></i>
                        <p>No open positions found.</p>
                        <button id="emptyStateAddPositionBtn" class="btn btn-primary">
                            <i class="fas fa-plus" aria-hidden="true"></i> Post New Position
                        </button>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Applications Tab -->
        <div id="applications" class="tab-content">
            <div class="tab-header">
                <h3>Applications</h3>
                <div class="tab-actions">
                    <div class="search-container">
                        <input type="text" id="applicationSearch" class="form-control" placeholder="Search applications...">
                        <button class="btn btn-outline search-btn">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="filter-container">
                        <select id="statusFilter" class="form-control">
                            <option value="all">All Statuses</option>
                            <option value="new">New</option>
                            <option value="reviewing">Reviewing</option>
                            <option value="interview">Interview</option>
                            <option value="hired">Hired</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table class="applications-table">
                    <thead>
                        <tr>
                            <th>Applicant</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Applied Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $application)
                            <tr data-id="{{ $application->id }}">
                                <td>
                                    <div class="applicant-info">
                                        <div class="applicant-avatar">{{ substr($application->applicant->first_name, 0, 1) }}{{ substr($application->applicant->last_name, 0, 1) }}</div>
                                        <div>
                                            <div class="applicant-name">{{ $application->applicant->first_name }} {{ $application->applicant->last_name }}</div>
                                            <div class="applicant-email">{{ $application->applicant->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $application->jobPosting->position->position_name }}</td>
                                <td><span class="department-badge dept-{{ strtolower($application->jobPosting->department->department_name) }}">{{ $application->jobPosting->department->department_name }}</span></td>
                                <td>{{ $application->created_at->format('M d, Y') }}</td>
                                <td><span class="status-badge status-{{ $application->status }}">{{ ucfirst($application->status) }}</span></td>
                                <td>
                                    <div class="application-actions">
                                        <button class="btn-icon view-application" data-id="{{ $application->id }}" title="View Application">
                                            <i class="fas fa-eye" aria-hidden="true"></i>
                                        </button>
                                        @if($application->status != 'hired' && $application->status != 'rejected')
                                            <button class="btn-icon schedule-interview" data-id="{{ $application->id }}" title="Schedule Interview">
                                                <i class="fas fa-calendar-plus" aria-hidden="true"></i>
                                            </button>
                                        @endif
                                        @if($application->status == 'interview')
                                            <button class="btn-icon hire-applicant" data-id="{{ $application->id }}" title="Hire Applicant">
                                                <i class="fas fa-user-check" aria-hidden="true"></i>
                                            </button>
                                        @endif
                                        @if($application->status != 'hired' && $application->status != 'rejected')
                                            <button class="btn-icon reject-application" data-id="{{ $application->id }}" title="Reject Application">
                                                <i class="fas fa-times-circle" aria-hidden="true"></i>
                                            </button>
                                        @endif
                                        @if($application->status == 'hired')
                                            <button class="btn-icon onboarding" data-id="{{ $application->id }}" title="Start Onboarding">
                                                <i class="fas fa-clipboard-list" aria-hidden="true"></i>
                                            </button>
                                        @endif
                                        @if($application->status == 'rejected')
                                            <button class="btn-icon restore-application" data-id="{{ $application->id }}" title="Restore Application">
                                                <i class="fas fa-undo" aria-hidden="true"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No applications found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <button class="btn btn-outline pagination-btn" {{ $applications->onFirstPage() ? 'disabled' : '' }}>
                    <i class="fas fa-chevron-left" aria-hidden="true"></i> Previous
                </button>
                <span class="pagination-info">Page {{ $applications->currentPage() }} of {{ $applications->lastPage() }}</span>
                <button class="btn btn-outline pagination-btn" {{ $applications->hasMorePages() ? '' : 'disabled' }}>
                    Next <i class="fas fa-chevron-right" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <!-- Interviews Tab -->
        <div id="interviews" class="tab-content">
            <div class="tab-header">
                <h3>Scheduled Interviews</h3>
                <div class="tab-actions">
                    <button class="btn btn-primary" id="scheduleNewInterviewBtn">
                        <i class="fas fa-calendar-plus" aria-hidden="true"></i> Schedule New Interview
                    </button>
                </div>
            </div>

            <div class="calendar-view">
                <div class="calendar-header">
                    <button class="btn btn-outline calendar-nav-btn">
                        <i class="fas fa-chevron-left" aria-hidden="true"></i>
                    </button>
                    <h4>{{ $currentMonth->format('F Y') }}</h4>
                    <button class="btn btn-outline calendar-nav-btn">
                        <i class="fas fa-chevron-right" aria-hidden="true"></i>
                    </button>
                </div>
                
                <div class="calendar-grid">
                    <div class="calendar-day-header">Sun</div>
                    <div class="calendar-day-header">Mon</div>
                    <div class="calendar-day-header">Tue</div>
                    <div class="calendar-day-header">Wed</div>
                    <div class="calendar-day-header">Thu</div>
                    <div class="calendar-day-header">Fri</div>
                    <div class="calendar-day-header">Sat</div>
                    
                    <!-- Calendar days -->
                    @foreach($calendarDays as $day)
                        <div class="calendar-day{{ !$day['isCurrentMonth'] ? ' inactive' : '' }}{{ $day['hasEvents'] ? ' has-events' : '' }}" data-date="{{ $day['date']->format('Y-m-d') }}">
                            {{ $day['day'] }}
                            @if($day['hasEvents'])
                                <div class="event-indicator" data-count="{{ $day['eventCount'] }}"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="upcoming-interviews">
                <h4>Upcoming Interviews</h4>
                <div class="interview-list">
                    @forelse($interviews as $interview)
                        <div class="interview-card" data-id="{{ $interview->id }}">
                            <div class="interview-date">
                                <div class="date-day">{{ \Carbon\Carbon::parse($interview->interview_date)->format('d') }}</div>
                                <div class="date-month">{{ \Carbon\Carbon::parse($interview->interview_date)->format('M') }}</div>
                            </div>
                            <div class="interview-details">
                                <div class="interview-title">{{ $interview->application->applicant->first_name }} {{ $interview->application->applicant->last_name }} - {{ $interview->application->jobPosting->position->position_name }}</div>
                                <div class="interview-meta">
                                    <span><i class="fas fa-clock" aria-hidden="true"></i> {{ \Carbon\Carbon::parse($interview->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($interview->end_time)->format('g:i A') }}</span>
                                    <span><i class="fas fa-map-marker-alt" aria-hidden="true"></i> {{ $interview->location }}</span>
                                    <span><i class="fas fa-user" aria-hidden="true"></i> {{ $interview->interviewer ? $interview->interviewer->first_name . ' ' . $interview->interviewer->last_name : 'Not assigned' }}</span>
                                </div>
                            </div>
                            <div class="interview-actions">
                                <button class="btn btn-outline">
                                    <i class="fas fa-edit" aria-hidden="true"></i> Edit
                                </button>
                                <button class="btn btn-outline">
                                    <i class="fas fa-times" aria-hidden="true"></i> Cancel
                                </button>
                            </div>
                        </div>
                    @empty
                        <p>No upcoming interviews scheduled.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Reports Tab -->
        <div id="reports" class="tab-content">
            <div class="tab-header">
                <h3>Recruitment Reports</h3>
                <div class="tab-actions">
                    <div class="date-range-picker">
                        <input type="date" class="form-control" value="{{ now()->subMonths(6)->format('Y-m-d') }}">
                        <span>to</span>
                        <input type="date" class="form-control" value="{{ now()->format('Y-m-d') }}">
                        <button class="btn btn-primary">Apply</button>
                    </div>
                    <button class="btn btn-outline">
                        <i class="fas fa-download" aria-hidden="true"></i> Export
                    </button>
                </div>
            </div>

            <div class="reports-grid">
                <div class="report-card">
                    <h4>Applications by Department</h4>
                    <div class="chart-container">
                        <div class="chart-placeholder">
                            <i class="fas fa-chart-pie" aria-hidden="true"></i>
                            <span>Pie Chart: Applications by Department</span>
                        </div>
                    </div>
                </div>
                
                <div class="report-card">
                    <h4>Applications Over Time</h4>
                    <div class="chart-container">
                        <div class="chart-placeholder">
                            <i class="fas fa-chart-line" aria-hidden="true"></i>
                            <span>Line Chart: Applications Over Time</span>
                        </div>
                    </div>
                </div>
                
                <div class="report-card">
                    <h4>Hiring Funnel</h4>
                    <div class="chart-container">
                        <div class="chart-placeholder">
                            <i class="fas fa-filter" aria-hidden="true"></i>
                            <span>Funnel Chart: Application to Hire</span>
                        </div>
                    </div>
                </div>
                
                <div class="report-card">
                    <h4>Time to Fill Positions</h4>
                    <div class="chart-container">
                        <div class="chart-placeholder">
                            <i class="fas fa-chart-bar" aria-hidden="true"></i>
                            <span>Bar Chart: Time to Fill by Department</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="report-summary">
                <h4>Summary Statistics</h4>
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="summary-label">Total Applications</div>
                        <div class="summary-value">{{ $reportData['summary']['totalApplications'] }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Avg. Time to Hire</div>
                        <div class="summary-value">{{ round($reportData['summary']['avgTimeToHire']) }} days</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Acceptance Rate</div>
                        <div class="summary-value">{{ $reportData['summary']['acceptanceRate'] }}%</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Cost per Hire</div>
                        <div class="summary-value">${{ $reportData['summary']['costPerHire'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Position Modal -->
<div id="addPositionModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-briefcase" aria-hidden="true"></i> Post New Position</h3>
            <button class="close-modal" aria-label="Close modal">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="positionForm">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="positionTitle">Position Title</label>
                        <select id="positionTitle" name="position_id" class="form-control" required>
                            <option value="">Select Position</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}">{{ $position->position_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="department">Department</label>
                        <select id="department" name="department_id" class="form-control" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="location">Location</label>
                        <input type="text" id="location" name="location" class="form-control" placeholder="e.g. Main Hospital, East Wing" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="employmentType">Employment Type</label>
                        <select id="employmentType" name="employment_type" class="form-control" required>
                            <option value="">Select Type</option>
                            @foreach($employmentTypes as $type)
                                <option value="{{ $type->type_name }}">{{ $type->type_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="description">Job Description</label>
                    <textarea id="description" name="description" class="form-control" rows="5" placeholder="Describe the role, responsibilities, and qualifications..." required></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="requirements">Requirements</label>
                        <textarea id="requirements" name="requirements" class="form-control" rows="3" placeholder="List education, experience, and skills required..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="benefits">Benefits</label>
                        <textarea id="benefits" name="benefits" class="form-control" rows="3" placeholder="List salary, healthcare, PTO, and other benefits..." required></textarea>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="salary">Salary Range</label>
                        <input type="text" id="salary" name="salary_range" class="form-control" placeholder="e.g. $50,000 - $65,000">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="deadline">Application Deadline</label>
                        <input type="date" id="deadline" name="application_deadline" class="form-control" required>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" id="savePosition">
                    <i class="fas fa-save" aria-hidden="true"></i> Post Position
                </button>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" id="cancelPosition">
                <i class="fas fa-times" aria-hidden="true"></i> Cancel
            </button>
        </div>
    </div>
</div>

<!-- View Application Modal -->
<div id="viewApplicationModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-file-alt" aria-hidden="true"></i> Application Details</h3>
            <button class="close-modal" aria-label="Close modal">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="application-header">
                <div class="applicant-profile">
                    <div class="applicant-avatar large">JD</div>
                    <div class="applicant-info-large">
                        <h4>John Doe</h4>
                        <div class="applicant-contact">
                            <span><i class="fas fa-envelope" aria-hidden="true"></i> john.doe@example.com</span>
                            <span><i class="fas fa-phone" aria-hidden="true"></i> (555) 123-4567</span>
                        </div>
                        <div class="applicant-meta">
                            <span><i class="fas fa-map-marker-alt" aria-hidden="true"></i> San Francisco, CA</span>
                            <span><i class="fas fa-briefcase" aria-hidden="true"></i> 8 years experience</span>
                        </div>
                    </div>
                </div>
                <div class="application-status">
                    <span class="status-badge status-new">New</span>
                    <div class="status-selector">
                        <select class="form-control">
                            <option value="new">New</option>
                            <option value="reviewing">Reviewing</option>
                            <option value="interview">Interview</option>
                            <option value="hired">Hired</option>
                            <option value="rejected">Rejected</option>
                        </select>
                        <button class="btn btn-primary btn-sm">Update</button>
                    </div>
                </div>
            </div>
            
            <div class="application-tabs">
                <button class="application-tab-btn active" data-tab="resume">
                    <i class="fas fa-file-alt" aria-hidden="true"></i> Resume
                </button>
                <button class="application-tab-btn" data-tab="cover-letter">
                    <i class="fas fa-envelope-open-text" aria-hidden="true"></i> Cover Letter
                </button>
                <button class="application-tab-btn" data-tab="documents">
                    <i class="fas fa-folder-open" aria-hidden="true"></i> Documents
                </button>
                <button class="application-tab-btn" data-tab="notes">
                    <i class="fas fa-sticky-note" aria-hidden="true"></i> Notes
                </button>
            </div>
            
            <div class="application-tab-content active" id="resume">
                <!-- This will be populated dynamically -->
            </div>
            
            <div class="application-tab-content" id="cover-letter">
                <!-- This will be populated dynamically -->
            </div>
            
            <div class="application-tab-content" id="documents">
                <!-- This will be populated dynamically -->
            </div>
            
            <div class="application-tab-content" id="notes">
                <!-- This will be populated dynamically -->
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" id="closeApplicationModal">
                <i class="fas fa-times" aria-hidden="true"></i> Close
            </button>
            <button class="btn btn-primary" id="scheduleInterviewBtn">
                <i class="fas fa-calendar-plus" aria-hidden="true"></i> Schedule Interview
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/recruit/recruit.js') }}"></script>
@endsection