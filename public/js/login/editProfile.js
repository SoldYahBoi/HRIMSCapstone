document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked button and corresponding content
            this.classList.add('active');
            document.getElementById(tabId).classList.add('active');
            
            // Save active tab to session storage
            sessionStorage.setItem('activeProfileTab', tabId);
        });
    });
    
    // Restore active tab from session storage
    const activeTab = sessionStorage.getItem('activeProfileTab');
    if (activeTab) {
        const activeTabButton = document.querySelector(`.tab-btn[data-tab="${activeTab}"]`);
        if (activeTabButton) {
            activeTabButton.click();
        }
    }
    
    // Form validation enhancement
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input');
        
        inputs.forEach(input => {
            // Add focus and blur event listeners for visual feedback
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    });
    
    // Confirmation dialogs for sensitive actions
    const deleteForm = document.querySelector('#delete-user-form');
    
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            const confirmed = confirm('Are you sure you want to delete your account? This action cannot be undone.');
            
            if (!confirmed) {
                e.preventDefault();
            }
        });
    }
    
    // Success message handling
    const successMessage = document.querySelector('.success-message');
    
    if (successMessage) {
        // Auto-hide success message after 5 seconds
        setTimeout(() => {
            successMessage.style.opacity = '0';
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 500);
        }, 5000);
    }
});