@extends('layout.app')

@section('title', 'Track Application')

@section('head')
<link rel="stylesheet" href="{{ asset('css/recruit/track.css') }}">
@endsection

@section('page-title', 'Track Application')

@section('content')
<div class="track-container">
    <div class="track-form-section">
        <h2>Track Your Application</h2>
        <p class="track-description">Enter your application code to check the status of your application.</p>
        
        <form id="trackApplicationForm" class="track-form">
            <div class="form-group">
                <label for="application_code">Application Code</label>
                <input type="text" id="application_code" name="application_code" class="form-control" placeholder="Enter your application code" required>
                <div class="error-message" id="applicationCodeError"></div>
            </div>
            
            <button type="submit" class="btn-track">Track Application</button>
        </form>
    </div>

    <div id="applicationStatus" class="status-section" style="display: none;">
        <div class="status-header">
            <h3>Application Status</h3>
            <div class="status-badge" id="statusBadge"></div>
        </div>

        <div class="status-details">
            <div class="detail-row">
                <span class="detail-label">Application Code:</span>
                <span class="detail-value" id="statusApplicationCode"></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Position:</span>
                <span class="detail-value" id="statusPosition"></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Department:</span>
                <span class="detail-value" id="statusDepartment"></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Applied Date:</span>
                <span class="detail-value" id="statusAppliedDate"></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Last Updated:</span>
                <span class="detail-value" id="statusLastUpdated"></span>
            </div>
        </div>

        <div class="status-timeline">
            <h4>Application Timeline</h4>
            <div class="timeline" id="statusTimeline">
                <!-- Timeline items will be added dynamically -->
            </div>
        </div>
    </div>

    <div id="errorMessage" class="error-section" style="display: none;">
        <div class="error-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <div class="error-content">
            <h4>Application Not Found</h4>
            <p id="errorText"></p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/recruit/track.js') }}"></script>
@endsection