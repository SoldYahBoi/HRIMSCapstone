@extends('layout.app')

@section('title', 'Job Listings')

@section('head')
<link rel="stylesheet" href="{{ asset('css/recruit/recruitPage.css') }}">
@endsection

@section('page-title', 'Current Job Openings')

@section('content')
<div class="job-listings-container">
    <div class="job-filters">
        <div class="filter-card">
            <h3>Filter By Department</h3>
            <div class="filter-options">
                <div class="filter-option">
                    <input type="radio" id="all-departments" name="department" value="all" checked>
                    <label for="all-departments">All Departments</label>
                </div>
                @foreach($departments as $department)
                <div class="filter-option">
                    <input type="radio" id="department-{{ $department->id }}" name="department" value="{{ $department->id }}">
                    <label for="department-{{ $department->id }}">{{ $department->department_name }}</label>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="job-listings">
        <div class="job-count">
            <p><span id="job-count-number">{{ $jobPostings->count() }}</span> positions available</p>
        </div>

        @if($jobPostings->isEmpty())
        <div class="no-jobs">
            <div class="no-jobs-icon">
                <i class="fas fa-briefcase" aria-hidden="true"></i>
            </div>
            <h3>No job openings available at this time</h3>
            <p>Please check back later for new opportunities.</p>
        </div>
        @else
        <div class="job-cards">
            @foreach($jobPostings as $job)
            <div class="job-card" data-department="{{ $job->department_id }}">
                <div class="job-card-header">
                    <h3>{{ $job->position->position_name }}</h3>
                    <span class="job-department">{{ $job->department->department_name }}</span>
                </div>
                <div class="job-card-body">
                    <div class="job-detail">
                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                        <span>{{ $job->location }}</span>
                    </div>
                    <div class="job-detail">
                        <i class="fas fa-clock" aria-hidden="true"></i>
                        <span>{{ $job->employment_type }}</span>
                    </div>
                    <div class="job-detail">
                        <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                        <span>Apply by: {{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}</span>
                    </div>
                </div>
                <div class="job-card-footer">
                    <a href="{{ route('recruitment.job.details', $job->id) }}" class="btn-view-job">View Details</a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/recruit/recruitPage.js') }}"></script>
@endsection