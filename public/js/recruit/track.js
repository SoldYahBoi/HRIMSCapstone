document.addEventListener('DOMContentLoaded', function() {
    const trackForm = document.getElementById('trackApplicationForm');
    const applicationStatus = document.getElementById('applicationStatus');
    const errorMessage = document.getElementById('errorMessage');
    const applicationCodeError = document.getElementById('applicationCodeError');

    trackForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset previous states
        applicationStatus.style.display = 'none';
        errorMessage.style.display = 'none';
        applicationCodeError.textContent = '';

        const applicationCode = document.getElementById('application_code').value.trim();

        if (!applicationCode) {
            applicationCodeError.textContent = 'Please enter your application code';
            return;
        }

        // Show loading state
        const submitButton = trackForm.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.textContent = 'Checking...';

        // Make API request
        fetch(`/api/recruitment/track/${applicationCode}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayApplicationStatus(data.application);
                } else {
                    displayError(data.message || 'Application not found');
                }
            })
            .catch(error => {
                displayError('An error occurred while checking your application status');
                console.error('Error:', error);
            })
            .finally(() => {
                // Reset button state
                submitButton.disabled = false;
                submitButton.textContent = originalButtonText;
            });
    });

    function displayApplicationStatus(application) {
        // Update status badge
        const statusBadge = document.getElementById('statusBadge');
        statusBadge.textContent = application.status.charAt(0).toUpperCase() + application.status.slice(1);
        statusBadge.className = `status-badge ${application.status}`;

        // Update application details
        document.getElementById('statusApplicationCode').textContent = application.application_code;
        document.getElementById('statusPosition').textContent = application.job_posting.position.position_name;
        document.getElementById('statusDepartment').textContent = application.job_posting.department.department_name;
        document.getElementById('statusAppliedDate').textContent = formatDate(application.applied_date);
        document.getElementById('statusLastUpdated').textContent = formatDate(application.updated_at);

        // Update timeline
        const timeline = document.getElementById('statusTimeline');
        timeline.innerHTML = generateTimeline(application);

        // Show status section
        applicationStatus.style.display = 'block';
    }

    function displayError(message) {
        const errorText = document.getElementById('errorText');
        errorText.textContent = message;
        errorMessage.style.display = 'flex';
    }

    function formatDate(dateString) {
        const options = { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        return new Date(dateString).toLocaleDateString('en-US', options);
    }

    function generateTimeline(application) {
        const timeline = [];
        
        // Application submitted
        timeline.push({
            date: application.applied_date,
            content: 'Application submitted'
        });

        // Application reviewed
        if (application.reviewed_date) {
            timeline.push({
                date: application.reviewed_date,
                content: 'Application under review'
            });
        }

        // Interview scheduled
        if (application.interviews && application.interviews.length > 0) {
            application.interviews.forEach(interview => {
                timeline.push({
                    date: interview.interview_date,
                    content: `Interview scheduled for ${formatDate(interview.interview_date)}`
                });
            });
        }

        // Status changes
        if (application.status === 'hired') {
            timeline.push({
                date: application.updated_at,
                content: 'Application accepted'
            });
        } else if (application.status === 'rejected') {
            timeline.push({
                date: application.updated_at,
                content: 'Application not selected'
            });
        }

        // Sort timeline by date
        timeline.sort((a, b) => new Date(a.date) - new Date(b.date));

        // Generate HTML
        return timeline.map(item => `
            <div class="timeline-item">
                <div class="timeline-date">${formatDate(item.date)}</div>
                <div class="timeline-content">${item.content}</div>
            </div>
        `).join('');
    }
});
