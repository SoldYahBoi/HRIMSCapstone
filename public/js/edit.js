document.addEventListener('DOMContentLoaded', function() {
    // Form sections navigation
    const formSections = document.querySelectorAll('.form-section');
    const progressSteps = document.querySelectorAll('.progress-step');
    const progressConnectors = document.querySelectorAll('.progress-connector');
    const nextButtons = document.querySelectorAll('.next-section');
    const prevButtons = document.querySelectorAll('.prev-section');
    
    // Success popup auto-hide
    const successPopup = document.getElementById('successPopup');
    if (successPopup) {
        setTimeout(() => {
            successPopup.classList.add('hide');
        }, 5000);
    }
    
    // Next button click handler
    nextButtons.forEach(button => {
        button.addEventListener('click', function() {
            const currentSection = this.closest('.form-section');
            const nextSectionId = this.dataset.next + '-section';
            const nextSection = document.getElementById(nextSectionId);
            
            // Validate current section before proceeding
            if (validateSection(currentSection)) {
                // Hide current section
                currentSection.classList.remove('active');
                
                // Show next section
                nextSection.classList.add('active');
                
                // Update progress indicator
                updateProgress(this.dataset.next);
                
                // Scroll to top of form
                scrollToTop();
            }
        });
    });
    
    // Previous button click handler
    prevButtons.forEach(button => {
        button.addEventListener('click', function() {
            const currentSection = this.closest('.form-section');
            const prevSectionId = this.dataset.prev + '-section';
            const prevSection = document.getElementById(prevSectionId);
            
            // Hide current section
            currentSection.classList.remove('active');
            
            // Show previous section
            prevSection.classList.add('active');
            
            // Update progress indicator
            updateProgress(this.dataset.prev);
            
            // Scroll to top of form
            scrollToTop();
        });
    });
    
    // Update progress indicator
    function updateProgress(step) {
        progressSteps.forEach(progressStep => {
            progressStep.classList.remove('active', 'completed');
            
            if (progressStep.dataset.step === step) {
                progressStep.classList.add('active');
            } else if (getStepIndex(progressStep.dataset.step) < getStepIndex(step)) {
                progressStep.classList.add('completed');
            }
        });
        
        // Update connectors
        progressConnectors.forEach((connector, index) => {
            connector.classList.remove('active');
            
            if (index < getStepIndex(step)) {
                connector.classList.add('active');
            }
        });
    }
    
    // Get step index
    function getStepIndex(step) {
        const steps = ['personal', 'contact', 'employment'];
        return steps.indexOf(step);
    }
    
    // Scroll to top of form
    function scrollToTop() {
        const formContainer = document.querySelector('.form-container');
        formContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    
    // Form validation
    function validateSection(section) {
        let isValid = true;
        const requiredFields = section.querySelectorAll('input[required], select[required], textarea[required]');
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
                
                // Add error message if not exists
                const errorExists = field.nextElementSibling && field.nextElementSibling.classList.contains('error-message');
                if (!errorExists) {
                    const errorMessage = document.createElement('div');
                    errorMessage.classList.add('error-message');
                    errorMessage.textContent = 'This field is required';
                    field.parentNode.insertBefore(errorMessage, field.nextElementSibling);
                }
                
                // Add shake animation
                field.classList.add('shake');
                setTimeout(() => {
                    field.classList.remove('shake');
                }, 500);
            } else {
                field.classList.remove('is-invalid');
                
                // Remove error message if exists
                const errorMessage = field.nextElementSibling;
                if (errorMessage && errorMessage.classList.contains('error-message')) {
                    errorMessage.remove();
                }
            }
        });
        
        // Focus on first invalid field
        if (!isValid) {
            const firstInvalidField = section.querySelector('.is-invalid');
            if (firstInvalidField) {
                firstInvalidField.focus();
            }
        }
        
        return isValid;
    }
    
    // Form input animations
    const formInputs = document.querySelectorAll('.form-control');
    
    formInputs.forEach(input => {
        // Add focus class to parent on focus
        input.addEventListener('focus', function() {
            this.parentNode.classList.add('input-focused');
        });
        
        // Remove focus class from parent on blur
        input.addEventListener('blur', function() {
            this.parentNode.classList.remove('input-focused');
        });
        
        // Validate on blur
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });
    
    // Form submission
    const form = document.getElementById('editEmployeeForm');
    
    form.addEventListener('submit', function(event) {
        // Validate all sections before submission
        let isValid = true;
        
        formSections.forEach(section => {
            if (!validateSection(section)) {
                isValid = false;
                
                // Show the section with errors
                formSections.forEach(s => s.classList.remove('active'));
                section.classList.add('active');
                
                // Update progress indicator
                updateProgress(section.id.replace('-section', ''));
                
                // Scroll to top of form
                scrollToTop();
                
                // Stop checking after first invalid section
                return false;
            }
        });
        
        if (!isValid) {
            event.preventDefault();
        }
    });
    
    // Initialize form with first section active
    updateProgress('personal');
});