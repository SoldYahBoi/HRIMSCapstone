document.addEventListener('DOMContentLoaded', function() {
    // Job Listings Page - Department Filter
    const departmentRadios = document.querySelectorAll('input[name="department"]');
    const jobCards = document.querySelectorAll('.job-card');
    const jobCountElement = document.getElementById('job-count-number');
    
    if (departmentRadios.length > 0 && jobCards.length > 0) {
        departmentRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const selectedDepartment = this.value;
                let visibleCount = 0;
                
                jobCards.forEach(card => {
                    if (selectedDepartment === 'all' || card.dataset.department === selectedDepartment) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                if (jobCountElement) {
                    jobCountElement.textContent = visibleCount;
                }
            });
        });
    }
    
    // Job Details Page - Deadline Countdown
    const deadlineElement = document.querySelector('.deadline-countdown');
    if (deadlineElement) {
        const deadline = new Date(deadlineElement.dataset.deadline);
        const today = new Date();
        
        // Calculate days difference
        const diffTime = deadline.getTime() - today.getTime();
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        const daysLeftElement = deadlineElement.querySelector('.days-left');
        if (daysLeftElement) {
            daysLeftElement.textContent = diffDays > 0 ? diffDays : 0;
            
            // Change color based on urgency
            if (diffDays <= 3) {
                deadlineElement.style.color = '#ef4444'; // Red for urgent
            } else if (diffDays <= 7) {
                deadlineElement.style.color = '#f59e0b'; // Orange for approaching
            }
        }
    }
    
    // Application Form - File Upload UI
    const resumeInput = document.getElementById('resume');
    const resumeFileName = document.getElementById('resume-file-name');
    const additionalDocsInput = document.getElementById('additional_documents');
    const additionalDocsCount = document.getElementById('additional-documents-count');
    
    if (resumeInput && resumeFileName) {
        resumeInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                resumeFileName.textContent = this.files[0].name;
            } else {
                resumeFileName.textContent = 'No file selected';
            }
        });
    }
    
    if (additionalDocsInput && additionalDocsCount) {
        additionalDocsInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                additionalDocsCount.textContent = `${this.files.length} file(s) selected`;
            } else {
                additionalDocsCount.textContent = 'No files selected';
            }
        });
    }
    
    // Form Validation
    const applicationForm = document.getElementById('application-form');
    if (applicationForm) {
        applicationForm.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Basic validation for required fields
            const requiredInputs = this.querySelectorAll('input[required], textarea[required]');
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    // Add error class
                    input.classList.add('error');
                    
                    // Find or create error message
                    let errorElement = input.nextElementSibling;
                    if (!errorElement || !errorElement.classList.contains('error-message')) {
                        errorElement = document.createElement('div');
                        errorElement.classList.add('error-message');
                        input.parentNode.insertBefore(errorElement, input.nextSibling);
                    }
                    errorElement.textContent = 'This field is required';
                } else {
                    // Remove error class
                    input.classList.remove('error');
                    
                    // Remove error message if exists
                    const errorElement = input.nextElementSibling;
                    if (errorElement && errorElement.classList.contains('error-message')) {
                        errorElement.textContent = '';
                    }
                }
            });
            
            // Email validation
            const emailInput = document.getElementById('email');
            if (emailInput && emailInput.value.trim()) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(emailInput.value.trim())) {
                    isValid = false;
                    emailInput.classList.add('error');
                    
                    let errorElement = emailInput.nextElementSibling;
                    if (!errorElement || !errorElement.classList.contains('error-message')) {
                        errorElement = document.createElement('div');
                        errorElement.classList.add('error-message');
                        emailInput.parentNode.insertBefore(errorElement, emailInput.nextSibling);
                    }
                    errorElement.textContent = 'Please enter a valid email address';
                }
            }
            
            // Phone validation
            const phoneInput = document.getElementById('phone');
            if (phoneInput && phoneInput.value.trim()) {
                const phonePattern = /^[+]?[(]?[0-9]{3}[)]?[-\s.]?[0-9]{3}[-\s.]?[0-9]{4,6}$/;
                if (!phonePattern.test(phoneInput.value.trim())) {
                    isValid = false;
                    phoneInput.classList.add('error');
                    
                    let errorElement = phoneInput.nextElementSibling;
                    if (!errorElement || !errorElement.classList.contains('error-message')) {
                        errorElement = document.createElement('div');
                        errorElement.classList.add('error-message');
                        phoneInput.parentNode.insertBefore(errorElement, phoneInput.nextSibling);
                    }
                    errorElement.textContent = 'Please enter a valid phone number';
                }
            }
            
            // Resume file validation
            if (resumeInput && resumeInput.files.length > 0) {
                const file = resumeInput.files[0];
                const fileSize = file.size / 1024 / 1024; // in MB
                const fileType = file.type;
                const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                
                if (!allowedTypes.includes(fileType)) {
                    isValid = false;
                    
                    let errorElement = resumeInput.parentNode.nextElementSibling;
                    if (!errorElement || !errorElement.classList.contains('error-message')) {
                        errorElement = document.createElement('div');
                        errorElement.classList.add('error-message');
                        resumeInput.parentNode.parentNode.insertBefore(errorElement, resumeInput.parentNode.nextSibling);
                    }
                    errorElement.textContent = 'Please upload a PDF, DOC, or DOCX file';
                }
                
                if (fileSize > 2) {
                    isValid = false;
                    
                    let errorElement = resumeInput.parentNode.nextElementSibling;
                    if (!errorElement || !errorElement.classList.contains('error-message')) {
                        errorElement = document.createElement('div');
                        errorElement.classList.add('error-message');
                        resumeInput.parentNode.parentNode.insertBefore(errorElement, resumeInput.parentNode.nextSibling);
                    }
                    errorElement.textContent = 'File size must be less than 2MB';
                }
            }
            
            // Additional documents validation
            if (additionalDocsInput && additionalDocsInput.files.length > 0) {
                for (let i = 0; i < additionalDocsInput.files.length; i++) {
                    const file = additionalDocsInput.files[i];
                    const fileSize = file.size / 1024 / 1024; // in MB
                    const fileType = file.type;
                    const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                    
                    if (!allowedTypes.includes(fileType) || fileSize > 2) {
                        isValid = false;
                        
                        let errorElement = additionalDocsInput.parentNode.nextElementSibling;
                        if (!errorElement || !errorElement.classList.contains('error-message')) {
                            errorElement = document.createElement('div');
                            errorElement.classList.add('error-message');
                            additionalDocsInput.parentNode.parentNode.insertBefore(errorElement, additionalDocsInput.parentNode.nextSibling);
                        }
                        errorElement.textContent = 'All files must be PDF, DOC, or DOCX format and less than 2MB each';
                        break;
                    }
                }
            }
            
            if (!isValid) {
                event.preventDefault();
                
                // Scroll to the first error
                const firstError = document.querySelector('.error, .error-message');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
        
        // Clear error on input
        const formInputs = applicationForm.querySelectorAll('input, textarea');
        formInputs.forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('error');
                
                const errorElement = this.nextElementSibling;
                if (errorElement && errorElement.classList.contains('error-message')) {
                    errorElement.textContent = '';
                }
            });
        });
    }
});