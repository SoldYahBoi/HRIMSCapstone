@extends('layout.mainLayout')

@section('title')
    Recruitment Management
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/recruit/recruit.css') }}">
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
            <div class="stat-card-value">12</div>
            <div class="stat-card-icon"><i class="fas fa-briefcase" aria-hidden="true"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-card-title">New Applications</div>
            <div class="stat-card-value">28</div>
            <div class="stat-card-icon"><i class="fas fa-file-alt" aria-hidden="true"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-card-title">Interviews Scheduled</div>
            <div class="stat-card-value">8</div>
            <div class="stat-card-icon"><i class="fas fa-calendar-check" aria-hidden="true"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-card-title">Positions Filled</div>
            <div class="stat-card-value">5</div>
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
                            <option value="nursing">Nursing</option>
                            <option value="admin">Administration</option>
                            <option value="pharmacy">Pharmacy</option>
                            <option value="laboratory">Laboratory</option>
                            <option value="radiology">Radiology</option>
                            <option value="emergency">Emergency</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="positions-grid">
                <!-- Position Card 1 -->
                <div class="position-card">
                    <div class="position-header">
                        <span class="department-badge dept-nursing">Nursing</span>
                        <div class="position-actions">
                            <button class="btn-icon edit-position" data-id="1" title="Edit Position">
                                <i class="fas fa-edit" aria-hidden="true"></i>
                            </button>
                            <button class="btn-icon delete-position" data-id="1" title="Delete Position">
                                <i class="fas fa-trash-alt" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <h4 class="position-title">Head Nurse - Pediatrics</h4>
                    <div class="position-meta">
                        <span><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Main Hospital</span>
                        <span><i class="fas fa-clock" aria-hidden="true"></i> Full-time</span>
                    </div>
                    <p class="position-description">
                        Experienced head nurse needed to lead our pediatric department. Minimum 5 years experience required.
                    </p>
                    <div class="position-stats">
                        <div class="stat">
                            <span class="stat-value">8</span>
                            <span class="stat-label">Applicants</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">3</span>
                            <span class="stat-label">Interviews</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">Jun 30</span>
                            <span class="stat-label">Deadline</span>
                        </div>
                    </div>
                    <div class="position-footer">
                        <button class="btn btn-outline view-applicants" data-id="1">
                            <i class="fas fa-users" aria-hidden="true"></i> View Applicants
                        </button>
                        <button class="btn btn-primary">
                            <i class="fas fa-share-alt" aria-hidden="true"></i> Share
                        </button>
                    </div>
                </div>

                <!-- Position Card 2 -->
                <div class="position-card">
                    <div class="position-header">
                        <span class="department-badge dept-pharmacy">Pharmacy</span>
                        <div class="position-actions">
                            <button class="btn-icon edit-position" data-id="2" title="Edit Position">
                                <i class="fas fa-edit" aria-hidden="true"></i>
                            </button>
                            <button class="btn-icon delete-position" data-id="2" title="Delete Position">
                                <i class="fas fa-trash-alt" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <h4 class="position-title">Clinical Pharmacist</h4>
                    <div class="position-meta">
                        <span><i class="fas fa-map-marker-alt" aria-hidden="true"></i> East Wing</span>
                        <span><i class="fas fa-clock" aria-hidden="true"></i> Full-time</span>
                    </div>
                    <p class="position-description">
                        Clinical pharmacist needed to join our growing team. Must have experience in hospital pharmacy settings.
                    </p>
                    <div class="position-stats">
                        <div class="stat">
                            <span class="stat-value">12</span>
                            <span class="stat-label">Applicants</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">5</span>
                            <span class="stat-label">Interviews</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">Jul 15</span>
                            <span class="stat-label">Deadline</span>
                        </div>
                    </div>
                    <div class="position-footer">
                        <button class="btn btn-outline view-applicants" data-id="2">
                            <i class="fas fa-users" aria-hidden="true"></i> View Applicants
                        </button>
                        <button class="btn btn-primary">
                            <i class="fas fa-share-alt" aria-hidden="true"></i> Share
                        </button>
                    </div>
                </div>

                <!-- Position Card 3 -->
                <div class="position-card">
                    <div class="position-header">
                        <span class="department-badge dept-laboratory">Laboratory</span>
                        <div class="position-actions">
                            <button class="btn-icon edit-position" data-id="3" title="Edit Position">
                                <i class="fas fa-edit" aria-hidden="true"></i>
                            </button>
                            <button class="btn-icon delete-position" data-id="3" title="Delete Position">
                                <i class="fas fa-trash-alt" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <h4 class="position-title">Medical Laboratory Technician</h4>
                    <div class="position-meta">
                        <span><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Main Laboratory</span>
                        <span><i class="fas fa-clock" aria-hidden="true"></i> Part-time</span>
                    </div>
                    <p class="position-description">
                        Medical laboratory technician needed for sample processing and analysis. Evening shifts available.
                    </p>
                    <div class="position-stats">
                        <div class="stat">
                            <span class="stat-value">6</span>
                            <span class="stat-label">Applicants</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">0</span>
                            <span class="stat-label">Interviews</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">Aug 5</span>
                            <span class="stat-label">Deadline</span>
                        </div>
                    </div>
                    <div class="position-footer">
                        <button class="btn btn-outline view-applicants" data-id="3">
                            <i class="fas fa-users" aria-hidden="true"></i> View Applicants
                        </button>
                        <button class="btn btn-primary">
                            <i class="fas fa-share-alt" aria-hidden="true"></i> Share
                        </button>
                    </div>
                </div>

                <!-- Position Card 4 -->
                <div class="position-card">
                    <div class="position-header">
                        <span class="department-badge dept-admin">Administration</span>
                        <div class="position-actions">
                            <button class="btn-icon edit-position" data-id="4" title="Edit Position">
                                <i class="fas fa-edit" aria-hidden="true"></i>
                            </button>
                            <button class="btn-icon delete-position" data-id="4" title="Delete Position">
                                <i class="fas fa-trash-alt" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <h4 class="position-title">Administrative Assistant</h4>
                    <div class="position-meta">
                        <span><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Admin Office</span>
                        <span><i class="fas fa-clock" aria-hidden="true"></i> Full-time</span>
                    </div>
                    <p class="position-description">
                        Administrative assistant needed to support hospital operations. Strong organizational skills required.
                    </p>
                    <div class="position-stats">
                        <div class="stat">
                            <span class="stat-value">15</span>
                            <span class="stat-label">Applicants</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">7</span>
                            <span class="stat-label">Interviews</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">Jun 20</span>
                            <span class="stat-label">Deadline</span>
                        </div>
                    </div>
                    <div class="position-footer">
                        <button class="btn btn-outline view-applicants" data-id="4">
                            <i class="fas fa-users" aria-hidden="true"></i> View Applicants
                        </button>
                        <button class="btn btn-primary">
                            <i class="fas fa-share-alt" aria-hidden="true"></i> Share
                        </button>
                    </div>
                </div>
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
                        <tr>
                            <td>
                                <div class="applicant-info">
                                    <div class="applicant-avatar">JD</div>
                                    <div>
                                        <div class="applicant-name">John Doe</div>
                                        <div class="applicant-email">john.doe@example.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>Head Nurse - Pediatrics</td>
                            <td><span class="department-badge dept-nursing">Nursing</span></td>
                            <td>Jun 5, 2023</td>
                            <td><span class="status-badge status-new">New</span></td>
                            <td>
                                <div class="application-actions">
                                    <button class="btn-icon view-application" data-id="1" title="View Application">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn-icon schedule-interview" data-id="1" title="Schedule Interview">
                                        <i class="fas fa-calendar-plus" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn-icon reject-application" data-id="1" title="Reject Application">
                                        <i class="fas fa-times-circle" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="applicant-info">
                                    <div class="applicant-avatar">JS</div>
                                    <div>
                                        <div class="applicant-name">Jane Smith</div>
                                        <div class="applicant-email">jane.smith@example.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>Clinical Pharmacist</td>
                            <td><span class="department-badge dept-pharmacy">Pharmacy</span></td>
                            <td>Jun 8, 2023</td>
                            <td><span class="status-badge status-reviewing">Reviewing</span></td>
                            <td>
                                <div class="application-actions">
                                    <button class="btn-icon view-application" data-id="2" title="View Application">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn-icon schedule-interview" data-id="2" title="Schedule Interview">
                                        <i class="fas fa-calendar-plus" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn-icon reject-application" data-id="2" title="Reject Application">
                                        <i class="fas fa-times-circle" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="applicant-info">
                                    <div class="applicant-avatar">MJ</div>
                                    <div>
                                        <div class="applicant-name">Mike Johnson</div>
                                        <div class="applicant-email">mike.j@example.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>Medical Laboratory Technician</td>
                            <td><span class="department-badge dept-laboratory">Laboratory</span></td>
                            <td>Jun 10, 2023</td>
                            <td><span class="status-badge status-interview">Interview</span></td>
                            <td>
                                <div class="application-actions">
                                    <button class="btn-icon view-application" data-id="3" title="View Application">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn-icon hire-applicant" data-id="3" title="Hire Applicant">
                                        <i class="fas fa-user-check" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn-icon reject-application" data-id="3" title="Reject Application">
                                        <i class="fas fa-times-circle" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="applicant-info">
                                    <div class="applicant-avatar">SR</div>
                                    <div>
                                        <div class="applicant-name">Sarah Rodriguez</div>
                                        <div class="applicant-email">sarah.r@example.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>Administrative Assistant</td>
                            <td><span class="department-badge dept-admin">Administration</span></td>
                            <td>Jun 12, 2023</td>
                            <td><span class="status-badge status-hired">Hired</span></td>
                            <td>
                                <div class="application-actions">
                                    <button class="btn-icon view-application" data-id="4" title="View Application">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn-icon onboarding" data-id="4" title="Start Onboarding">
                                        <i class="fas fa-clipboard-list" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="applicant-info">
                                    <div class="applicant-avatar">TW</div>
                                    <div>
                                        <div class="applicant-name">Tom Wilson</div>
                                        <div class="applicant-email">tom.w@example.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>Head Nurse - Pediatrics</td>
                            <td><span class="department-badge dept-nursing">Nursing</span></td>
                            <td>Jun 15, 2023</td>
                            <td><span class="status-badge status-rejected">Rejected</span></td>
                            <td>
                                <div class="application-actions">
                                    <button class="btn-icon view-application" data-id="5" title="View Application">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn-icon restore-application" data-id="5" title="Restore Application">
                                        <i class="fas fa-undo" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <button class="btn btn-outline pagination-btn" disabled>
                    <i class="fas fa-chevron-left" aria-hidden="true"></i> Previous
                </button>
                <span class="pagination-info">Page 1 of 1</span>
                <button class="btn btn-outline pagination-btn" disabled>
                    Next <i class="fas fa-chevron-right" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <!-- Interviews Tab -->
        <div id="interviews" class="tab-content">
            <div class="tab-header">
                <h3>Scheduled Interviews</h3>
                <div class="tab-actions">
                    <button class="btn btn-primary">
                        <i class="fas fa-calendar-plus" aria-hidden="true"></i> Schedule New Interview
                    </button>
                </div>
            </div>

            <div class="calendar-view">
                <div class="calendar-header">
                    <button class="btn btn-outline calendar-nav-btn">
                        <i class="fas fa-chevron-left" aria-hidden="true"></i>
                    </button>
                    <h4>June 2023</h4>
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
                    <div class="calendar-day inactive">28</div>
                    <div class="calendar-day inactive">29</div>
                    <div class="calendar-day inactive">30</div>
                    <div class="calendar-day inactive">31</div>
                    <div class="calendar-day">1</div>
                    <div class="calendar-day">2</div>
                    <div class="calendar-day">3</div>
                    <div class="calendar-day">4</div>
                    <div class="calendar-day">5</div>
                    <div class="calendar-day">6</div>
                    <div class="calendar-day">7</div>
                    <div class="calendar-day">8</div>
                    <div class="calendar-day">9</div>
                    <div class="calendar-day">10</div>
                    <div class="calendar-day">11</div>
                    <div class="calendar-day">12</div>
                    <div class="calendar-day">13</div>
                    <div class="calendar-day">14</div>
                    <div class="calendar-day">15</div>
                    <div class="calendar-day has-events">
                        16
                        <div class="event-indicator" data-count="2"></div>
                    </div>
                    <div class="calendar-day">17</div>
                    <div class="calendar-day">18</div>
                    <div class="calendar-day has-events">
                        19
                        <div class="event-indicator" data-count="3"></div>
                    </div>
                    <div class="calendar-day">20</div>
                    <div class="calendar-day has-events">
                        21
                        <div class="event-indicator" data-count="1"></div>
                    </div>
                    <div class="calendar-day">22</div>
                    <div class="calendar-day">23</div>
                    <div class="calendar-day">24</div>
                    <div class="calendar-day">25</div>
                    <div class="calendar-day has-events">
                        26
                        <div class="event-indicator" data-count="2"></div>
                    </div>
                    <div class="calendar-day">27</div>
                    <div class="calendar-day">28</div>
                    <div class="calendar-day">29</div>
                    <div class="calendar-day">30</div>
                    <div class="calendar-day inactive">1</div>
                    <div class="calendar-day inactive">2</div>
                    <div class="calendar-day inactive">3</div>
                    <div class="calendar-day inactive">4</div>
                    <div class="calendar-day inactive">5</div>
                    <div class="calendar-day inactive">6</div>
                    <div class="calendar-day inactive">7</div>
                    <div class="calendar-day inactive">8</div>
                </div>
            </div>

            <div class="upcoming-interviews">
                <h4>Upcoming Interviews</h4>
                <div class="interview-list">
                    <div class="interview-card">
                        <div class="interview-date">
                            <div class="date-day">16</div>
                            <div class="date-month">Jun</div>
                        </div>
                        <div class="interview-details">
                            <div class="interview-title">Mike Johnson - Medical Laboratory Technician</div>
                            <div class="interview-meta">
                                <span><i class="fas fa-clock" aria-hidden="true"></i> 10:00 AM - 11:00 AM</span>
                                <span><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Conference Room B</span>
                                <span><i class="fas fa-user" aria-hidden="true"></i> Dr. Lisa Chen</span>
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
                    
                    <div class="interview-card">
                        <div class="interview-date">
                            <div class="date-day">16</div>
                            <div class="date-month">Jun</div>
                        </div>
                        <div class="interview-details">
                            <div class="interview-title">Jane Smith - Clinical Pharmacist</div>
                            <div class="interview-meta">
                                <span><i class="fas fa-clock" aria-hidden="true"></i> 2:00 PM - 3:00 PM</span>
                                <span><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Pharmacy Office</span>
                                <span><i class="fas fa-user" aria-hidden="true"></i> Dr. Robert Kim</span>
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
                    
                    <div class="interview-card">
                        <div class="interview-date">
                            <div class="date-day">19</div>
                            <div class="date-month">Jun</div>
                        </div>
                        <div class="interview-details">
                            <div class="interview-title">John Doe - Head Nurse - Pediatrics</div>
                            <div class="interview-meta">
                                <span><i class="fas fa-clock" aria-hidden="true"></i> 9:00 AM - 10:30 AM</span>
                                <span><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Conference Room A</span>
                                <span><i class="fas fa-user" aria-hidden="true"></i> Dr. Maria Garcia</span>
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
                </div>
            </div>
        </div>

        <!-- Reports Tab -->
        <div id="reports" class="tab-content">
            <div class="tab-header">
                <h3>Recruitment Reports</h3>
                <div class="tab-actions">
                    <div class="date-range-picker">
                        <input type="date" class="form-control" value="2023-01-01">
                        <span>to</span>
                        <input type="date" class="form-control" value="2023-06-30">
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
                        <div class="summary-value">156</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Avg. Time to Hire</div>
                        <div class="summary-value">18 days</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Acceptance Rate</div>
                        <div class="summary-value">85%</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Cost per Hire</div>
                        <div class="summary-value">$1,250</div>
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
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="positionTitle">Position Title</label>
                        <input type="text" id="positionTitle" class="form-control" placeholder="e.g. Head Nurse - Pediatrics" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="department">Department</label>
                        <select id="department" class="form-control" required>
                            <option value="">Select Department</option>
                            <option value="nursing">Nursing</option>
                            <option value="admin">Administration</option>
                            <option value="pharmacy">Pharmacy</option>
                            <option value="laboratory">Laboratory</option>
                            <option value="radiology">Radiology</option>
                            <option value="emergency">Emergency</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="location">Location</label>
                        <input type="text" id="location" class="form-control" placeholder="e.g. Main Hospital, East Wing" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="employmentType">Employment Type</label>
                        <select id="employmentType" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="full-time">Full-time</option>
                            <option value="part-time">Part-time</option>
                            <option value="contract">Contract</option>
                            <option value="temporary">Temporary</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="description">Job Description</label>
                    <textarea id="description" class="form-control" rows="5" placeholder="Describe the role, responsibilities, and qualifications..." required></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="requirements">Requirements</label>
                        <textarea id="requirements" class="form-control" rows="3" placeholder="List education, experience, and skills required..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="benefits">Benefits</label>
                        <textarea id="benefits" class="form-control" rows="3" placeholder="List salary, healthcare, PTO, and other benefits..." required></textarea>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="salary">Salary Range</label>
                        <input type="text" id="salary" class="form-control" placeholder="e.g. $50,000 - $65,000">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="deadline">Application Deadline</label>
                        <input type="date" id="deadline" class="form-control" required>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" id="cancelPosition">
                <i class="fas fa-times" aria-hidden="true"></i> Cancel
            </button>
            <button class="btn btn-primary" id="savePosition">
                <i class="fas fa-save" aria-hidden="true"></i> Post Position
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
                <div class="resume-preview">
                    <h4>Professional Summary</h4>
                    <p>Experienced head nurse with over 8 years of experience in pediatric care. Skilled in team leadership, patient care coordination, and implementing quality improvement initiatives.</p>
                    
                    <h4>Work Experience</h4>
                    <div class="resume-item">
                        <div class="resume-item-header">
                            <div class="resume-item-title">Senior Nurse</div>
                            <div class="resume-item-period">2018 - Present</div>
                        </div>
                        <div class="resume-item-subtitle">Memorial Children's Hospital</div>
                        <ul class="resume-item-details">
                            <li>Led a team of 12 nurses in the pediatric intensive care unit</li>
                            <li>Implemented new patient care protocols that reduced readmission rates by 15%</li>
                            <li>Mentored and trained new nursing staff</li>
                        </ul>
                    </div>
                    
                    <div class="resume-item">
                        <div class="resume-item-header">
                            <div class="resume-item-title">Registered Nurse</div>
                            <div class="resume-item-period">2015 - 2018</div>
                        </div>
                        <div class="resume-item-subtitle">City General Hospital</div>
                        <ul class="resume-item-details">
                            <li>Provided direct patient care in pediatric ward</li>
                            <li>Assisted in developing family-centered care initiatives</li>
                            <li>Participated in hospital quality improvement committee</li>
                        </ul>
                    </div>
                    
                    <h4>Education</h4>
                    <div class="resume-item">
                        <div class="resume-item-header">
                            <div class="resume-item-title">Master of Science in Nursing</div>
                            <div class="resume-item-period">2015</div>
                        </div>
                        <div class="resume-item-subtitle">State University</div>
                    </div>
                    
                    <div class="resume-item">
                        <div class="resume-item-header">
                            <div class="resume-item-title">Bachelor of Science in Nursing</div>
                            <div class="resume-item-period">2012</div>
                        </div>
                        <div class="resume-item-subtitle">City College</div>
                    </div>
                    
                    <h4>Certifications</h4>
                    <ul class="resume-certifications">
                        <li>Pediatric Advanced Life Support (PALS)</li>
                        <li>Certified Pediatric Nurse (CPN)</li>
                        <li>Basic Life Support (BLS)</li>
                    </ul>
                </div>
            </div>
            
            <div class="application-tab-content" id="cover-letter">
                <div class="cover-letter-preview">
                    <p>Dear Hiring Manager,</p>
                    <p>I am writing to express my interest in the Head Nurse position in the Pediatrics department at PDH Hospital. With over 8 years of experience in pediatric nursing, including 5 years in leadership roles, I am confident in my ability to lead your nursing team effectively.</p>
                    <p>Throughout my career, I have demonstrated a commitment to excellence in patient care and team leadership. At Memorial Children's Hospital, I successfully led a team of 12 nurses, implemented quality improvement initiatives, and mentored new staff members. My experience has taught me the importance of compassionate care, effective communication, and continuous improvement in healthcare settings.</p>
                    <p>I am particularly drawn to PDH Hospital because of your reputation for innovative pediatric care and family-centered approach. I believe my skills and experience align perfectly with your needs, and I am excited about the opportunity to contribute to your team.</p>
                    <p>Thank you for considering my application. I look forward to discussing how my background, skills, and experiences would be an asset to PDH Hospital.</p>
                    <p>Sincerely,<br>John Doe</p>
                </div>
            </div>
            
            <div class="application-tab-content" id="documents">
                <div class="documents-list">
                    <div class="document-item">
                        <i class="fas fa-file-pdf" aria-hidden="true"></i>
                        <span class="document-name">John_Doe_Resume.pdf</span>
                        <div class="document-actions">
                            <button class="btn-icon" title="Download">
                                <i class="fas fa-download" aria-hidden="true"></i>
                            </button>
                            <button class="btn-icon" title="View">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div class="document-item">
                        <i class="fas fa-file-pdf" aria-hidden="true"></i>
                        <span class="document-name">John_Doe_Cover_Letter.pdf</span>
                        <div class="document-actions">
                            <button class="btn-icon" title="Download">
                                <i class="fas fa-download" aria-hidden="true"></i>
                            </button>
                            <button class="btn-icon" title="View">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div class="document-item">
                        <i class="fas fa-file-image" aria-hidden="true"></i>
                        <span class="document-name">Nursing_License.jpg</span>
                        <div class="document-actions">
                            <button class="btn-icon" title="Download">
                                <i class="fas fa-download" aria-hidden="true"></i>
                            </button>
                            <button class="btn-icon" title="View">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div class="document-item">
                        <i class="fas fa-file-pdf" aria-hidden="true"></i>
                        <span class="document-name">CPN_Certification.pdf</span>
                        <div class="document-actions">
                            <button class="btn-icon" title="Download">
                                <i class="fas fa-download" aria-hidden="true"></i>
                            </button>
                            <button class="btn-icon" title="View">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="application-tab-content" id="notes">
                <div class="notes-container">
                    <div class="notes-list">
                        <div class="note-item">
                            <div class="note-header">
                                <div class="note-author">Maria Garcia</div>
                                <div class="note-date">Jun 10, 2023</div>
                            </div>
                            <div class="note-content">
                                Initial review completed. Strong candidate with excellent experience in pediatric nursing. Recommend scheduling an interview.
                            </div>
                        </div>
                        <div class="note-item">
                            <div class="note-header">
                                <div class="note-author">Robert Kim</div>
                                <div class="note-date">Jun 12, 2023</div>
                            </div>
                            <div class="note-content">
                                Checked references. Previous supervisor at Memorial Children's Hospital gave glowing recommendation. Confirmed leadership abilities and clinical skills.
                            </div>
                        </div>
                    </div>
                    <div class="add-note">
                        <textarea class="form-control" placeholder="Add a note about this candidate..."></textarea>
                        <button class="btn btn-primary">
                            <i class="fas fa-plus" aria-hidden="true"></i> Add Note
                        </button>
                    </div>
                </div>
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