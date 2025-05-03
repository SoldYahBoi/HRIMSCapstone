document.addEventListener('DOMContentLoaded', function() {
    // Ensure all modals are hidden on page load
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.style.display = 'none';
        modal.classList.remove('active');
    });

    // Enhanced modal open function with animation
    function openModal(modal) {
        if (!modal) return;
        
        // First set display to flex to make it visible
        modal.style.display = 'flex';
        
        // Force a reflow to ensure the transition works
        void modal.offsetWidth;
        
        // Then add the active class for the animation
        modal.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent scrolling behind modal
        
        // Set focus to the first focusable element for accessibility
        setTimeout(() => {
            const focusableElements = modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (focusableElements.length) {
                focusableElements[0].focus();
            }
        }, 100);
    }
    
    // Enhanced modal close function with animation
    function closeModal(modal) {
        if (!modal) return;
        
        modal.classList.remove('active');
        
        // Wait for the animation to complete before hiding
        setTimeout(() => {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }, 300); // Match this to your CSS animation duration
    }
    
    // Close all modals
    function closeAllModals() {
        modals.forEach(modal => closeModal(modal));
    }

    // Modal functionality
    const addPositionBtn = document.getElementById('addPositionBtn');
    const addPositionModal = document.getElementById('addPositionModal');
    const viewApplicationModal = document.getElementById('viewApplicationModal');
    const closeModalButtons = document.querySelectorAll('.close-modal');
    const cancelPosition = document.getElementById('cancelPosition');
    const closeApplicationModal = document.getElementById('closeApplicationModal');
    
    // Open add position modal
    if (addPositionBtn) {
        addPositionBtn.addEventListener('click', function() {
            openModal(addPositionModal);
        });
    }
    
    // Close modals when clicking close buttons
    closeModalButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            closeModal(modal);
        });
    });
    
    if (cancelPosition) {
        cancelPosition.addEventListener('click', function() {
            closeModal(addPositionModal);
        });
    }
    
    if (closeApplicationModal) {
        closeApplicationModal.addEventListener('click', function() {
            closeModal(viewApplicationModal);
        });
    }
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        modals.forEach(modal => {
            if (event.target === modal) {
                closeModal(modal);
            }
        });
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeAllModals();
        }
    });
    
    // View application functionality
    const viewApplicationButtons = document.querySelectorAll('.view-application');
    
    viewApplicationButtons.forEach(button => {
        button.addEventListener('click', function() {
            const applicationId = this.getAttribute('data-id');
            // In a real application, you would fetch application details from the server
            
            openModal(viewApplicationModal);
        });
    });
    
    // Application tabs
    const applicationTabButtons = document.querySelectorAll('.application-tab-btn');
    const applicationTabContents = document.querySelectorAll('.application-tab-content');
    
    applicationTabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and contents
            applicationTabButtons.forEach(btn => btn.classList.remove('active'));
            applicationTabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked button and corresponding content
            this.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Tab Navigation
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
        });
    });
    
    // View applicants functionality
    const viewApplicantsButtons = document.querySelectorAll('.view-applicants');
    
    viewApplicantsButtons.forEach(button => {
        button.addEventListener('click', function() {
            const positionId = this.getAttribute('data-id');
            
            // Switch to applications tab
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            document.querySelector('[data-tab="applications"]').classList.add('active');
            document.getElementById('applications').classList.add('active');
            
            // In a real application, you would filter applications by position
            showNotification('Showing applicants for this position', 'info');
        });
    });
    
    // Schedule interview functionality
    const scheduleInterviewButtons = document.querySelectorAll('.schedule-interview');
    
    scheduleInterviewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const applicationId = this.getAttribute('data-id');
            
            // In a real application, you would open a scheduling modal
            showNotification('Interview scheduling feature coming soon', 'info');
            
            // Close the application modal if open
            closeModals();
        });
    });
    
    // Reject application functionality
    const rejectApplicationButtons = document.querySelectorAll('.reject-application');
    
    rejectApplicationButtons.forEach(button => {
        button.addEventListener('click', function() {
            const applicationId = this.getAttribute('data-id');
            
            // In a real application, you would show a confirmation dialog
            if (confirm('Are you sure you want to reject this application?')) {
                // Update application status
                showNotification('Application rejected', 'success');
            }
        });
    });
    
    // Hire applicant functionality
    const hireApplicantButtons = document.querySelectorAll('.hire-applicant');
    
    hireApplicantButtons.forEach(button => {
        button.addEventListener('click', function() {
            const applicationId = this.getAttribute('data-id');
            
            // In a real application, you would show a confirmation dialog
            if (confirm('Are you sure you want to hire this applicant?')) {
                // Update application status
                showNotification('Applicant hired successfully', 'success');
            }
        });
    });
    
    // Edit position functionality
    const editPositionButtons = document.querySelectorAll('.edit-position');
    
    editPositionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const positionId = this.getAttribute('data-id');
            
            // In a real application, you would fetch position data and populate the form
            addPositionModal.classList.add('active');
            document.body.style.overflow = 'hidden';
            document.querySelector('#addPositionModal h3').textContent = 'Edit Position';
            document.querySelector('#savePosition').textContent = 'Update Position';
        });
    });
    
    // Delete position functionality
    const deletePositionButtons = document.querySelectorAll('.delete-position');
    
    deletePositionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const positionId = this.getAttribute('data-id');
            
            // In a real application, you would show a confirmation dialog
            if (confirm('Are you sure you want to delete this position? This action cannot be undone.')) {
                // Delete position
                showNotification('Position deleted successfully', 'success');
            }
        });
    });
    
    // Save position
    const savePositionButton = document.getElementById('savePosition');
    
    if (savePositionButton) {
        savePositionButton.addEventListener('click', function() {
            // In a real application, you would validate the form and submit data to the server
            
            // For demo purposes, we'll just close the modal
            closeModals();
            
            // Show a success notification
            showNotification('Position saved successfully', 'success');
        });
    }
    
    // Search functionality
    const searchInputs = document.querySelectorAll('input[id$="Search"]');
    
    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            // In a real application, you would implement search logic
            // For demo purposes, we'll just show a notification
            if (searchTerm.length > 2) {
                showNotification('Searching for: ' + searchTerm, 'info');
            }
        });
    });
    
    // Filter functionality
    const filterSelects = document.querySelectorAll('select[id$="Filter"]');
    
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            const filterValue = this.value;
            
            // In a real application, you would implement filtering logic
            // For demo purposes, we'll just show a notification
            showNotification('Filter applied: ' + filterValue, 'info');
        });
    });
    
    // Calendar day click
    const calendarDays = document.querySelectorAll('.calendar-day');
    
    calendarDays.forEach(day => {
        day.addEventListener('click', function() {
            if (this.classList.contains('inactive')) return;
            
            const dayNumber = this.textContent.trim();
            
            // In a real application, you would show events for this day
            if (this.classList.contains('has-events')) {
                const eventCount = this.querySelector('.event-indicator').getAttribute('data-count');
                showNotification(`${eventCount} interviews scheduled on June ${dayNumber}`, 'info');
            } else {
                showNotification(`No interviews scheduled on June ${dayNumber}`, 'info');
            }
        });
    });
    
    // Notification function
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-icon">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'info' ? 'info-circle' : 'exclamation-circle'}"></i>
            </div>
            <div class="notification-message">${message}</div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Add notification styles if not already present
    if (!document.getElementById('notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            .notification {
                position: fixed;
                top: 1rem;
                right: 1rem;
                display: flex;
                align-items: center;
                background-color: white;
                border-radius: 0.5rem;
                box-shadow: var(--shadow-lg);
                padding: 1rem;
                z-index: 9999;
                max-width: 24rem;
                transform: translateX(120%);
                opacity: 0;
                transition: transform 0.3s ease, opacity 0.3s ease;
            }
            
            .notification.show {
                transform: translateX(0);
                opacity: 1;
            }
            
            .notification-icon {
                margin-right: 0.75rem;
                font-size: 1.25rem;
            }
            
            .notification-success .notification-icon {
                color: var(--success);
            }
            
            .notification-info .notification-icon {
                color: var(--primary);
            }
            
            .notification-warning .notification-icon {
                color: var(--warning);
            }
            
            .notification-error .notification-icon {
                color: var(--danger);
            }
            
            .notification-message {
                flex: 1;
            }
            
            @media (max-width: 640px) {
                .notification {
                    left: 1rem;
                    right: 1rem;
                    max-width: none;
                }
            }
        `;
        document.head.appendChild(style);
    }
});