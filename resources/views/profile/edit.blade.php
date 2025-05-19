@extends('layout.mainLayout')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/login/editProfile.css') }}">
@endsection

@section('content')
    <div class="profile-container">
        <div class="profile-header">
            <h2>{{ __('Profile Settings') }}</h2>
            <p>Manage your account settings and preferences</p>
        </div>

        <div class="profile-tabs">
            <button class="tab-btn active" data-tab="profile-info">
                <i class="fas fa-user"></i> Personal Information
            </button>
            <button class="tab-btn" data-tab="security">
                <i class="fas fa-lock"></i> Security
            </button>
            <button class="tab-btn" data-tab="account">
                <i class="fas fa-user-slash"></i> Account
            </button>
        </div>

        <div class="profile-content">
            <div id="profile-info" class="tab-content active">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Profile Information') }}</h3>
                        <p>Update your account's profile information and email address.</p>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div id="security" class="tab-content">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Update Password') }}</h3>
                        <p>Ensure your account is using a long, random password to stay secure.</p>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div id="account" class="tab-content">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Delete Account') }}</h3>
                        <p>Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/login/editProfile.js') }}"></script>
@endsection