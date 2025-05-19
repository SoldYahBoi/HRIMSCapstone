<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Hospital Careers - Join Our Healthcare Team">
    <title>@yield('title') - Hospital Careers</title>
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/recruit/app.css') }}">
    
    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    @yield('head')
</head>
<body>
    <!-- Skip to content link for accessibility -->
    <a href="#main-content" class="skip-link">Skip to content</a>
    
    <!-- HEADER -->
    <header>
        <div class="logo">
            <i class="fas fa-hospital" aria-hidden="true"></i>
            <span>PANGASINAN DOCTORS HOSPITAL</span>
        </div>
        
        <nav aria-label="Main Navigation">
            <button class="mobile-menu-toggle" aria-expanded="false" aria-controls="main-menu" aria-label="Toggle menu">
                <i class="fas fa-bars" aria-hidden="true"></i>
            </button>
            
            <ul id="main-menu">
                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" aria-current="{{ request()->routeIs('home') ? 'page' : 'false' }}">
                        <i class="fas fa-home" aria-hidden="true"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('recruitment.job.listings') }}" class="{{ request()->routeIs('recruitment.job.listings') ? 'active' : '' }}" aria-current="{{ request()->routeIs('recruitment.job.listings') ? 'page' : 'false' }}">
                        <i class="fas fa-briefcase" aria-hidden="true"></i>
                        <span>Browse Jobs</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('recruitment.trackApplication') }}" class="{{ request()->routeIs('recruitment.trackApplication') ? 'active' : '' }}" aria-current="{{ request()->routeIs('recruitment.trackApplication') ? 'page' : 'false' }}">
                        <i class="fas fa-clipboard-check" aria-hidden="true"></i>
                        <span>Application Status</span>
                    </a>
                </li>
                <li>
                    <a href="" class="" aria-current="">
                        <i class="fas fa-hospital-user" aria-hidden="true"></i>
                        <span>About Us</span>
                    </a>
                </li>
                <li>
                    <a href="" class="" aria-current="">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                        <span>Contact</span>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    
    <!-- MAIN CONTENT -->
    <main id="main-content" class="container">
        @if(!request()->routeIs('home'))
        <div class="page-header">
            <h1>@yield('page-title', 'Welcome')</h1>
            <div class="page-actions">
                @yield('page-actions')
            </div>
        </div>
        @endif
        
        @if(session('success'))
        <div class="alert alert-success fade-in">
            <i class="fas fa-check-circle" aria-hidden="true"></i>
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger fade-in">
            <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
            {{ session('error') }}
        </div>
        @endif
        
        @yield('content')
    </main>
    
    <!-- FOOTER -->
    <footer>
        <div class="footer-content">
            <div class="footer-sections">
                <div class="footer-section">
                    <h3>Hospital Careers</h3>
                    <p>Join our team of dedicated healthcare professionals committed to providing exceptional patient care.</p>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('recruitment.job.listings') }}">Browse Jobs</a></li>
                        <li><a href="{{ route('recruitment.trackApplication') }}">Application Status</a></li>
                        <li><a href="">About Us</a></li>
                        <li><a href="">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <address>
                        <p><i class="fas fa-map-marker-alt" aria-hidden="true"></i> 123 Hospital Street, Medical City</p>
                        <p><i class="fas fa-phone" aria-hidden="true"></i> (123) 456-7890</p>
                        <p><i class="fas fa-envelope" aria-hidden="true"></i> careers@hospital.org</p>
                    </address>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>Copyright &copy; <span id="current-year">2023</span> Hospital Careers. All Rights Reserved.</p>
                <div class="footer-links">
                    <a href="/privacy">Privacy Policy</a>
                    <a href="/terms">Terms of Service</a>
                    <a href="/accessibility">Accessibility</a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Core JavaScript -->
    <script src="{{ asset('js/recruit/app.js') }}"></script>
    
    @yield('scripts')
</body>
</html>