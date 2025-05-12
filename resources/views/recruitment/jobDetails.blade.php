@extends('layout.app')

@section('title', $jobPosting->position->position_name . ' - Job Details')

@section('head')
<link rel="stylesheet" href="{{ asset('css/recruit/recruitPage.css') }}">
<meta name="description" content="{{ Str::limit(strip_tags($jobPosting->description), 160) }}">
@endsection

@section('page-title', $jobPosting->position->position_name)

@section('page-actions')
<a href="{{ route('recruitment.job.listings') }}" class="btn-secondary">
    <i class="fas fa-arrow-left" aria-hidden="true"></i> Back to Listings
</a>
@endsection

@section('content')
<div class="job-details-container">
    <div class="job-header">
        <div class="job-title-section">
            <h2>{{ $jobPosting->position->position_name }}</h2>
            <div class="job-meta">
                <span class="job-department">
                    <i class="fas fa-building" aria-hidden="true"></i> 
                    {{ $jobPosting->department->department_name }}
                </span>
                <span class="job-location">
                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i> 
                    {{ $jobPosting->location }}
                </span>
                <span class="job-type">
                    <i class="fas fa-clock" aria-hidden="true"></i> 
                    {{ $jobPosting->employment_type }}
                </span>
            </div>
        </div>
        <div class="job-actions">
            <a href="{{ route('recruitment.application.form', $jobPosting->id) }}" class="btn-primary">Apply Now</a>
        </div>
    </div>

    <div class="job-content">
        <div class="job-section">
            <h3>Job Description</h3>
            <div class="job-description">
                {!! nl2br(e($jobPosting->description)) !!}
            </div>
        </div>

        <div class="job-section">
            <h3>Requirements</h3>
            <div class="job-requirements">
                {!! nl2br(e($jobPosting->requirements)) !!}
            </div>
        </div>

        @if($jobPosting->benefits)
        <div class="job-section">
            <h3>Benefits</h3>
            <div class="job-benefits">
                {!! nl2br(e($jobPosting->benefits)) !!}
            </div>
        </div>
        @endif

        @if($jobPosting->salary_range)
        <div class="job-section">
            <h3>Salary Range</h3>
            <div class="job-salary">
                <p>{{ $jobPosting->salary_range }}</p>
            </div>
        </div>
        @endif

        <div class="job-section">
            <h3>Application Deadline</h3>
            <div class="job-deadline">
                <p>{{ \Carbon\Carbon::parse($jobPosting->application_deadline)->format('F d, Y') }}</p>
                <div class="deadline-countdown" data-deadline="{{ $jobPosting->application_deadline }}">
                    <span class="days-left"></span> days left to apply
                </div>
            </div>
        </div>
    </div>

    <div class="job-footer">
        <a href="{{ route('recruitment.application.form', $jobPosting->id) }}" class="btn-primary">Apply for this Position</a>
        <a href="{{ route('recruitment.job.listings') }}" class="btn-secondary">View All Openings</a>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/recruit/recruitPage.js') }}"></script>
@endsection