@extends('layout.app')

@section('title', 'Careers')

@section('head')
<link rel="stylesheet" href="{{ asset('css/recruit/recruitPage.css') }}">
@endsection

@section('page-title', 'Join Our Healthcare Team')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-content">
        <h2 class="hero-title">Make a Difference in Healthcare</h2>
        <p class="hero-subtitle">Join our team of dedicated professionals committed to providing exceptional patient care</p>
        <div class="hero-cta">
            <a href="{{ route('recruitment.job.listings') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-search" aria-hidden="true"></i> Browse Open Positions
            </a>
        </div>
    </div>
    <div class="hero-image">
        <img src="{{ asset('images/healthcare-team.jpg') }}" alt="Healthcare professionals working together" onerror="this.src='https://via.placeholder.com/600x400?text=Healthcare+Team'">
    </div>
</div>

<!-- Why Join Us Section -->
<div class="section why-join-section">
    <h2 class="section-title">Why Join Our Team?</h2>
    
    <div class="benefits-grid">
        <div class="benefit-card">
            <div class="benefit-icon">
                <i class="fas fa-heart-pulse" aria-hidden="true"></i>
            </div>
            <h3 class="benefit-title">Meaningful Work</h3>
            <p class="benefit-description">Make a real difference in people's lives every day through compassionate care</p>
        </div>
        
        <div class="benefit-card">
            <div class="benefit-icon">
                <i class="fas fa-graduation-cap" aria-hidden="true"></i>
            </div>
            <h3 class="benefit-title">Growth & Development</h3>
            <p class="benefit-description">Continuous learning opportunities and clear career advancement paths</p>
        </div>
        
        <div class="benefit-card">
            <div class="benefit-icon">
                <i class="fas fa-users" aria-hidden="true"></i>
            </div>
            <h3 class="benefit-title">Collaborative Environment</h3>
            <p class="benefit-description">Work alongside talented professionals in a supportive team atmosphere</p>
        </div>
        
        <div class="benefit-card">
            <div class="benefit-icon">
                <i class="fas fa-shield-heart" aria-hidden="true"></i>
            </div>
            <h3 class="benefit-title">Comprehensive Benefits</h3>
            <p class="benefit-description">Competitive salary, health insurance, retirement plans, and work-life balance</p>
        </div>
    </div>
</div>

<!-- Featured Departments Section -->
<div class="section departments-section">
    <h2 class="section-title">Explore Our Departments</h2>
    
    <div class="departments-grid">
        @foreach(\App\Models\Department::take(6)->get() as $department)
        <div class="department-card">
            <div class="department-icon">
                @switch(strtolower($department->department_name))
                    @case('hr')
                        <i class="fas fa-users-gear" aria-hidden="true"></i>
                        @break
                    @case('nursing')
                        <i class="fas fa-user-nurse" aria-hidden="true"></i>
                        @break
                    @case('emergency')
                        <i class="fas fa-truck-medical" aria-hidden="true"></i>
                        @break
                    @case('pharmacy')
                        <i class="fas fa-pills" aria-hidden="true"></i>
                        @break
                    @case('radiology')
                        <i class="fas fa-x-ray" aria-hidden="true"></i>
                        @break
                    @case('icu')
                        <i class="fas fa-heart-pulse" aria-hidden="true"></i>
                        @break
                    @default
                        <i class="fas fa-hospital" aria-hidden="true"></i>
                @endswitch
            </div>
            <h3 class="department-title">{{ $department->department_name }}</h3>
            <p class="department-jobs">{{ \App\Models\JobPosting::where('department_id', $department->id)->where('is_active', true)->count() }} open positions</p>
            <a href="{{ route('recruitment.job.listings') }}?department={{ $department->id }}" class="department-link">View Jobs</a>
        </div>
        @endforeach
    </div>
</div>

