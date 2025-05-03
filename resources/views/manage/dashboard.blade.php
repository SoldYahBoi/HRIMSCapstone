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
                    <i class="fas fa-arrow-up"></i> 4.5%
                </span>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-content">
                <h3>Present Today</h3>
                <p class="stats-number">412</p>
                <span class="stats-change">
                    <i class="fas fa-circle"></i> 84.6%
                </span>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-content">
                <h3>On Leave</h3>
                <p class="stats-number">32</p>
                <span class="stats-change">
                    <i class="fas fa-circle"></i> 6.6%
                </span>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-user-clock"></i>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-content">
                <h3>Open Positions</h3>
                <p class="stats-number">14</p>
                <span class="stats-change negative">
                    <i class="fas fa-arrow-down"></i> 2.1%
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
                <div class="department-bar">
                    <div class="dept-label">Nursing</div>
                    <div class="dept-bar-wrapper">
                        <div class="dept-bar-fill" style="width: 65%;">
                            <span>156</span>
                        </div>
                    </div>
                </div>
                <div class="department-bar">
                    <div class="dept-label">Physicians</div>
                    <div class="dept-bar-wrapper">
                        <div class="dept-bar-fill" style="width: 42%;">
                            <span>98</span>
                        </div>
                    </div>
                </div>
                <div class="department-bar">
                    <div class="dept-label">Admin</div>
                    <div class="dept-bar-wrapper">
                        <div class="dept-bar-fill" style="width: 35%;">
                            <span>84</span>
                        </div>
                    </div>
                </div>
                <div class="department-bar">
                    <div class="dept-label">Laboratory</div>
                    <div class="dept-bar-wrapper">
                        <div class="dept-bar-fill" style="width: 28%;">
                            <span>67</span>
                        </div>
                    </div>
                </div>
                <div class="department-bar">
                    <div class="dept-label">Pharmacy</div>
                    <div class="dept-bar-wrapper">
                        <div class="dept-bar-fill" style="width: 22%;">
                            <span>52</span>
                        </div>
                    </div>
                </div>
                <div class="department-bar">
                    <div class="dept-label">Radiology</div>
                    <div class="dept-bar-wrapper">
                        <div class="dept-bar-fill" style="width: 12%;">
                            <span>30</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Recent Activities -->
        <section class="dashboard-card recent-activities">
            <div class="card-header">
                <h2>Recent Activities</h2>
                <a href="#" class="view-all">View All</a>
            </div>
            <ul class="activity-list">
                <li class="activity-item">
                    <div class="activity-icon bg-primary">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-text"><strong>Dr. Sarah Johnson</strong> was added to Cardiology</p>
                        <span class="activity-time">2 hours ago</span>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon bg-success">
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-text"><strong>Nurse Training Program</strong> completed by 12 staff members</p>
                        <span class="activity-time">Yesterday</span>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon bg-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-text"><strong>May Shift Schedule</strong> has been published</p>
                        <span class="activity-time">Yesterday</span>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon bg-danger">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-text"><strong>Compliance Training</strong> deadline approaching for 24 employees</p>
                        <span class="activity-time">2 days ago</span>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon bg-secondary">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-text"><strong>Professional Development</strong> budget approved for Q2</p>
                        <span class="activity-time">3 days ago</span>
                    </div>
                </li>
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
                <a href="#" class="view-all">View All</a>
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
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="employee-avatar">JD</div>
                                    <div>
                                        <div class="employee-name">John Doe</div>
                                        <div class="employee-email">john.doe@hospital.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>Registered Nurse</td>
                            <td><span class="department-badge dept-nursing">Nursing</span></td>
                            <td><span class="status-badge active">Active</span></td>
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
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="employee-avatar">JS</div>
                                    <div>
                                        <div class="employee-name">Jane Smith</div>
                                        <div class="employee-email">jane.smith@hospital.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>Lab Technician</td>
                            <td><span class="department-badge dept-laboratory">Laboratory</span></td>
                            <td><span class="status-badge active">Active</span></td>
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
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="employee-avatar">RM</div>
                                    <div>
                                        <div class="employee-name">Robert Miller</div>
                                        <div class="employee-email">robert.miller@hospital.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>Pharmacist</td>
                            <td><span class="department-badge dept-pharmacy">Pharmacy</span></td>
                            <td><span class="status-badge training">Training</span></td>
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
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="employee-avatar">SJ</div>
                                    <div>
                                        <div class="employee-name">Sarah Johnson</div>
                                        <div class="employee-email">sarah.johnson@hospital.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>Radiologist</td>
                            <td><span class="department-badge dept-radiology">Radiology</span></td>
                            <td><span class="status-badge active">Active</span></td>
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
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="employee-avatar">MP</div>
                                    <div>
                                        <div class="employee-name">Michael Patel</div>
                                        <div class="employee-email">michael.patel@hospital.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>HR Specialist</td>
                            <td><span class="department-badge dept-admin">Admin</span></td>
                            <td><span class="status-badge active">Active</span></td>
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
                        <circle cx="75" cy="75" r="60" fill="none" stroke="#2563eb" stroke-width="15" stroke-dasharray="377" stroke-dashoffset="94.25" transform="rotate(-90 75 75)" />
                        <text x="75" y="75" text-anchor="middle" dominant-baseline="middle" font-size="24" font-weight="bold">75%</text>
                        <text x="75" y="95" text-anchor="middle" dominant-baseline="middle" font-size="12">Compliant</text>
                    </svg>
                </div>
                <div class="compliance-legend">
                    <div class="compliance-item">
                        <div class="compliance-status">
                            <span class="status-dot complete"></span>
                            <span>Complete</span>
                        </div>
                        <div class="compliance-count">365</div>
                    </div>
                    <div class="compliance-item">
                        <div class="compliance-status">
                            <span class="status-dot pending"></span>
                            <span>Pending</span>
                        </div>
                        <div class="compliance-count">98</div>
                    </div>
                    <div class="compliance-item">
                        <div class="compliance-status">
                            <span class="status-dot overdue"></span>
                            <span>Overdue</span>
                        </div>
                        <div class="compliance-count">24</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection