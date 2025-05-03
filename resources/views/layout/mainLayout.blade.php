<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Client Management System">
    <title>@yield('title') - PDH Admin</title>
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Custom CSS -->
    @yield('head')
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    
    
    <!-- Preload critical fonts -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    
</head>
<body>
    <!-- Skip to content link for accessibility -->
    <a href="#main-content" class="skip-link">Skip to content</a>
    
    <!-- HEADER -->
    @section('header')
        <header>
            <div class="logo" aria-label="Website Logo">
                <img src="{{ asset('images/pdh_logo-removebg-preview.png') }}" alt="PDH Logo" class="logo-img">
                <span>PDH_ADMIN</span>
            </div>
            <nav aria-label="Main Navigation">
                <button class="mobile-menu-toggle" aria-expanded="false" aria-controls="main-menu" aria-label="Toggle menu">
                    <i class="fas fa-bars" aria-hidden="true"></i>
                </button>
                <ul id="main-menu">
                    <li>
                        <a href="/" class="{{ Request::is('/') ? 'active' : '' }}" aria-current="{{ Request::is('/') ? 'page' : 'false' }}">
                            <i class="fas fa-home" aria-hidden="true"></i> 
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin" class="{{ Request::is('admin*') ? 'active' : '' }}" aria-current="{{ Request::is('admin*') ? 'page' : 'false' }}">
                            <i class="fas fa-users-cog" aria-hidden="true"></i> 
                            <span>Employee Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="/certificates" class="{{ Request::is('certificates*') ? 'active' : '' }}" aria-current="{{ Request::is('certificates*') ? 'page' : 'false' }}">
                            <i class="fas fa-certificate" aria-hidden="true"></i> 
                            <span>Certificates</span>
                        </a>
                    </li>
                    <li>
                        <a href="/recruitment" class="{{ Request::is('recruitment*') ? 'active' : '' }}" aria-current="{{ Request::is('recruitment*') ? 'page' : 'false' }}">
                            <i class="fas fa-user-plus" aria-hidden="true"></i> 
                            <span>Recruitment</span>
                        </a>
                    </li>
                    <li>
                        <a href="/pages/aboutus" class="{{ Request::is('pages/aboutus') ? 'active' : '' }}" aria-current="{{ Request::is('pages/aboutus') ? 'page' : 'false' }}">
                            <i class="fas fa-info-circle" aria-hidden="true"></i> 
                            <span>About Us</span>
                        </a>
                    </li>
                    <li>
                        <a href="/pages/contactus" class="{{ Request::is('pages/contactus') ? 'active' : '' }}" aria-current="{{ Request::is('pages/contactus') ? 'page' : 'false' }}">
                            <i class="fas fa-envelope" aria-hidden="true"></i> 
                            <span>Contact Us</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </header>
    @show

    <!-- MAIN CONTENT -->
    <main id="main-content" class="container"> 
        <div class="page-header">
            <h1>@yield('page-title', 'Welcome')</h1>
            @yield('page-actions')
        </div>
        
        @yield('content')
    </main>

    <!-- FOOTER -->
    @section('footer')
        <footer>
            <div class="footer-content">
                <p>Copyright &copy; <span id="current-year">2023</span> PDH. All Rights Reserved.</p>
                <div class="footer-links">
                    <a href="/privacy">Privacy Policy</a>
                    <a href="/terms">Terms of Service</a>
                </div>
            </div>
        </footer>
    @show

    <!-- Custom Javascript - Placed at the end for better performance -->
    <script src="{{ asset('js/navigation.js') }}"></script>
    <script src="{{ asset('js/notif.js') }}"></script>
    @yield('scripts')
</body>
</html>