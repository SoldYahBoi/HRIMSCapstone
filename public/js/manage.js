document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const archiveButtons = document.querySelectorAll('.btn-icon.archive');
    const archiveModal = document.getElementById('archiveModal');
    const modalOverlay = document.querySelector('.modal-overlay');
    const modalClose = document.querySelector('.modal-close');
    const cancelArchiveBtn = document.getElementById('cancelArchive');
    const confirmArchiveBtn = document.getElementById('confirmArchive');
    const archiveModalMessage = document.getElementById('archiveModalMessage');
    
    // Current form to submit
    let currentArchiveForm = null;
    
    // Open modal when archive button is clicked
    archiveButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get employee details
            const employeeId = this.dataset.employeeId;
            const employeeName = this.dataset.employeeName;
            
            // Update modal message
            archiveModalMessage.textContent = `Are you sure you want to archive ${employeeName}?`;
            
            // Store the form to submit later
            currentArchiveForm = this.closest('form');
            
            // Show modal with animation
            document.body.classList.add('modal-open');
            archiveModal.classList.add('show');
            
            // Focus on cancel button (better accessibility)
            setTimeout(() => {
                cancelArchiveBtn.focus();
            }, 100);
        });
    });
    
    // Close modal function
    function closeModal() {
        archiveModal.classList.remove('show');
        archiveModal.classList.add('hiding');
        
        // Remove hiding class after animation completes
        setTimeout(() => {
            archiveModal.classList.remove('hiding');
            document.body.classList.remove('modal-open');
        }, 300);
    }
    
    // Close modal when clicking the close button
    modalClose.addEventListener('click', closeModal);
    
    // Close modal when clicking the cancel button
    cancelArchiveBtn.addEventListener('click', closeModal);
    
    // Close modal when clicking outside the modal
    modalOverlay.addEventListener('click', closeModal);
    
    // Submit form when confirm button is clicked
    confirmArchiveBtn.addEventListener('click', function() {
        if (currentArchiveForm) {
            // Add loading state to button
            this.classList.add('loading');
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            this.disabled = true;
            
            // Submit the form after a short delay to show the loading state
            setTimeout(() => {
                currentArchiveForm.submit();
            }, 500);
        }
    });
    
    // Close modal when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && archiveModal.classList.contains('show')) {
            closeModal();
        }
    });
    
    // Trap focus inside modal for accessibility
    archiveModal.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            const focusableElements = archiveModal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];
            
            // If shift+tab and focus is on first element, move to last element
            if (e.shiftKey && document.activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            }
            // If tab and focus is on last element, move to first element
            else if (!e.shiftKey && document.activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        }
    });
    
    // Search functionality
    const searchInput = document.querySelector('.search-box input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.employee-table tbody tr');
            
            rows.forEach(row => {
                const employeeName = row.querySelector('.employee-name').textContent.toLowerCase();
                const employeeEmail = row.querySelector('.employee-email').textContent.toLowerCase();
                const position = row.querySelector('.position-badge')?.textContent.toLowerCase() || '';
                const department = row.querySelector('.department-badge')?.textContent.toLowerCase() || '';
                
                if (employeeName.includes(searchTerm) || 
                    employeeEmail.includes(searchTerm) || 
                    position.includes(searchTerm) || 
                    department.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});