@extends('layout.mainLayout')

@section('title')
    Add New Employee
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/add.css') }}">
@endsection

@section('page-title')
    Add New Employee
@endsection

@section('content')
    @if(session('success'))
        <div class="success-popup">
            {{ session('success') }}
        </div>
    @endif
    <div class="form-container">
        <form action="/admin" method="POST">
            @csrf
            
            <!-- Personal Information Section -->
            <div class="form-section">
                <h2 class="form-section-title">
                    <i class="fas fa-user-circle mr-2"></i> Personal Information
                </h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name" class="form-label required">First Name</label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}" >
                        @error('first_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" value="{{ old('middle_name') }}">
                        @error('middle_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name" class="form-label required">Last Name</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}">
                        @error('last_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="birthdate" class="form-label required">Date of Birth</label>
                        <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" >
                        @error('birthdate')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="gender" class="form-label required">Gender</label>
                        <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender" >
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="civil_status" class="form-label required">Civil Status</label>
                        <select class="form-control @error('civil_status') is-invalid @enderror" id="civil_status" name="civil_status" >
                            <option value="">Select Civil Status</option>
                            <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Widowed" {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            <option value="Divorced" {{ old('civil_status') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                            <option value="Separated" {{ old('civil_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                        </select>
                        @error('civil_status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Contact Information Section -->
            <div class="form-section">
                <h2 class="form-section-title">
                    <i class="fas fa-address-card mr-2"></i> Contact Information
                </h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="contact_number" class="form-label required">Contact Number</label>
                        <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" >
                        @error('contact_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label required">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" >
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="address" class="form-label required">Residential Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" >{{ old('address') }}</textarea>
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Employment Information Section -->
            <div class="form-section">
                <h2 class="form-section-title">
                    <i class="fas fa-briefcase mr-2"></i> Employment Information
                </h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="department_id" class="form-label required">Department</label>
                        <div class="select-wrapper">
                            <select class="form-control @error('department_id') is-invalid @enderror" id="department_id" name="department_id" >
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->department_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="select-loader" id="department-loader">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </div>
                        @error('department_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="position_id" class="form-label required">Position</label>
                        <div class="select-wrapper">
                            <select class="form-control @error('position_id') is-invalid @enderror" id="position_id" name="position_id" >
                                <option value="">Select Position</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                        {{ $position->position_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="select-loader" id="position-loader">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </div>
                        @error('position_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="hire_date" class="form-label required">Hire Date</label>
                        <input type="date" class="form-control @error('hire_date') is-invalid @enderror" id="hire_date" name="hire_date" value="{{ old('hire_date') ?? date('Y-m-d') }}" >
                        @error('hire_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row-inline">
                    <div class="form-group">
                        <label for="status" class="form-label required">Employment Status</label>
                        <div class="select-wrapper">
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" >
                                <option value="">Select Status</option>
                                <option value="Active" {{ old('status') == 'Active' ? 'selected' : 'selected' }}>Active</option>
                                <option value="Resigned" {{ old('status') == 'Resigned' ? 'selected' : '' }}>Resigned</option>
                                <option value="Terminated" {{ old('status') == 'Terminated' ? 'selected' : '' }}>Terminated</option>
                            </select>
                        </div>
                        <div class="select-loader" id="status-loader">
                                <i class="fas fa-spinner fa-spin"></i>
                        </div>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="employment_type_id" class="form-label required">Employment Type</label>
                        <div class="select-wrapper">
                            <select class="form-control @error('employment_type_id') is-invalid @enderror" id="employment_type_id" name="employment_type_id" >
                                <option value="">Select Type</option>
                                @foreach($employments as $employment)
                                    <option value="{{ $employment->id }}" {{ old('employment_type_id') == $employment->id ? 'selected' : '' }}>
                                        {{ $employment->type_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="select-loader" id="employment-type-loader">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </div>
                        @error('employment_type_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="form-actions">
                <a href="/admin" class="btn btn-outline">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Employee
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/add.js') }}"></script>
@endsection