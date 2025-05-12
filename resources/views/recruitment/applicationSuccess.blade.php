@extends('layout.app')

@section('title', 'Application Submitted')

@section('head')
<link rel="stylesheet" href="{{ asset('css/recruit/recruitPage.css') }}">
@endsection

@section('page-title', 'Application Submitted')

@section('content')
<div class="success-container">
    <div class="success-icon">
        <i class="fas fa-check-circle" aria-hidden="true"></i>
    </div>
    
    <h2>Thank You for Your Application!</h2>
    
    <div class="success-message">
        <p>Your application for <strong>{{ $application->jobPosting->position->position_name }}</strong> at the <strong>{{ $application->jobPosting->department->department_name }}</strong> department has been successfully submitted.</p>
        
        <div class="application-details">
            <div class="detail-item">
                <span class="detail-label">Application ID:</span>
                <span class="detail-value">{{ $application->id }}</span>
            </div>
            
            <div class="detail-item">
                <span class="detail-label">Submitted On:</span>
                <span class="detail-value">{{ $application->created_at->format('F d, Y \a\t h:i A') }}</span>
            </div>
            
            <div class="detail-item">
                <span class="detail-label">Applicant Name:</span>
                <span class="detail-value">{{ $application->applicant->full_name }}</span>
            </div>
            
            <div class="detail-item">
                <span class="detail-label">Email:</span>
                <span class="detail-value">{{ $application->applicant->email }}</span>
            </div>

            <div class="detail-item application-code">
                <span class="detail-label">Application Code:</span>
                <span class="detail-value code">{{ $application->application_code }}</span>
            </div>
        </div>

        <div class="important-notice">
            <div class="notice-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="notice-content">
                <h4>Important: Save Your Application Code</h4>
                <p>Please save your application code (shown above) in a secure place. You will need this code to track the status of your application through our application tracking system.</p>
            </div>
        </div>
        
        <div class="next-steps">
            <h3>What's Next?</h3>
            <ol>
                <li>Our HR team will review your application.</li>
                <li>If your qualifications match our requirements, we will contact you to schedule an interview.</li>
                <li>The entire process typically takes 1-2 weeks.</li>
            </ol>
        </div>
        
        <p>If you have any questions about your application or the hiring process, please contact our HR department at <a href="mailto:hr@example.com">hr@example.com</a>.</p>
    </div>
    
    <div class="success-actions">
        <a href="{{ route('recruitment.job.listings') }}" class="btn-primary">Browse More Job Openings</a>
        <a href="{{ url('/') }}" class="btn-secondary">Return to Homepage</a>
    </div>
</div>
@endsection