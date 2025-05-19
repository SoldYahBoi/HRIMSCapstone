document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility with improved UX
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle icon with animation
            const icon = this.querySelector('i');
            icon.style.transform = 'scale(0)';
            
            setTimeout(() => {
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
                icon.style.transform = 'scale(1)';
            }, 150);
            
            // Add focus back to password field for better UX
            passwordInput.focus();
        });
    }

    // Enhanced input field interactions
    const allInputs = document.querySelectorAll('.form-control');
    
    allInputs.forEach(input => {
        // Add floating effect when input has value
        const checkInputValue = () => {
            if (input.value) {
                input.classList.add('has-value');
                
                // Also update the icon color
                const icon = input.parentElement.querySelector('i:not(.fa-eye):not(.fa-eye-slash)');
                if (icon) {
                    icon.style.color = 'var(--primary)';
                }
            } else {
                input.classList.remove('has-value');
                
                // Reset icon color if not focused
                if (!input.matches(':focus')) {
                    const icon = input.parentElement.querySelector('i:not(.fa-eye):not(.fa-eye-slash)');
                    if (icon) {
                        icon.style.color = 'var(--gray-400)';
                    }
                }
            }
        };
        
        // Check initial value
        checkInputValue();
        
        // Check on input
        input.addEventListener('input', checkInputValue);
        
        // Focus and blur effects for inputs with icons
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('input-focused');
            const icon = this.parentElement.querySelector('i:not(.fa-eye):not(.fa-eye-slash)');
            if (icon) {
                icon.style.color = 'var(--primary)';
                icon.style.transform = 'scale(1.1)';
            }
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('input-focused');
            const icon = this.parentElement.querySelector('i:not(.fa-eye):not(.fa-eye-slash)');
            if (icon && !this.value) {
                icon.style.color = 'var(--gray-400)';
                icon.style.transform = 'scale(1)';
            }
        });
    });

    // Enhanced form validation with visual feedback
    const loginForm = document.querySelector('.login-form');

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            let isValid = true;
            
            // Clear previous error states
            const errorMessages = document.querySelectorAll('.error-message');
            errorMessages.forEach(msg => {
                if (!msg.classList.contains('server-error')) {
                    msg.remove();
                }
            });
            
            // Email validation with better feedback
            if (emailInput) {
                if (emailInput.value.trim() === '') {
                    isValid = false;
                    showError(emailInput, 'Please enter your email address');
                } else if (!isValidEmail(emailInput.value)) {
                    isValid = false;
                    showError(emailInput, 'Please enter a valid email address');
                } else {
                    emailInput.classList.remove('is-invalid');
                }
            }
            
            // Password validation with better feedback
            if (passwordInput) {
                if (passwordInput.value.trim() === '') {
                    isValid = false;
                    showError(passwordInput, 'Please enter your password');
                } else {
                    passwordInput.classList.remove('is-invalid');
                }
            }
            
            // Prevent form submission if invalid
            if (!isValid) {
                e.preventDefault();
                
                // Add shake animation to the form for visual feedback
                loginForm.classList.add('shake');
                setTimeout(() => {
                    loginForm.classList.remove('shake');
                }, 600);
            } else {
                // Add loading state to button when form is valid
                const submitBtn = loginForm.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Logging in...';
                    submitBtn.disabled = true;
                }
            }
        });
    }

    // Helper function to show error messages
    function showError(inputElement, message) {
        inputElement.classList.add('is-invalid');
        
        // Create error message if it doesn't exist
        const parent = inputElement.closest('.form-group');
        if (parent && !parent.querySelector('.error-message:not(.server-error)')) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.textContent = message;
            parent.appendChild(errorDiv);
        }
        
        // Focus the first invalid input
        if (document.querySelector('.is-invalid') === inputElement) {
            setTimeout(() => {
                inputElement.focus();
            }, 100);
        }
    }

    // Helper function to validate email format
    function isValidEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    // Enhanced animation when the page loads
    const loginCard = document.querySelector('.login-card');
    if (loginCard) {
        loginCard.style.opacity = '0';
        loginCard.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            loginCard.style.opacity = '1';
            loginCard.style.transform = 'translateY(0)';
            loginCard.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        }, 100);
    }
    
    // Add subtle animation to the hospital name
    const hospitalName = document.querySelector('.login-header .logo span:first-of-type');
    if (hospitalName) {
        hospitalName.style.opacity = '0';
        hospitalName.style.transform = 'translateY(-10px)';
        
        setTimeout(() => {
            hospitalName.style.opacity = '1';
            hospitalName.style.transform = 'translateY(0)';
            hospitalName.style.transition = 'opacity 0.4s ease 0.2s, transform 0.4s ease 0.2s';
        }, 300);
    }
    
    // Add subtle animation to the HRIMS text
    const hrimsText = document.querySelector('.login-header .logo span:last-of-type');
    if (hrimsText) {
        hrimsText.style.opacity = '0';
        hrimsText.style.transform = 'translateY(-5px)';
        
        setTimeout(() => {
            hrimsText.style.opacity = '1';
            hrimsText.style.transform = 'translateY(0)';
            hrimsText.style.transition = 'opacity 0.4s ease 0.4s, transform 0.4s ease 0.4s';
        }, 500);
    }
    
    // Add subtle background animation
    const loginContainer = document.querySelector('.login-container');
    if (loginContainer) {
        loginContainer.style.backgroundPosition = '0% 0%';
        
        setTimeout(() => {
            loginContainer.style.transition = 'background-position 30s ease';
            loginContainer.style.backgroundPosition = '100% 100%';
            
            // Loop the animation
            setInterval(() => {
                loginContainer.style.transition = 'none';
                loginContainer.style.backgroundPosition = '0% 0%';
                
                setTimeout(() => {
                    loginContainer.style.transition = 'background-position 30s ease';
                    loginContainer.style.backgroundPosition = '100% 100%';
                }, 50);
            }, 30000);
        }, 500);
    }
    
    // Add accessibility improvements
    const form = document.querySelector('form');
    if (form) {
        // Add aria-live region for screen readers to announce form errors
        const ariaLive = document.createElement('div');
        ariaLive.setAttribute('aria-live', 'polite');
        ariaLive.className = 'sr-only';
        ariaLive.id = 'form-announcements';
        form.appendChild(ariaLive);
        
        // Announce form errors to screen readers
        form.addEventListener('submit', function() {
            const errors = form.querySelectorAll('.error-message');
            if (errors.length > 0) {
                const errorMessages = Array.from(errors).map(e => e.textContent).join('. ');
                document.getElementById('form-announcements').textContent = 'Form has errors: ' + errorMessages;
            }
        });
    }
});