<!-- Featured Jobs Section -->
<div class="section featured-jobs-section">
    <h2 class="section-title">Featured Opportunities</h2>
    
    <div class="featured-jobs-grid">
        @foreach(\App\Models\JobPosting::with(['position', 'department'])->where('is_active', true)->orderBy('created_at', 'desc')->take(3)->get() as $job)
        <div class="featured-job-card">
            <div class="featured-job-header">
                <h3 class="featured-job-title">{{ $job->position->position_name }}</h3>
                <span class="department-badge dept-{{ strtolower($job->department->department_name) }}">
                    {{ $job->department->department_name }}
                </span>
            </div>
            <div class="featured-job-details">
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
            <div class="featured-job-description">
                {{ Str::limit(strip_tags($job->description), 150) }}
            </div>
            <div class="featured-job-footer">
                <a href="{{ route('recruitment.job.details', $job->id) }}" class="btn btn-outline">View Details</a>
            </div>
        </div>
        @endforeach
        
        @if(\App\Models\JobPosting::where('is_active', true)->count() === 0)
        <div class="no-jobs">
            <div class="no-jobs-icon">
                <i class="fas fa-briefcase" aria-hidden="true"></i>
            </div>
            <h3>No job openings available at this time</h3>
            <p>Please check back later for new opportunities.</p>
        </div>
        @endif
    </div>
    
    <div class="view-all-jobs">
        <a href="{{ route('recruitment.job.listings') }}" class="btn btn-primary">View All Open Positions</a>
    </div>
</div>

<!-- Testimonials Section -->
<div class="section testimonials-section">
    <h2 class="section-title">What Our Team Says</h2>
    
    <div class="testimonials-slider">
        <div class="testimonial">
            <div class="testimonial-content">
                <p>"Working here has been incredibly rewarding. I've grown professionally and personally while making a real difference in patients' lives."</p>
            </div>
            <div class="testimonial-author">
                <div class="testimonial-avatar">
                    <div class="avatar-placeholder">JD</div>
                </div>
                <div class="testimonial-info">
                    <h4 class="testimonial-name">Jane Doe</h4>
                    <p class="testimonial-position">Nursing Department</p>
                </div>
            </div>
        </div>
        
        <div class="testimonial">
            <div class="testimonial-content">
                <p>"The collaborative environment and opportunities for advancement make this an exceptional place to build a healthcare career."</p>
            </div>
            <div class="testimonial-author">
                <div class="testimonial-avatar">
                    <div class="avatar-placeholder">JS</div>
                </div>
                <div class="testimonial-info">
                    <h4 class="testimonial-name">John Smith</h4>
                    <p class="testimonial-position">Radiology Department</p>
                </div>
            </div>
        </div>
        
        <div class="testimonial">
            <div class="testimonial-content">
                <p>"I appreciate the emphasis on work-life balance and professional development. It's a supportive environment where excellence is encouraged."</p>
            </div>
            <div class="testimonial-author">
                <div class="testimonial-avatar">
                    <div class="avatar-placeholder">MJ</div>
                </div>
                <div class="testimonial-info">
                    <h4 class="testimonial-name">Maria Johnson</h4>
                    <p class="testimonial-position">Pharmacy Department</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="section cta-section">
    <div class="cta-content">
        <h2 class="cta-title">Ready to Join Our Team?</h2>
        <p class="cta-description">Discover opportunities to grow your career while making a meaningful impact in healthcare</p>
        <a href="{{ route('recruitment.job.listings') }}" class="btn btn-primary btn-lg">Browse Open Positions</a>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/recruitPage.js') }}"></script>
<script>
    // Simple testimonial slider
    document.addEventListener('DOMContentLoaded', function() {
        const testimonials = document.querySelectorAll('.testimonial');
        let currentIndex = 0;
        
        if (testimonials.length > 1) {
            // Hide all testimonials except the first one
            testimonials.forEach((testimonial, index) => {
                if (index !== 0) {
                    testimonial.style.display = 'none';
                }
            });
            
            // Change testimonial every 5 seconds
            setInterval(() => {
                testimonials[currentIndex].style.display = 'none';
                currentIndex = (currentIndex + 1) % testimonials.length;
                testimonials[currentIndex].style.display = 'block';
                testimonials[currentIndex].classList.add('fade-in');
            }, 5000);
        }
    });
</script>
@endsection