<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/login/login.css') }}">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">
                    <i class="fas fa-code" aria-hidden="true"></i>
                    <span>PANGASINAN DOCTOR'S HOSPITAL</span><br>
                    <span>HUMAN RESOURCE INFORMATION MANAGEMENT SYSTEM</span>
                </div>
                <h2>Welcome Back</h2>
                <p>Please sign in to your account</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                        <input id="email" class="form-control @error('email') is-invalid @enderror" 
                               type="email" name="email" value="{{ old('email') }}" 
                               required autofocus autocomplete="username" placeholder="Enter your email">
                    </div>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock" aria-hidden="true"></i>
                        <input id="password" class="form-control @error('password') is-invalid @enderror" 
                               type="password" name="password" required autocomplete="current-password"
                               placeholder="Enter your password">
                        <button type="button" id="togglePassword" class="toggle-password">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-group remember-forgot">
                    <div class="remember-me">
                        <input id="remember_me" type="checkbox" name="remember">
                        <label for="remember_me">{{ __('Remember me') }}</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary login-btn">
                    <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
                    {{ __('Log in') }}
                </button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/login/login.js') }}"></script>
</body>
</html>