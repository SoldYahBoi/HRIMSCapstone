@extends('layout.mainLayout')

@section('title')
    View Employee Details
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/view.css') }}">
@endsection

@section('page-title')
    Employee Details
@endsection

@section('content')
    @if(session('success'))
        <div class="success-popup">
            {{ session('success') }}
        </div>
    @endif
    <div class="view-header">
        <a href="/admin" class="btn btn-outline btn-back">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="employee-profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <h2>{{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }}</h2>
                <p>
                    @foreach($position as $position)
                        @if($employee->position_id == $position->id) 
                            {{ $position->position_name ?? 'No Position Assigned' }}
                        @endif
                    @endforeach
                </p>
                <div class="employee-status {{ strtolower($employee->status) }}">{{ $employee->status }}</div>
            </div>
            <div class="profile-actions">
                <a href="/admin/{{ $employee->id }}/edit" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>
        
        <div class="profile-tabs">
            <button class="tab-button active" data-tab="personal">
                <i class="fas fa-user"></i> Personal
            </button>
            <button class="tab-button" data-tab="contact">
                <i class="fas fa-address-card"></i> Contact
            </button>
            <button class="tab-button" data-tab="employment">
                <i class="fas fa-briefcase"></i> Employment
            </button>
        </div>
        
        <div class="profile-content">
            <!-- Personal Information Tab -->
            <div class="tab-content active" id="personal-tab">
                <div class="info-section">
                    <h3 class="info-title">Personal Information</h3>
                    
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Full Name</div>
                            <div class="info-value">{{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Date of Birth</div>
                            <div class="info-value">{{ date('F d, Y', strtotime($employee->birthdate)) }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Gender</div>
                            <div class="info-value">{{ $employee->gender }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Civil Status</div>
                            <div class="info-value">{{ $employee->civil_status }}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information Tab -->
            <div class="tab-content" id="contact-tab">
                <div class="info-section">
                    <h3 class="info-title">Contact Information</h3>
                    
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">{{ $employee->email }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Contact Number</div>
                            <div class="info-value">{{ $employee->contact_number }}</div>
                        </div>
                        
                        <div class="info-item full-width">
                            <div class="info-label">Residential Address</div>
                            <div class="info-value">{{ $employee->address }}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Employment Information Tab -->
            <div class="tab-content" id="employment-tab">
                <div class="info-section">
                    <h3 class="info-title">Employment Details</h3>
                    
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Employee ID</div>
                            <div class="info-value">{{ $employee->id }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Department</div>
                            <div class="info-value">
                                @foreach($department as $department)
                                    @if($employee->department_id == $department->id) 
                                        <div class = "department-badge dept-{{ strtolower($department->department_name) }}">
                                            {{ $department->department_name ?? 'Not Assigned' }}
                                        </div>                                       
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Position</div>
                            <div class="info-value">                               
                                {{$position->where('id', $employee->position_id)->first()->position_name ?? 'Not Assigned'}}
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Employment Type</div>
                            <div class="info-value">
                                @foreach($employment as $employment)
                                    @if($employee->employment_type_id == $employment->id) 
                                        {{ $employment->type_name ?? 'Not Assigned' }}
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Employment Status</div>
                            <div class="info-value status-badge {{ strtolower($employee->status) }}">{{ $employee->status }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Hire Date</div>
                            <div class="info-value">{{ date('F d, Y', strtotime($employee->hire_date)) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/view.js') }}"></script>
    <script src="{{ asset('js/notif.js') }}"></script>
@endsection