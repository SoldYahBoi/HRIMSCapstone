@extends('layout.mainLayout')

@section('title')
    Dashboard
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('page-actions')
    <div class="dashboard-actions">
        <button class="btn btn-outline">
            <i class="fas fa-calendar-alt"></i> Today: {{ date('M d, Y') }}
        </button>
        <a href="/admin/create">
            <button class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Employee
            </button>
        </a>
    </div>
@endsection

@section('content')
    <!-- Dashboard Overview Stats -->
    <section class="stats-overview">
        <div class="stats-card">
            <div class="stats-card-content">
                <h3>Total Employees</h3>
                <p class="stats-number">{{$totalEmployee}}</p>
                <span class="stats-change positive">
                    <i class="fas fa-arrow-up"></i> Active
                </span>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-content">
                <h3>Present Today</h3>
                <p class="stats-number">{{$presentToday}}</p>
                <span class="stats-change">
                    <i class="fas fa-circle"></i> Active
                </span>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-content">
                <h3>On Leave</h3>
                <p class="stats-number">{{$onLeave}}</p>
                <span class="stats-change">
                    <i class="fas fa-circle"></i> On Leave
                </span>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-user-clock"></i>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-content">
                <h3>Open Positions</h3>
                <p class="stats-number">{{$openPositions}}</p>
                <span class="stats-change negative">
                    <i class="fas fa-arrow-down"></i> Available
                </span>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-briefcase"></i>
            </div>
        </div>
    </section>

    <!-- Main Dashboard Content -->
    <div class="dashboard-grid">
        <!-- Department Overview -->
        <section class="dashboard-card department-overview">
            <div class="card-header">
                <h2>Department Overview</h2>
                <div class="card-actions">
                    <button class="btn btn-sm btn-outline">
                        <i class="fas fa-filter"></i>
                    </button>
                    <button class="btn btn-sm btn-outline">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>
            <div class="department-chart">
                @foreach($departments as $department)
                <div class="department-bar">
                    <div class="dept-label">{{ $department->name ?? $department->department_name ?? 'N/A' }}</div>
                    <div class="dept-bar-wrapper">
                        <div class="dept-bar-fill" style="width: {{($department->employees_count / $totalEmployee) * 100}}%;">
                            <span>{{$department->employees_count}}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Recent Activities -->
        <section class="dashboard-card recent-activities">
            <div class="card-header">
                <h2>Recent Activities</h2>
                <a href="#" class="view-all">View All</a>
            </div>
            <ul class="activity-list">
                @foreach($recentActivities as $activity)
                <li class="activity-item">
                    <div class="activity-icon bg-primary">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-text">
                            <strong>{{ $activity->first_name }} {{ $activity->last_name }}</strong> 
                            was updated in {{ $activity->department->name ?? $activity->department->department_name ?? 'N/A' }}
                        </p>
                        <span class="activity-time">{{$activity->updated_at->diffForHumans()}}</span>
                    </div>
                </li>
                @endforeach
            </ul>
        </section>

        <!-- Quick Actions -->
        <section class="dashboard-card quick-actions">
            <div class="card-header">
                <h2>Quick Actions</h2>
            </div>
            <div class="quick-actions-grid">
                <a href="#" class="quick-action-item">
                    <i class="fas fa-user-plus"></i>
                    <span>Add Employee</span>
                </a>
                <a href="#" class="quick-action-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Manage Shifts</span>
                </a>
                <a href="#" class="quick-action-item">
                    <i class="fas fa-file-alt"></i>
                    <span>Leave Requests</span>
                </a>
                <a href="#" class="quick-action-item">
                    <i class="fas fa-chart-pie"></i>
                    <span>Reports</span>
                </a>
                <a href="#" class="quick-action-item">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Attendance</span>
                </a>
                <a href="#" class="quick-action-item">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Payroll</span>
                </a>
                <a href="#" class="quick-action-item">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Training</span>
                </a>
                <a href="#" class="quick-action-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </div>
        </section>

        <!-- Upcoming Events -->
        <section class="dashboard-card upcoming-events">
            <div class="card-header">
                <h2>Upcoming Events</h2>
                <a href="#" class="view-all">View Calendar</a>
            </div>
            <ul class="events-list">
                <li class="event-item">
                    <div class="event-date">
                        <span class="event-month">APR</span>
                        <span class="event-day">15</span>
                    </div>
                    <div class="event-content">
                        <h4 class="event-title">Staff Meeting</h4>
                        <p class="event-details">
                            <i class="fas fa-clock"></i> 9:00 AM - 10:30 AM
                            <i class="fas fa-map-marker-alt"></i> Conference Room A
                        </p>
                    </div>
                </li>
                <li class="event-item">
                    <div class="event-date">
                        <span class="event-month">APR</span>
                        <span class="event-day">18</span>
                    </div>
                    <div class="event-content">
                        <h4 class="event-title">New Hire Orientation</h4>
                        <p class="event-details">
                            <i class="fas fa-clock"></i> 8:30 AM - 4:00 PM
                            <i class="fas fa-map-marker-alt"></i> Training Center
                        </p>
                    </div>
                </li>
                <li class="event-item">
                    <div class="event-date">
                        <span class="event-month">APR</span>
                        <span class="event-day">22</span>
                    </div>
                    <div class="event-content">
                        <h4 class="event-title">Benefits Enrollment Deadline</h4>
                        <p class="event-details">
                            <i class="fas fa-clock"></i> 11:59 PM
                        </p>
                    </div>
                </li>
                <li class="event-item">
                    <div class="event-date">
                        <span class="event-month">APR</span>
                        <span class="event-day">30</span>
                    </div>
                    <div class="event-content">
                        <h4 class="event-title">Quarterly Performance Review</h4>
                        <p class="event-details">
                            <i class="fas fa-clock"></i> All Day
                        </p>
                    </div>
                </li>
            </ul>
        </section>

        <!-- Recent Employees -->
        <section class="dashboard-card recent-employees">
            <div class="card-header">
                <h2>Recent Employees</h2>
                <a href="/employees" class="view-all">View All</a>
            </div>
            <div class="table-container">
                <table class="employees-table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentEmployees as $employee)
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="employee-avatar">{{substr($employee->first_name, 0, 1)}}{{substr($employee->last_name, 0, 1)}}</div>
                                    <div>
                                        <div class="employee-name">{{$employee->first_name}} {{$employee->last_name}}</div>
                                        <div class="employee-email">{{$employee->email}}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $employee->position->name ?? $employee->position->position_name ?? 'N/A' }}</td>
                            <td><span class="department-badge dept-{{ strtolower($employee->department->name ?? $employee->department->department_name ?? 'none') }}">{{ $employee->department->name ?? $employee->department->department_name ?? 'N/A' }}</span></td>
                            <td><span class="status-badge {{strtolower($employee->status)}}">{{$employee->status}}</span></td>
                            <td>
                                <div class="table-actions">
                                    <button class="btn-icon" title="View Profile">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-icon" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Compliance Status -->
        <section class="dashboard-card compliance-status">
            <div class="card-header">
                <h2>Compliance Status</h2>
                <div class="card-actions">
                    <button class="btn btn-sm btn-outline">
                        <i class="fas fa-bell"></i> Send Reminders
                    </button>
                </div>
            </div>
            <div class="compliance-chart">
                <div class="compliance-donut">
                    <svg width="150" height="150" viewBox="0 0 150 150">
                        <circle cx="75" cy="75" r="60" fill="none" stroke="#e2e8f0" stroke-width="15" />
                        <circle cx="75" cy="75" r="60" fill="none" stroke="#2563eb" stroke-width="15" 
                            stroke-dasharray="377" 
                            stroke-dashoffset="{{377 - (377 * $compliancePercentage / 100)}}" 
                            transform="rotate(-90 75 75)" />
                        <text x="75" y="75" text-anchor="middle" dominant-baseline="middle" font-size="24" font-weight="bold">{{$compliancePercentage}}%</text>
                        <text x="75" y="95" text-anchor="middle" dominant-baseline="middle" font-size="12">Compliant</text>
                    </svg>
                </div>
                <div class="compliance-legend">
                    <div class="compliance-item">
                        <div class="compliance-status">
                            <span class="status-dot complete"></span>
                            <span>Complete</span>
                        </div>
                        <div class="compliance-count">{{$completeDocuments}}</div>
                    </div>
                    <div class="compliance-item">
                        <div class="compliance-status">
                            <span class="status-dot pending"></span>
                            <span>Pending</span>
                        </div>
                        <div class="compliance-count">{{$pendingDocuments}}</div>
                    </div>
                    <div class="compliance-item">
                        <div class="compliance-status">
                            <span class="status-dot overdue"></span>
                            <span>Overdue</span>
                        </div>
                        <div class="compliance-count">{{$overdueDocuments}}</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection