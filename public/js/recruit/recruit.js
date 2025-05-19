document.addEventListener('DOMContentLoaded', function() {
    // Initialize the recruitment dashboard
    initRecruitmentDashboard();
    
    // Ensure all modals are hidden on page load
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.style.display = 'none';
        modal.classList.remove('active');
    });

    // Enhanced modal open function with animation
    function openModal(modal) {
        if (!modal) {
            console.error('Modal element not found');
            return;
        }
        
        console.log('Opening modal:', modal.id); // Debug log
        
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
        if (!modal) {
            console.error('Modal element not found');
            return;
        }
        
        console.log('Closing modal:', modal.id); // Debug log
        
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
    const emptyStateAddPositionBtn = document.getElementById('emptyStateAddPositionBtn');
    const addPositionModal = document.getElementById('addPositionModal');
    const viewApplicationModal = document.getElementById('viewApplicationModal');
    const closeModalButtons = document.querySelectorAll('.close-modal');
    const cancelPosition = document.getElementById('cancelPosition');
    const closeApplicationModal = document.getElementById('closeApplicationModal');
    
    console.log('Add Position Button:', addPositionBtn); // Debug log
    console.log('Add Position Modal:', addPositionModal); // Debug log
    
    // Open add position modal
    if (addPositionBtn) {
        addPositionBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Add Position Button clicked');
            
            // Reset form
            if (document.getElementById('positionForm')) {
                document.getElementById('positionForm').reset();
            }
            
            if (document.querySelector('#addPositionModal h3')) {
                document.querySelector('#addPositionModal h3').innerHTML = '<i class="fas fa-briefcase" aria-hidden="true"></i> Post New Position';
            }
            
            if (document.querySelector('#savePosition')) {
                document.querySelector('#savePosition').innerHTML = '<i class="fas fa-save" aria-hidden="true"></i> Post Position';
            }
            
            // Set default deadline to 30 days from now
            const deadlineInput = document.getElementById('deadline');
            if (deadlineInput) {
                const thirtyDaysFromNow = new Date();
                thirtyDaysFromNow.setDate(thirtyDaysFromNow.getDate() + 30);
                deadlineInput.value = thirtyDaysFromNow.toISOString().split('T')[0];
            }
            
            openModal(addPositionModal);
        });
    }
    
    // Also handle the empty state button if it exists
    if (emptyStateAddPositionBtn) {
        emptyStateAddPositionBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Empty State Add Position Button clicked');
            
            if (document.getElementById('positionForm')) {
                document.getElementById('positionForm').reset();
            }
            
            // Set default deadline to 30 days from now
            const deadlineInput = document.getElementById('deadline');
            if (deadlineInput) {
                const thirtyDaysFromNow = new Date();
                thirtyDaysFromNow.setDate(thirtyDaysFromNow.getDate() + 30);
                deadlineInput.value = thirtyDaysFromNow.toISOString().split('T')[0];
            }
            
            openModal(addPositionModal);
        });
    }
    
    // Close modals when clicking close buttons
    closeModalButtons.forEach(button => {
        button.addEventListener('click', function() {
            console.log('Close button clicked');
            const modal = this.closest('.modal');
            closeModal(modal);
        });
    });
    
    if (cancelPosition) {
        cancelPosition.addEventListener('click', function() {
            console.log('Cancel Position button clicked');
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
            
            // Save active tab to session storage
            sessionStorage.setItem('activeRecruitmentTab', tabId);
        });
    });
    
    // Restore active tab from session storage
    const activeTab = sessionStorage.getItem('activeRecruitmentTab');
    if (activeTab) {
        const activeTabButton = document.querySelector(`.tab-btn[data-tab="${activeTab}"]`);
        if (activeTabButton) {
            activeTabButton.click();
        }
    }
    
    // Initialize the recruitment dashboard
    function initRecruitmentDashboard() {
        // Initialize search functionality
        initSearch();
        
        // Initialize filters
        initFilters();
        
        // Initialize position actions
        initPositionActions();
        
        // Initialize application actions
        initApplicationActions();
        
        // Initialize interview actions
        initInterviewActions();
        
        // Initialize calendar
        initCalendar();
        
        // Initialize reports
        initReports();
        
        // Initialize form submission
        initFormSubmission();
    }
    
    // Initialize search functionality
    function initSearch() {
        const searchInputs = document.querySelectorAll('input[id$="Search"]');
        
        searchInputs.forEach(input => {
            input.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const searchType = this.id.replace('Search', '');
                
                if (searchTerm.length > 2) {
                    performSearch(searchType, searchTerm);
                } else if (searchTerm.length === 0) {
                    resetSearch(searchType);
                }
            });
        });
    }
    
    // Perform search
    function performSearch(type, term) {
        if (type === 'position') {
            const positionCards = document.querySelectorAll('.position-card');
            
            positionCards.forEach(card => {
                const title = card.querySelector('.position-title').textContent.toLowerCase();
                const department = card.querySelector('.department-badge').textContent.toLowerCase();
                const description = card.querySelector('.position-description').textContent.toLowerCase();
                
                if (title.includes(term) || department.includes(term) || description.includes(term)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        } else if (type === 'application') {
            const applicationRows = document.querySelectorAll('.applications-table tbody tr');
            
            applicationRows.forEach(row => {
                const name = row.querySelector('.applicant-name').textContent.toLowerCase();
                const email = row.querySelector('.applicant-email').textContent.toLowerCase();
                const position = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const department = row.querySelector('.department-badge').textContent.toLowerCase();
                
                if (name.includes(term) || email.includes(term) || position.includes(term) || department.includes(term)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    }
    
    // Reset search
    function resetSearch(type) {
        if (type === 'position') {
            const positionCards = document.querySelectorAll('.position-card');
            positionCards.forEach(card => card.style.display = '');
        } else if (type === 'application') {
            const applicationRows = document.querySelectorAll('.applications-table tbody tr');
            applicationRows.forEach(row => row.style.display = '');
        }
    }
    
    // Initialize filters
    function initFilters() {
        const filterSelects = document.querySelectorAll('select[id$="Filter"]');
        
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                const filterValue = this.value;
                const filterType = this.id.replace('Filter', '');
                
                applyFilter(filterType, filterValue);
            });
        });
    }
    
    // Apply filter
    function applyFilter(type, value) {
        if (type === 'department') {
            const positionCards = document.querySelectorAll('.position-card');
            
            positionCards.forEach(card => {
                const department = card.querySelector('.department-badge').className.split('dept-')[1].split(' ')[0];
                
                if (value === 'all' || department === value) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        } else if (type === 'status') {
            const applicationRows = document.querySelectorAll('.applications-table tbody tr');
            
            applicationRows.forEach(row => {
                const status = row.querySelector('.status-badge').className.split('status-')[1].split(' ')[0];
                
                if (value === 'all' || status === value) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    }
    
    // Initialize position actions
    function initPositionActions() {
        // View applicants
        const viewApplicantsButtons = document.querySelectorAll('.view-applicants');
        
        viewApplicantsButtons.forEach(button => {
            button.addEventListener('click', function() {
                const positionId = this.getAttribute('data-id');
                
                // Switch to applications tab
                document.querySelector('[data-tab="applications"]').click();
                
                // Filter applications by position
                fetch(`/recruitment/positions/${positionId}/applications`)
                    .then(response => response.json())
                    .then(data => {
                        // Update applications table with filtered data
                        updateApplicationsTable(data.applications);
                        
                        showNotification(`Showing applicants for ${data.jobPosting.position.position_name}`, 'info');
                    })
                    .catch(error => {
                        console.error('Error fetching applications:', error);
                        showNotification('Error fetching applications', 'error');
                    });
            });
        });
        
        // Edit position
        const editPositionButtons = document.querySelectorAll('.edit-position');
        
        editPositionButtons.forEach(button => {
            button.addEventListener('click', function() {
                const positionId = this.getAttribute('data-id');
                
                // Fetch position data
                fetch(`/recruitment/positions/${positionId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate form with position data
                        populatePositionForm(data.jobPosting);
                        
                        // Update modal title and button
                        document.querySelector('#addPositionModal h3').innerHTML = '<i class="fas fa-edit" aria-hidden="true"></i> Edit Position';
                        document.querySelector('#savePosition').innerHTML = '<i class="fas fa-save" aria-hidden="true"></i> Update Position';
                        
                        // Add position ID to form
                        const form = document.getElementById('positionForm');
                        const positionIdInput = document.createElement('input');
                        positionIdInput.type = 'hidden';
                        positionIdInput.name = 'position_id';
                        positionIdInput.value = positionId;
                        form.appendChild(positionIdInput);
                        
                        // Open modal
                        openModal(addPositionModal);
                    })
                    .catch(error => {
                        console.error('Error fetching position:', error);
                        showNotification('Error fetching position data', 'error');
                    });
            });
        });
        
        // Delete position
        const deletePositionButtons = document.querySelectorAll('.delete-position');
        
        deletePositionButtons.forEach(button => {
            button.addEventListener('click', function() {
                const positionId = this.getAttribute('data-id');
                
                if (confirm('Are you sure you want to delete this position? This action cannot be undone.')) {
                    // Send delete request
                    fetch(`/recruitment/positions/${positionId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove position card from DOM
                            this.closest('.position-card').remove();
                            
                            showNotification('Position deleted successfully', 'success');
                        } else {
                            showNotification(data.message || 'Error deleting position', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting position:', error);
                        showNotification('Error deleting position', 'error');
                    });
                }
            });
        });
        
        // Share position
        const shareButtons = document.querySelectorAll('.position-footer .btn-primary');
        
        shareButtons.forEach(button => {
            button.addEventListener('click', function() {
                const positionCard = this.closest('.position-card');
                const positionTitle = positionCard.querySelector('.position-title').textContent;
                const positionId = positionCard.querySelector('.view-applicants').getAttribute('data-id');
                
                // Create share URL
                const shareUrl = `${window.location.origin}/recruitment/jobs/${positionId}`;
                
                // Create and show share dialog
                const shareDialog = document.createElement('div');
                shareDialog.className = 'share-dialog';
                shareDialog.innerHTML = `
                    <h4>Share "${positionTitle}"</h4>
                    <div class="share-url">
                        <input type="text" value="${shareUrl}" readonly>
                        <button class="btn btn-outline copy-url">
                            <i class="fas fa-copy" aria-hidden="true"></i> Copy
                        </button>
                    </div>
                    <div class="share-social">
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(shareUrl)}" target="_blank" class="btn btn-outline">
                            <i class="fab fa-linkedin" aria-hidden="true"></i> LinkedIn
                        </a>
                        <a href="https://twitter.com/intent/tweet?text=${encodeURIComponent('Check out this job opportunity: ' + positionTitle)}&url=${encodeURIComponent(shareUrl)}" target="_blank" class="btn btn-outline">
                            <i class="fab fa-twitter" aria-hidden="true"></i> Twitter
                        </a>
                        <a href="mailto:?subject=${encodeURIComponent('Job Opportunity: ' + positionTitle)}&body=${encodeURIComponent('Check out this job opportunity: ' + shareUrl)}" class="btn btn-outline">
                            <i class="fas fa-envelope" aria-hidden="true"></i> Email
                        </a>
                    </div>
                `;
                
                // Add share dialog to DOM
                document.body.appendChild(shareDialog);
                
                // Add copy functionality
                const copyButton = shareDialog.querySelector('.copy-url');
                const urlInput = shareDialog.querySelector('input');
                
                copyButton.addEventListener('click', function() {
                    urlInput.select();
                    document.execCommand('copy');
                    this.innerHTML = '<i class="fas fa-check" aria-hidden="true"></i> Copied!';
                    setTimeout(() => {
                        this.innerHTML = '<i class="fas fa-copy" aria-hidden="true"></i> Copy';
                    }, 2000);
                });
                
                // Close dialog when clicking outside
                document.addEventListener('click', function closeDialog(e) {
                    if (!shareDialog.contains(e.target) && e.target !== button) {
                        shareDialog.remove();
                        document.removeEventListener('click', closeDialog);
                    }
                });
                
                // Position dialog
                const rect = button.getBoundingClientRect();
                shareDialog.style.position = 'absolute';
                shareDialog.style.top = `${rect.bottom + window.scrollY + 10}px`;
                shareDialog.style.right = `${window.innerWidth - rect.right - window.scrollX}px`;
                shareDialog.style.zIndex = '1000';
                shareDialog.style.backgroundColor = 'white';
                shareDialog.style.padding = '1rem';
                shareDialog.style.borderRadius = '0.5rem';
                shareDialog.style.boxShadow = 'var(--shadow-lg)';
                shareDialog.style.width = '300px';
            });
        });
    }
    
    // Populate position form
    function populatePositionForm(jobPosting) {
        document.getElementById('positionTitle').value = jobPosting.position_id;
        document.getElementById('department').value = jobPosting.department_id;
        document.getElementById('location').value = jobPosting.location;
        document.getElementById('employmentType').value = jobPosting.employment_type;
        document.getElementById('description').value = jobPosting.description;
        document.getElementById('requirements').value = jobPosting.requirements;
        document.getElementById('benefits').value = jobPosting.benefits;
        document.getElementById('salary').value = jobPosting.salary_range;
        document.getElementById('deadline').value = jobPosting.application_deadline.split('T')[0];
    }
    
    // Initialize application actions
    function initApplicationActions() {
        // View application
        const viewApplicationButtons = document.querySelectorAll('.view-application');
        
        viewApplicationButtons.forEach(button => {
            button.addEventListener('click', function() {
                const applicationId = this.getAttribute('data-id');
                
                // Fetch application data
                fetch(`/recruitment/applications/${applicationId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate application modal
                        populateApplicationModal(data.application, data.documents);
                        
                        // Open modal
                        openModal(viewApplicationModal);
                    })
                    .catch(error => {
                        console.error('Error fetching application:', error);
                        showNotification('Error fetching application data', 'error');
                    });
            });
        });
        
        // Schedule interview
        const scheduleInterviewButtons = document.querySelectorAll('.schedule-interview');
        
        scheduleInterviewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const applicationId = this.getAttribute('data-id');
                
                // Create and show interview scheduling dialog
                createInterviewDialog(applicationId);
            });
        });
        
        // Reject application
        const rejectApplicationButtons = document.querySelectorAll('.reject-application');
        
        rejectApplicationButtons.forEach(button => {
            button.addEventListener('click', function() {
                const applicationId = this.getAttribute('data-id');
                
                if (confirm('Are you sure you want to reject this application?')) {
                    // Update application status
                    updateApplicationStatus(applicationId, 'rejected');
                }
            });
        });
        
        // Hire applicant
        const hireApplicantButtons = document.querySelectorAll('.hire-applicant');
        
        hireApplicantButtons.forEach(button => {
            button.addEventListener('click', function() {
                const applicationId = this.getAttribute('data-id');
                
                if (confirm('Are you sure you want to hire this applicant?')) {
                    // Update application status
                    updateApplicationStatus(applicationId, 'hired');
                }
            });
        });
        
        // Restore application
        const restoreApplicationButtons = document.querySelectorAll('.restore-application');
        
        restoreApplicationButtons.forEach(button => {
            button.addEventListener('click', function() {
                const applicationId = this.getAttribute('data-id');
                
                // Update application status
                updateApplicationStatus(applicationId, 'reviewing');
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
        
        // Update application status
        const statusSelector = document.querySelector('.status-selector select');
        const updateStatusButton = document.querySelector('.status-selector button');
        
        if (updateStatusButton) {
            updateStatusButton.addEventListener('click', function() {
                const applicationId = this.closest('.modal').getAttribute('data-application-id');
                const status = statusSelector.value;
                
                updateApplicationStatus(applicationId, status);
            });
        }
        
        // Add note
        const addNoteButton = document.querySelector('.add-note button');
        
        if (addNoteButton) {
            addNoteButton.addEventListener('click', function() {
                const applicationId = this.closest('.modal').getAttribute('data-application-id');
                const noteContent = document.querySelector('.add-note textarea').value;
                
                if (noteContent.trim() === '') {
                    showNotification('Please enter a note', 'warning');
                    return;
                }
                
                // Add note
                fetch(`/recruitment/applications/${applicationId}/notes`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ note_content: noteContent })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Add note to list
                        const notesList = document.querySelector('.notes-list');
                        const noteItem = document.createElement('div');
                        noteItem.className = 'note-item';
                        noteItem.innerHTML = `
                            <div class="note-header">
                                <div class="note-author">${data.note.created_by_name}</div>
                                <div class="note-date">${new Date(data.note.created_at).toLocaleDateString()}</div>
                            </div>
                            <div class="note-content">${data.note.content}</div>
                        `;
                        notesList.prepend(noteItem);
                        
                        // Clear textarea
                        document.querySelector('.add-note textarea').value = '';
                        
                        showNotification('Note added successfully', 'success');
                    } else {
                        showNotification(data.message || 'Error adding note', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error adding note:', error);
                    showNotification('Error adding note', 'error');
                });
            });
        }
    }
    
    // Populate application modal
    function populateApplicationModal(application, documents) {
        // Set application ID
        viewApplicationModal.setAttribute('data-application-id', application.id);
        
        // Populate applicant info
        const applicantName = `${application.applicant.first_name} ${application.applicant.last_name}`;
        const applicantInitials = application.applicant.first_name.charAt(0) + application.applicant.last_name.charAt(0);
        
        document.querySelector('.applicant-avatar.large').textContent = applicantInitials;
        document.querySelector('.applicant-info-large h4').textContent = applicantName;
        document.querySelector('.applicant-contact span:first-child').innerHTML = `<i class="fas fa-envelope" aria-hidden="true"></i> ${application.applicant.email}`;
        document.querySelector('.applicant-contact span:last-child').innerHTML = `<i class="fas fa-phone" aria-hidden="true"></i> ${application.applicant.phone}`;
        document.querySelector('.applicant-meta span:first-child').innerHTML = `<i class="fas fa-map-marker-alt" aria-hidden="true"></i> ${application.applicant.city}, ${application.applicant.state}`;
        document.querySelector('.applicant-meta span:last-child').innerHTML = `<i class="fas fa-briefcase" aria-hidden="true"></i> ${application.applicant.years_of_experience} years experience`;
        
        // Populate status
        document.querySelector('.application-status .status-badge').className = `status-badge status-${application.status}`;
        document.querySelector('.application-status .status-badge').textContent = application.status.charAt(0).toUpperCase() + application.status.slice(1);
        document.querySelector('.status-selector select').value = application.status;
        
        // Populate resume
        const resumeTab = document.getElementById('resume');
        resumeTab.innerHTML = `
            <div class="resume-preview">
                <h4>Professional Summary</h4>
                <p>${application.applicant.skills}</p>
                
                <h4>Work Experience</h4>
                ${application.applicant.current_employer ? `
                <div class="resume-item">
                    <div class="resume-item-header">
                        <div class="resume-item-title">${application.applicant.current_position}</div>
                        <div class="resume-item-period">Current</div>
                    </div>
                    <div class="resume-item-subtitle">${application.applicant.current_employer}</div>
                </div>
                ` : '<p>No current employment information provided.</p>'}
                
                <h4>Education</h4>
                <p>${application.applicant.education}</p>
                
                <h4>Certifications</h4>
                ${application.applicant.certifications ? `
                <ul class="resume-certifications">
                    ${application.applicant.certifications.split(',').map(cert => `<li>${cert.trim()}</li>`).join('')}
                </ul>
                ` : '<p>No certifications provided.</p>'}
            </div>
        `;
        
        // Populate cover letter
        const coverLetterTab = document.getElementById('cover-letter');
        coverLetterTab.innerHTML = `
            <div class="cover-letter-preview">
                ${application.cover_letter ? application.cover_letter.split('\n').map(para => `<p>${para}</p>`).join('') : '<p>No cover letter provided.</p>'}
            </div>
        `;
        
        // Populate documents
        const documentsTab = document.getElementById('documents');
        let documentsHTML = '<div class="documents-list">';
        
        if (documents.length > 0) {
            documents.forEach(doc => {
                const iconClass = doc.mime_type.includes('pdf') ? 'fa-file-pdf' : 
                                 doc.mime_type.includes('word') ? 'fa-file-word' : 'fa-file';
                
                documentsHTML += `
                    <div class="document-item">
                        <i class="fas ${iconClass}" aria-hidden="true"></i>
                        <span class="document-name">${doc.file_name}</span>
                        <div class="document-actions">
                            <a href="/recruitment/documents/${doc.id}/download" class="btn-icon" title="Download">
                                <i class="fas fa-download" aria-hidden="true"></i>
                            </a>
                            <button class="btn-icon view-document" data-url="/storage/${doc.file_path}" title="View">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
        } else {
            documentsHTML += '<p>No documents available.</p>';
        }
        
        documentsHTML += '</div>';
        documentsTab.innerHTML = documentsHTML;
        
        // Populate notes
        const notesTab = document.getElementById('notes');
        let notesHTML = '<div class="notes-container"><div class="notes-list">';
        
        if (application.notes && application.notes.length > 0) {
            application.notes.forEach(note => {
                notesHTML += `
                    <div class="note-item">
                        <div class="note-header">
                            <div class="note-author">${note.created_by_name}</div>
                            <div class="note-date">${new Date(note.created_at).toLocaleDateString()}</div>
                        </div>
                        <div class="note-content">${note.content}</div>
                    </div>
                `;
            });
        } else {
            notesHTML += '<p>No notes available.</p>';
        }
        
        notesHTML += `
            </div>
            <div class="add-note">
                <textarea class="form-control" placeholder="Add a note about this candidate..."></textarea>
                <button class="btn btn-primary">
                    <i class="fas fa-plus" aria-hidden="true"></i> Add Note
                </button>
            </div>
        </div>`;
        
        notesTab.innerHTML = notesHTML;
        
        // Add event listeners to view document buttons
        const viewDocumentButtons = notesTab.querySelectorAll('.view-document');
        
        viewDocumentButtons.forEach(button => {
            button.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                window.open(url, '_blank');
            });
        });
        
        // Update schedule interview button
        const scheduleInterviewBtn = document.getElementById('scheduleInterviewBtn');
        
        if (scheduleInterviewBtn) {
            scheduleInterviewBtn.setAttribute('data-id', application.id);
        }
    }
    
    // Create interview dialog
    function createInterviewDialog(applicationId) {
        // Create dialog
        const dialog = document.createElement('div');
        dialog.className = 'modal active';
        dialog.style.display = 'flex';
        dialog.innerHTML = `
            <div class="modal-content modal-sm">
                <div class="modal-header">
                    <h3><i class="fas fa-calendar-plus" aria-hidden="true"></i> Schedule Interview</h3>
                    <button class="close-modal" aria-label="Close modal">
                        <i class="fas fa-times" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="interviewForm">
                        <input type="hidden" name="application_id" value="${applicationId}">
                        
                        <div class="form-group">
                            <label class="form-label" for="interview_date">Interview Date</label>
                            <input type="date" id="interview_date" name="interview_date" class="form-control" required min="${new Date().toISOString().split('T')[0]}">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="interview_time">Interview Time</label>
                                <input type="time" id="interview_time" name="interview_time" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="interview_duration">Duration (minutes)</label>
                                <input type="number" id="interview_duration" name="interview_duration" class="form-control" required min="15" step="15" value="60">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="interview_location">Location</label>
                            <input type="text" id="interview_location" name="interview_location" class="form-control" required placeholder="e.g. Conference Room A">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="interviewer_id">Interviewer</label>
                                <select id="interviewer_id" name="interviewer_id" class="form-control" required>
                                    <option value="">Select Interviewer</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="interview_type">Interview Type</label>
                                <select id="interview_type" name="interview_type" class="form-control" required>
                                    <option value="in-person">In-person</option>
                                    <option value="phone">Phone</option>
                                    <option value="video">Video</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="notes">Notes</label>
                            <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="Additional notes for the interview..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline" id="cancelInterview">
                        <i class="fas fa-times" aria-hidden="true"></i> Cancel
                    </button>
                    <button class="btn btn-primary" id="saveInterview">
                        <i class="fas fa-calendar-check" aria-hidden="true"></i> Schedule
                    </button>
                </div>
            </div>
        `;
        
        // Add dialog to DOM
        document.body.appendChild(dialog);
        document.body.style.overflow = 'hidden';
        
        // Add event listeners
        const closeButton = dialog.querySelector('.close-modal');
        const cancelButton = dialog.querySelector('#cancelInterview');
        const saveButton = dialog.querySelector('#saveInterview');
        
        closeButton.addEventListener('click', function() {
            closeInterviewDialog(dialog);
        });
        
        cancelButton.addEventListener('click', function() {
            closeInterviewDialog(dialog);
        });
        
        saveButton.addEventListener('click', function() {
            const form = dialog.querySelector('#interviewForm');
            
            // Validate form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            // Get form data
            const formData = new FormData(form);
            const data = {};
            
            formData.forEach((value, key) => {
                data[key] = value;
            });
            
            console.log(data);
            fetch('/recruitment/interviews', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    // Close dialog
                    closeInterviewDialog(dialog);
                    
                    // Update application status
                    updateApplicationStatus(applicationId, 'interview', false);
                    
                    showNotification('Interview scheduled successfully', 'success');
                    
                    // Switch to interviews tab
                    document.querySelector('[data-tab="interviews"]').click();
                } else {
                    showNotification(data.message || 'Error scheduling interview', 'error');
                }
            })
            .catch(error => {
                console.error('Error scheduling interview:', error);
                showNotification('Error scheduling interview', 'error');
            });
        });
        
        // Close dialog when clicking outside
        dialog.addEventListener('click', function(e) {
            if (e.target === dialog) {
                closeInterviewDialog(dialog);
            }
        });

        populateHrInterviewersDropdown();
    }
    
    // Close interview dialog
    function closeInterviewDialog(dialog) {
        dialog.classList.remove('active');
        
        setTimeout(() => {
            dialog.remove();
            document.body.style.overflow = '';
        }, 300);
    }
    
    // Update application status
    function updateApplicationStatus(applicationId, status, showNotifications = true) {
        fetch(`/recruitment/applications/${applicationId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update status badge in table
                const statusBadge = document.querySelector(`.applications-table tr[data-id="${applicationId}"] .status-badge`);
                
                if (statusBadge) {
                    statusBadge.className = `status-badge status-${status}`;
                    statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                }
                
                // Update status badge in modal
                const modalStatusBadge = document.querySelector('#viewApplicationModal .status-badge');
                
                if (modalStatusBadge) {
                    modalStatusBadge.className = `status-badge status-${status}`;
                    modalStatusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                }
                
                // Update status selector in modal
                const statusSelector = document.querySelector('#viewApplicationModal .status-selector select');
                
                if (statusSelector) {
                    statusSelector.value = status;
                }
                
                if (showNotifications) {
                    showNotification(`Application status updated to ${status}`, 'success');
                }
            } else {
                if (showNotifications) {
                    showNotification(data.message || 'Error updating application status', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error updating application status:', error);
            if (showNotifications) {
                showNotification('Error updating application status', 'error');
            }
        });
    }
    
    // Initialize interview actions
    function initInterviewActions() {
        // Calendar day click (event delegation, only add once)
        const calendarGrid = document.querySelector('.calendar-grid');
        if (calendarGrid && !calendarGrid.dataset.listenerAdded) {
            calendarGrid.addEventListener('click', function(e) {
                const day = e.target.closest('.calendar-day');
                if (!day || day.classList.contains('inactive')) return;

                const date = day.getAttribute('data-date');
                if (day.classList.contains('has-events')) {
                    fetch(`/recruitment/interviews/date/${date}`)
                        .then(response => response.json())
                        .then(data => {
                            updateInterviewsList(data.interviews);
                        })
                        .catch(error => {
                            console.error('Error fetching interviews:', error);
                            showNotification('Error fetching interviews', 'error');
                        });
                } else {
                    document.querySelector('.interview-list').innerHTML = '<p>No interviews scheduled for this date.</p>';
                }
            });
            calendarGrid.dataset.listenerAdded = 'true';
        }

        // Calendar navigation
        const calendarNavButtons = document.querySelectorAll('.calendar-nav-btn');
        calendarNavButtons.forEach(button => {
            button.addEventListener('click', function() {
                const direction = this.querySelector('i').classList.contains('fa-chevron-left') ? 'prev' : 'next';
                const currentMonth = document.querySelector('.calendar-header h4').textContent;
                const [month, year] = currentMonth.split(' ');
                const date = new Date(`${month} 1, ${year}`);
                if (direction === 'prev') {
                    date.setMonth(date.getMonth() - 1);
                } else {
                    date.setMonth(date.getMonth() + 1);
                }
                fetch(`/recruitment/calendar/${date.getFullYear()}/${date.getMonth() + 1}`)
                    .then(response => response.json())
                    .then(data => {
                        updateCalendar(data.calendarDays, data.currentMonth);
                    })
                    .catch(error => {
                        console.error('Error fetching calendar:', error);
                        showNotification('Error fetching calendar', 'error');
                    });
            });
        });

        // Edit interview
        const editInterviewButtons = document.querySelectorAll('.interview-actions .btn:first-child');
        editInterviewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const interviewCard = this.closest('.interview-card');
                const interviewId = interviewCard.getAttribute('data-id');
                fetch(`/recruitment/interviews/${interviewId}`)
                    .then(response => response.json())
                    .then(data => {
                        createEditInterviewDialog(data.interview);
                    })
                    .catch(error => {
                        console.error('Error fetching interview:', error);
                        showNotification('Error fetching interview data', 'error');
                    });
            });
        });

        // Cancel interview
        const cancelInterviewButtons = document.querySelectorAll('.interview-actions .btn:last-child');
        cancelInterviewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const interviewCard = this.closest('.interview-card');
                const interviewId = interviewCard.getAttribute('data-id');
                if (confirm('Are you sure you want to cancel this interview?')) {
                    fetch(`/recruitment/interviews/${interviewId}/cancel`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            interviewCard.remove();
                            showNotification('Interview cancelled successfully', 'success');
                        } else {
                            showNotification(data.message || 'Error cancelling interview', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error cancelling interview:', error);
                        showNotification('Error cancelling interview', 'error');
                    });
                }
            });
        });
    }
    
    // Update interviews list
    function updateInterviewsList(interviews) {
        const interviewList = document.querySelector('.interview-list');
        
        if (interviews.length === 0) {
            interviewList.innerHTML = '<p>No interviews scheduled for this date.</p>';
            return;
        }
        
        let html = '';
        
        interviews.forEach(interview => {
            const interviewDate = new Date(interview.interview_date);
            const day = interviewDate.getDate();
            const month = interviewDate.toLocaleString('default', { month: 'short' });
            const startTime = interview.start_time ? interview.start_time.substring(0,5) : '';
            const endTime = interview.end_time ? interview.end_time.substring(0,5) : '';
            const interviewerName = interview.interviewer ? `${interview.interviewer.first_name} ${interview.interviewer.last_name}` : 'Not assigned';
            const jobPosting = interview.application && interview.application.job_posting;
            const positionName = jobPosting && jobPosting.position ? jobPosting.position.position_name : 'N/A';
            html += `
                <div class="interview-card" data-id="${interview.id}">
                    <div class="interview-date">
                        <div class="date-day">${day}</div>
                        <div class="date-month">${month}</div>
                    </div>
                    <div class="interview-details">
                        <div class="interview-title">${interview.application.applicant.first_name} ${interview.application.applicant.last_name} - ${positionName}</div>
                        <div class="interview-meta">
                            <span><i class="fas fa-clock" aria-hidden="true"></i> ${startTime} - ${endTime}</span>
                            <span><i class="fas fa-map-marker-alt" aria-hidden="true"></i> ${interview.location}</span>
                            <span><i class="fas fa-user" aria-hidden="true"></i> ${interviewerName}</span>
                        </div>
                    </div>
                    <div class="interview-actions">
                        <button class="btn btn-outline">
                            <i class="fas fa-edit" aria-hidden="true"></i> Edit
                        </button>
                        <button class="btn btn-outline">
                            <i class="fas fa-times" aria-hidden="true"></i> Cancel
                        </button>
                    </div>
                </div>
            `;
        });
        
        interviewList.innerHTML = html;
    }
    
    // Update calendar
    function updateCalendar(calendarDays, currentMonth) {
        // Update month title
        document.querySelector('.calendar-header h4').textContent = currentMonth;
        
        // Update calendar days
        const calendarGrid = document.querySelector('.calendar-grid');
        const dayHeaders = calendarGrid.querySelectorAll('.calendar-day-header');
        
        // Remove existing days
        const existingDays = calendarGrid.querySelectorAll('.calendar-day');
        existingDays.forEach(day => day.remove());
        
        // Add new days
        calendarDays.forEach(day => {
            const dayElement = document.createElement('div');
            dayElement.className = `calendar-day${day.isCurrentMonth ? '' : ' inactive'}${day.hasEvents ? ' has-events' : ''}`;
            dayElement.textContent = day.day;
            dayElement.setAttribute('data-date', day.date);
            
            if (day.hasEvents) {
                const eventIndicator = document.createElement('div');
                eventIndicator.className = 'event-indicator';
                eventIndicator.setAttribute('data-count', day.eventCount);
                dayElement.appendChild(eventIndicator);
            }
            
            calendarGrid.appendChild(dayElement);
        });
    }
    
    // Create edit interview dialog
    function createEditInterviewDialog(interview) {
        // Create dialog
        const dialog = document.createElement('div');
        dialog.className = 'modal active';
        dialog.style.display = 'flex';
        
        const interviewDate = new Date(interview.interview_date);
        const dateString = interviewDate.toISOString().split('T')[0];
        const timeString = interviewDate.toTimeString().split(' ')[0].substring(0, 5);
        
        dialog.innerHTML = `
            <div class="modal-content modal-sm">
                <div class="modal-header">
                    <h3><i class="fas fa-edit" aria-hidden="true"></i> Edit Interview</h3>
                    <button class="close-modal" aria-label="Close modal">
                        <i class="fas fa-times" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editInterviewForm">
                        <input type="hidden" name="interview_id" value="${interview.id}">
                        
                        <div class="form-group">
                            <label class="form-label" for="edit_interview_date">Interview Date</label>
                            <input type="date" id="edit_interview_date" name="interview_date" class="form-control" required value="${dateString}">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="edit_interview_time">Interview Time</label>
                                <input type="time" id="edit_interview_time" name="interview_time" class="form-control" required value="${timeString}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="edit_interview_duration">Duration (minutes)</label>
                                <input type="number" id="edit_interview_duration" name="interview_duration" class="form-control" required min="15" step="15" value="${interview.duration_minutes}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="edit_interview_location">Location</label>
                            <input type="text" id="edit_interview_location" name="interview_location" class="form-control" required value="${interview.location}">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="edit_interviewer_id">Interviewer</label>
                                <select id="edit_interviewer_id" name="interviewer_id" class="form-control" required>
                                    <option value="">Select Interviewer</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="edit_interview_type">Interview Type</label>
                                <select id="edit_interview_type" name="interview_type" class="form-control" required>
                                    <option value="in-person" ${interview.interview_type === 'in-person' ? 'selected' : ''}>In-person</option>
                                    <option value="phone" ${interview.interview_type === 'phone' ? 'selected' : ''}>Phone</option>
                                    <option value="video" ${interview.interview_type === 'video' ? 'selected' : ''}>Video</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="edit_status">Status</label>
                                <select id="edit_status" name="status" class="form-control" required>
                                    <option value="scheduled" ${interview.status === 'scheduled' ? 'selected' : ''}>Scheduled</option>
                                    <option value="completed" ${interview.status === 'completed' ? 'selected' : ''}>Completed</option>
                                    <option value="cancelled" ${interview.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="edit_notes">Notes</label>
                            <textarea id="edit_notes" name="notes" class="form-control" rows="3">${interview.notes || ''}</textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline" id="cancelEditInterview">
                        <i class="fas fa-times" aria-hidden="true"></i> Cancel
                    </button>
                    <button class="btn btn-primary" id="saveEditInterview">
                        <i class="fas fa-save" aria-hidden="true"></i> Save Changes
                    </button>
                </div>
            </div>
        `;
        
        // Add dialog to DOM
        document.body.appendChild(dialog);
        document.body.style.overflow = 'hidden';
        
        // Add event listeners
        const closeButton = dialog.querySelector('.close-modal');
        const cancelButton = dialog.querySelector('#cancelEditInterview');
        const saveButton = dialog.querySelector('#saveEditInterview');
        
        closeButton.addEventListener('click', function() {
            closeInterviewDialog(dialog);
        });
        
        cancelButton.addEventListener('click', function() {
            closeInterviewDialog(dialog);
        });
        
        saveButton.addEventListener('click', function() {
            const form = dialog.querySelector('#editInterviewForm');
            
            // Validate form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            // Get form data
            const formData = new FormData(form);
            const data = {};
            
            formData.forEach((value, key) => {
                data[key] = value;
            });
            
            // Update interview
            fetch(`/recruitment/interviews/${interview.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close dialog
                    closeInterviewDialog(dialog);
                    
                    showNotification('Interview updated successfully', 'success');
                    
                    // Refresh interviews list
                    const date = new Date(interview.interview_date).toISOString().split('T')[0];
                    
                    fetch(`/recruitment/interviews/date/${date}`)
                        .then(response => response.json())
                        .then(data => {
                            updateInterviewsList(data.interviews);
                        })
                        .catch(error => {
                            console.error('Error fetching interviews:', error);
                        });
                } else {
                    showNotification(data.message || 'Error updating interview', 'error');
                }
            })
            .catch(error => {
                console.error('Error updating interview:', error);
                showNotification('Error updating interview', 'error');
            });
        });
        
        // Close dialog when clicking outside
        dialog.addEventListener('click', function(e) {
            if (e.target === dialog) {
                closeInterviewDialog(dialog);
            }
        });

        populateHrInterviewersDropdown();
    }
    
    // Initialize calendar
    function initCalendar() {
        // This function will be called when the calendar tab is initialized
        console.log('Calendar initialized');
    }
    
    // Initialize reports
    function initReports() {
        // Date range picker
        const dateInputs = document.querySelectorAll('.date-range-picker input');
        const applyButton = document.querySelector('.date-range-picker button');
        
        if (applyButton) {
            applyButton.addEventListener('click', function() {
                const startDate = dateInputs[0].value;
                const endDate = dateInputs[1].value;
                
                // Fetch report data
                fetch(`/recruitment/reports?start_date=${startDate}&end_date=${endDate}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update charts
                            updateCharts(data.data);
                        } else {
                            showNotification('Error fetching report data', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching report data:', error);
                        showNotification('Error fetching report data', 'error');
                    });
            });
        }
        
        // Export button
        const exportButton = document.querySelector('.tab-actions .btn-outline');
        
        if (exportButton) {
            exportButton.addEventListener('click', function() {
                const startDate = dateInputs[0].value;
                const endDate = dateInputs[1].value;
                
                // Export report
                window.location.href = `/recruitment/reports/export?start_date=${startDate}&end_date=${endDate}`;
            });
        }
    }
    
    // Update charts
    function updateCharts(data) {
        // This would use a charting library like Chart.js to update the charts
        console.log('Updating charts with data:', data);
        
        // Update summary statistics
        const summaryItems = document.querySelectorAll('.summary-item .summary-value');
        
        summaryItems[0].textContent = data.summary.totalApplications;
        summaryItems[1].textContent = Math.round(data.summary.avgTimeToHire) + ' days';
        summaryItems[2].textContent = data.summary.acceptanceRate + '%';
        summaryItems[3].textContent = '$' + data.summary.costPerHire;
    }
    
    // Initialize form submission
    function initFormSubmission() {
        // Position form
        const savePositionButton = document.getElementById('savePosition');
        
        if (savePositionButton) {
            savePositionButton.addEventListener('click', function() {
                const form = document.getElementById('positionForm');
                
                // Validate form
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }
                
                // Get form data
                const formData = new FormData(form);
                
                // Add CSRF token
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                
                // Check if editing or creating
                const positionIdInput = form.querySelector('input[name="position_id"]');
                const isEditing = positionIdInput !== null;
                
                let url = '/recruitment/positions';
                let method = 'POST';
                
                if (isEditing) {
                    url += `/${positionIdInput.value}`;
                    method = 'PUT';
                    formData.append('_method', 'PUT');
                }
                
                // Submit form
                fetch(url, {
                    method: method,
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close modal
                        closeModal(addPositionModal);
                        
                        showNotification(isEditing ? 'Position updated successfully' : 'Position created successfully', 'success');

                        // Add the new position card to the grid (if not editing)
                        if (!isEditing) {
                            const position = data.jobPosting;
                            // You may need to fetch department name and position name if not included in response
                            // For now, let's assume you have a JS function getPositionNameById and getDepartmentNameById
                            const positionName = getPositionNameById(position.position_id);
                            const departmentName = getDepartmentNameById(position.department_id);

                            const card = document.createElement('div');
                            card.className = 'position-card';
                            card.innerHTML = `
                                <div class="position-header">
                                    <span class="department-badge dept-${departmentName.toLowerCase()}">${departmentName}</span>
                                    <div class="position-actions">
                                        <button class="btn-icon edit-position" data-id="${position.id}" title="Edit Position">
                                            <i class="fas fa-edit" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn-icon delete-position" data-id="${position.id}" title="Delete Position">
                                            <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <h4 class="position-title">${positionName}</h4>
                                <div class="position-meta">
                                    <span><i class="fas fa-map-marker-alt" aria-hidden="true"></i> ${position.location}</span>
                                    <span><i class="fas fa-clock" aria-hidden="true"></i> ${position.employment_type}</span>
                                </div>
                                <p class="position-description">
                                    ${position.description.substring(0, 150)}
                                </p>
                                <div class="position-stats">
                                    <div class="stat">
                                        <span class="stat-value">0</span>
                                        <span class="stat-label">Applicants</span>
                                    </div>
                                    <div class="stat">
                                        <span class="stat-value">0</span>
                                        <span class="stat-label">Interviews</span>
                                    </div>
                                    <div class="stat">
                                        <span class="stat-value">${position.application_deadline}</span>
                                        <span class="stat-label">Deadline</span>
                                    </div>
                                </div>
                                <div class="position-footer">
                                    <button class="btn btn-outline view-applicants" data-id="${position.id}">
                                        <i class="fas fa-users" aria-hidden="true"></i> View Applicants
                                    </button>
                                    <button class="btn btn-primary">
                                        <i class="fas fa-share-alt" aria-hidden="true"></i> Share
                                    </button>
                                </div>
                            `;
                            document.querySelector('.positions-grid').prepend(card);
                            // Optionally, re-initialize event listeners for new buttons
                            initPositionActions();
                        }

                        // Reset the form
                        document.getElementById('positionForm').reset();
                    } else {
                        showNotification(data.message || 'Error saving position', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error saving position:', error);
                    showNotification('Error saving position', 'error');
                });
            });
        }
    }
    
    // Notification function
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-icon">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'info' ? 'info-circle' : type === 'warning' ? 'exclamation-triangle' : 'exclamation-circle'}"></i>
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

    // Helper functions
    function getPositionNameById(id) {
        const select = document.getElementById('positionTitle');
        const option = select.querySelector(`option[value="${id}"]`);
        return option ? option.textContent : '';
    }

    function getDepartmentNameById(id) {
        const select = document.getElementById('department');
        const option = select.querySelector(`option[value="${id}"]`);
        return option ? option.textContent : '';
    }

    function populateHrInterviewersDropdown() {
        const interviewerSelect = document.getElementById('interviewer_id');
        if (!interviewerSelect) return;

        // Clear current options
        interviewerSelect.innerHTML = '<option value="">Select Interviewer</option>';

        fetch('/api/recruitment/hr-interviewers')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                data.employees.forEach(emp => {
                    const option = document.createElement('option');
                    option.value = emp.id;
                    option.textContent = emp.first_name + ' ' + emp.last_name;
                    interviewerSelect.appendChild(option);
                });
            })
            .catch(() => {
                interviewerSelect.innerHTML = '<option value=\"\">No HR Interviewers Found</option>';
            });
    }

    // Call this function after the modal is shown and the select exists in the DOM
    // For example, after you insert the modal HTML:
    setTimeout(populateHrInterviewersDropdown, 100); // or call directly if you know the select is present
});