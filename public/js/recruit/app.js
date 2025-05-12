/**
 * Hospital Careers - Main JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // Set current year in footer
    const currentYearElement = document.getElementById('current-year');
    if (currentYearElement) {
        currentYearElement.textContent = new Date().getFullYear();
    }
    
    // Mobile menu toggle
    initMobileMenu();
    
    // Auto-hide alerts after 5 seconds
    initAlertDismissal();
    
    // Initialize testimonial slider if present
    initTestimonialSlider();
});

/**
 * Initialize mobile menu functionality
 */
function initMobileMenu() {
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const mainMenu = document.getElementById('main-menu');
    
    if (menuToggle && mainMenu) {
        menuToggle.addEventListener('click', function() {
            const expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !expanded);
            mainMenu.classList.toggle('active');
            
            // Change icon based on state
            const icon = this.querySelector('i');
            if (icon) {
                if (expanded) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                } else {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                }
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!menuToggle.contains(event.target) && !mainMenu.contains(event.target) && mainMenu.classList.contains('active')) {
                menuToggle.setAttribute('aria-expanded', 'false');
                mainMenu.classList.remove('active');
                
                const icon = menuToggle.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
        });
    }
}

/**
 * Initialize alert auto-dismissal
 */
function initAlertDismissal() {
    const alerts = document.querySelectorAll('.alert');
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 300);
            });
        }, 5000);
        
        // Add close button functionality
        alerts.forEach(alert => {
            // Create close button if it doesn't exist
            if (!alert.querySelector('.alert-close')) {
                const closeButton = document.createElement('button');
                closeButton.className = 'alert-close';
                closeButton.innerHTML = '&times;';
                closeButton.setAttribute('aria-label', 'Close alert');
                closeButton.style.marginLeft = 'auto';
                closeButton.style.background = 'none';
                closeButton.style.border = 'none';
                closeButton.style.fontSize = '1.25rem';
                closeButton.style.cursor = 'pointer';
                closeButton.style.opacity = '0.7';
                closeButton.style.transition = 'opacity 0.2s';
                
                closeButton.addEventListener('mouseover', () => {
                    closeButton.style.opacity = '1';
                });
                
                closeButton.addEventListener('mouseout', () => {
                    closeButton.style.opacity = '0.7';
                });
                
                closeButton.addEventListener('click', () => {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 300);
                });
                
                alert.appendChild(closeButton);
            }
        });
    }
}

/**
 * Initialize testimonial slider
 */
function initTestimonialSlider() {
    const testimonials = document.querySelectorAll('.testimonial');
    if (testimonials.length > 1) {
        let currentIndex = 0;
        
        // Hide all testimonials except the first one
        testimonials.forEach((testimonial, index) => {
            if (index !== 0) {
                testimonial.style.display = 'none';
            }
        });
        
        // Create navigation dots
        const sliderContainer = document.querySelector('.testimonials-slider');
        if (sliderContainer) {
            const dotsContainer = document.createElement('div');
            dotsContainer.className = 'slider-dots';
            dotsContainer.style.display = 'flex';
            dotsContainer.style.justifyContent = 'center';
            dotsContainer.style.gap = '0.5rem';
            dotsContainer.style.marginTop = '1rem';
            
            testimonials.forEach((_, index) => {
                const dot = document.createElement('button');
                dot.className = 'slider-dot';
                dot.setAttribute('aria-label', `Go to testimonial ${index + 1}`);
                dot.style.width = '10px';
                dot.style.height = '10px';
                dot.style.borderRadius = '50%';
                dot.style.backgroundColor = index === 0 ? 'var(--primary)' : 'var(--gray-300)';
                dot.style.border = 'none';
                dot.style.padding = '0';
                dot.style.cursor = 'pointer';
                dot.style.transition = 'background-color 0.3s ease';
                
                dot.addEventListener('click', () => {
                    showTestimonial(index);
                });
                
                dotsContainer.appendChild(dot);
            });
            
            sliderContainer.appendChild(dotsContainer);
        }
        
        // Auto-rotate testimonials
        setInterval(() => {
            const nextIndex = (currentIndex + 1) % testimonials.length;
            showTestimonial(nextIndex);
        }, 5000);
        
        // Function to show a specific testimonial
        function showTestimonial(index) {
            // Hide current testimonial
            testimonials[currentIndex].style.display = 'none';
            
            // Update dots
            const dots = document.querySelectorAll('.slider-dot');
            if (dots.length) {
                dots[currentIndex].style.backgroundColor = 'var(--gray-300)';
                dots[index].style.backgroundColor = 'var(--primary)';
            }
            
            // Show new testimonial
            currentIndex = index;
            testimonials[currentIndex].style.display = 'block';
            testimonials[currentIndex].classList.add('fade-in');
        }
    }
}

/**
 * Smooth scroll to element
 * @param {string} elementId - The ID of the element to scroll to
 */
function scrollToElement(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

/**
 * Toggle visibility of an element
 * @param {string} elementId - The ID of the element to toggle
 */
function toggleElement(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        if (element.style.display === 'none' || getComputedStyle(element).display === 'none') {
            element.style.display = 'block';
            element.classList.add('fade-in');
        } else {
            element.style.opacity = '0';
            setTimeout(() => {
                element.style.display = 'none';
                element.style.opacity = '1';
            }, 300);
        }
    }
}