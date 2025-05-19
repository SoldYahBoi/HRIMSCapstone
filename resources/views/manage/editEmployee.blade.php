@extends('layout.mainLayout')

@section('title')
    Edit Employee
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('page-title')
    Edit Employee
@endsection

@section('page-actions')
    <a href="/employees" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Back to Employees
    </a>
@endsection

@section('content')
    <div class="form-container">
        <form action="/admin/{{ $employee->id }}" method="POST" id="editEmployeeForm">
            @csrf
            @method('PUT')
            
            <!-- Progress Indicator -->
            <div class="form-progress">
                <div class="progress-step active" data-step="personal">
                    <div class="step-icon"><i class="fas fa-user-circle"></i></div>
                    <div class="step-label">Personal</div>
                </div>
                <div class="progress-connector"></div>
                <div class="progress-step" data-step="contact">
                    <div class="step-icon"><i class="fas fa-address-card"></i></div>
                    <div class="step-label">Contact</div>
                </div>
                <div class="progress-connector"></div>
                <div class="progress-step" data-step="employment">
                    <div class="step-icon"><i class="fas fa-briefcase"></i></div>
                    <div class="step-label">Employment</div>
                </div>
            </div>
            
            <!-- Personal Information Section -->
            <div class="form-section active" id="personal-section">
                <h2 class="form-section-title">
                    <i class="fas fa-user-circle mr-2"></i> Personal Information
                </h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name" class="form-label required">First Name</label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $employee->first_name) }}">
                        @error('first_name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" value="{{ old('middle_name', $employee->middle_name) }}">
                        @error('middle_name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name" class="form-label required">Last Name</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $employee->last_name) }}">
                        @error('last_name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="birthdate" class="form-label required">Date of Birth</label>
                        <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate" value="{{ old('birthdate', $employee->birthdate) }}">
                        @error('birthdate')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="gender" class="form-label required">Gender</label>
                        <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender', $employee->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $employee->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $employee->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="civil_status" class="form-label required">Civil Status</label>
                        <select class="form-control @error('civil_status') is-invalid @enderror" id="civil_status" name="civil_status">
                            <option value="">Select Civil Status</option>
                            <option value="Single" {{ old('civil_status', $employee->civil_status) == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('civil_status', $employee->civil_status) == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Widowed" {{ old('civil_status', $employee->civil_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            <option value="Divorced" {{ old('civil_status', $employee->civil_status) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                            <option value="Separated" {{ old('civil_status', $employee->civil_status) == 'Separated' ? 'selected' : '' }}>Separated</option>
                        </select>
                        @error('civil_status')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-navigation">
                    <div></div>
                    <button type="button" class="btn btn-primary next-section" data-next="contact">
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
            
            <!-- Contact Information Section -->
            <div class="form-section" id="contact-section">
                <h2 class="form-section-title">
                    <i class="fas fa-address-card mr-2"></i> Contact Information
                </h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="contact_number" class="form-label required">Contact Number</label>
                        <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="contact_number" name="contact_number" value="{{ old('contact_number', $employee->contact_number) }}">
                        @error('contact_number')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label required">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $employee->email) }}">
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="address" class="form-label required">Residential Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $employee->address) }}</textarea>
                    @error('address')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-navigation">
                    <button type="button" class="btn btn-outline prev-section" data-prev="personal">
                        <i class="fas fa-arrow-left"></i> Previous
                    </button>
                    <button type="button" class="btn btn-primary next-section" data-next="employment">
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
            
            <!-- Employment Information Section -->
            <div class="form-section" id="employment-section">
                <h2 class="form-section-title">
                    <i class="fas fa-briefcase mr-2"></i> Employment Information
                </h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="department_id" class="form-label required">Department</label>
                        <div class="select-wrapper">
                            <select class="form-control @error('department_id') is-invalid @enderror" id="department_id" name="department_id">
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id) == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->department_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="select-icon">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        @error('department_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="position_id" class="form-label required">Position</label>
                        <div class="select-wrapper">
                            <select class="form-control @error('position_id') is-invalid @enderror" id="position_id" name="position_id">
                                <option value="">Select Position</option>
                                @foreach($positions as $pos)
                                    <option value="{{ $pos->id }}" {{ old('position_id', $employee->position_id) == $pos->id ? 'selected' : '' }}>
                                        {{ $pos->position_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="select-icon">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        @error('position_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="hire_date" class="form-label required">Hire Date</label>
                        <input type="date" class="form-control @error('hire_date') is-invalid @enderror" id="hire_date" name="hire_date" value="{{ old('hire_date', $employee->hire_date) ?? date('Y-m-d') }}">
                        @error('hire_date')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="status" class="form-label required">Employment Status</label>
                        <div class="select-wrapper">
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="">Select Status</option>
                                <option value="Active" {{ old('status', $employee->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Resigned" {{ old('status', $employee->status) == 'Resigned' ? 'selected' : '' }}>Resigned</option>
                                <option value="Terminated" {{ old('status', $employee->status) == 'Terminated' ? 'selected' : '' }}>Terminated</option>
                            </select>
                            <div class="select-icon">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        @error('status')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="employment_type_id" class="form-label required">Employment Type</label>
                        <div class="select-wrapper">
                            <select class="form-control @error('employment_type_id') is-invalid @enderror" id="employment_type_id" name="employment_type_id">
                                <option value="">Select Type</option>
                                @foreach($employments as $emp)
                                    <option value="{{ $emp->id }}" {{ old('employment_type_id', $employee->employment_type_id) == $emp->id ? 'selected' : '' }}>
                                        {{ $emp->type_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="select-icon">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        @error('employment_type_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-navigation">
                    <button type="button" class="btn btn-outline prev-section" data-prev="contact">
                        <i class="fas fa-arrow-left"></i> Previous
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Employee
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/edit.js') }}"></script>
@endsection
