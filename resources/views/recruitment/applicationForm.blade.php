@extends('layout.app')

@section('title', 'Apply for ' . $jobPosting->position->position_name)

@section('head')
<link rel="stylesheet" href="{{ asset('css/recruit/recruitPage.css') }}">
@endsection

@section('page-title', 'Apply for ' . $jobPosting->position->position_name)

@section('page-actions')
<a href="{{ route('recruitment.job.details', $jobPosting->id) }}" class="btn-secondary">
    <i class="fas fa-arrow-left" aria-hidden="true"></i> Back to Job Details
</a>
@endsection

@section('content')
<div class="application-form-container">
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="job-summary">
        <h3>You are applying for:</h3>
        <div class="job-summary-details">
            <div class="job-summary-title">{{ $jobPosting->position->position_name }}</div>
            <div class="job-summary-meta">
                <span>{{ $jobPosting->department->department_name }}</span>
                <span>{{ $jobPosting->location }}</span>
                <span>{{ $jobPosting->employment_type }}</span>
            </div>
        </div>
    </div>

    <form id="application-form" action="{{ route('recruitment.application.submit', $jobPosting->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-section">
            <h3>Personal Information</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name <span class="required">*</span></label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                    @error('first_name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="last_name">Last Name <span class="required">*</span></label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                    @error('last_name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number <span class="required">*</span></label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required>
                    @error('phone')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="form-section">
            <h3>Address</h3>
            
            <div class="form-group">
                <label for="address">Street Address <span class="required">*</span></label>
                <input type="text" id="address" name="address" value="{{ old('address') }}" required>
                @error('address')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="city">City <span class="required">*</span></label>
                    <input type="text" id="city" name="city" value="{{ old('city') }}" required>
                    @error('city')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="state">State/Province <span class="required">*</span></label>
                    <input type="text" id="state" name="state" value="{{ old('state') }}" required>
                    @error('state')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="zip_code">Zip/Postal Code <span class="required">*</span></label>
                    <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" required>
                    @error('zip_code')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="country">Country <span class="required">*</span></label>
                    <input type="text" id="country" name="country" value="{{ old('country') }}" required>
                    @error('country')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="form-section">
            <h3>Professional Information</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="years_of_experience">Years of Experience <span class="required">*</span></label>
                    <input type="number" id="years_of_experience" name="years_of_experience" min="0" value="{{ old('years_of_experience') }}" required>
                    @error('years_of_experience')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="current_employer">Current Employer</label>
                    <input type="text" id="current_employer" name="current_employer" value="{{ old('current_employer') }}">
                    @error('current_employer')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="current_position">Current Position</label>
                <input type="text" id="current_position" name="current_position" value="{{ old('current_position') }}">
                @error('current_position')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="education">Education <span class="required">*</span></label>
                <textarea id="education" name="education" rows="4" required>{{ old('education') }}</textarea>
                <div class="help-text">List your educational background, including degrees, institutions, and graduation years.</div>
                @error('education')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="skills">Skills <span class="required">*</span></label>
                <textarea id="skills" name="skills" rows="4" required>{{ old('skills') }}</textarea>
                <div class="help-text">List relevant skills for this position.</div>
                @error('skills')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="certifications">Certifications & Licenses</label>
                <textarea id="certifications" name="certifications" rows="4">{{ old('certifications') }}</textarea>
                <div class="help-text">List any relevant certifications or licenses you hold.</div>
                @error('certifications')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="form-section">
            <h3>Application Details</h3>
            
            <div class="form-group">
                <label for="cover_letter">Cover Letter</label>
                <textarea id="cover_letter" name="cover_letter" rows="6">{{ old('cover_letter') }}</textarea>
                <div class="help-text">Explain why you're interested in this position and why you would be a good fit.</div>
                @error('cover_letter')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="resume">Resume <span class="required">*</span></label>
                <div class="file-upload">
                    <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" required>
                    <div class="file-upload-info">
                        <i class="fas fa-upload" aria-hidden="true"></i>
                        <span id="resume-file-name">No file selected</span>
                    </div>
                </div>
                <div class="help-text">Upload your resume (PDF, DOC, or DOCX format, max 2MB)</div>
                @error('resume')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="additional_documents">Additional Documents</label>
                <div class="file-upload">
                    <input type="file" id="additional_documents" name="additional_documents[]" accept=".pdf,.doc,.docx" multiple>
                    <div class="file-upload-info">
                        <i class="fas fa-upload" aria-hidden="true"></i>
                        <span id="additional-documents-count">No files selected</span>
                    </div>
                </div>
                <div class="help-text">Upload additional documents (PDF, DOC, or DOCX format, max 2MB each)</div>
                @error('additional_documents.*')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="form-section">
            <div class="form-group consent-group">
                <div class="checkbox-container">
                    <input type="checkbox" id="consent" name="consent" required>
                    <label for="consent">I consent to the processing of my personal data in accordance with the Privacy Policy <span class="required">*</span></label>
                </div>
                @error('consent')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-primary">Submit Application</button>
            <a href="{{ route('recruitment.job.details', $jobPosting->id) }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/recruit/recruitPage.js') }}"></script>
@endsection