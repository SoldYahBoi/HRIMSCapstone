document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips for action buttons
    const tooltips = document.querySelectorAll('[title]');
    tooltips.forEach(tooltip => {
        new bootstrap.Tooltip(tooltip);
    });

    // Add click handlers for view profile and edit buttons
    document.querySelectorAll('.btn-icon').forEach(button => {
        button.addEventListener('click', function() {
            const action = this.getAttribute('title').toLowerCase();
            const row = this.closest('tr');
            const employeeName = row.querySelector('.employee-name').textContent;
            
            if (action.includes('view')) {
                // Handle view profile action
                console.log(`Viewing profile for ${employeeName}`);
                // Add your view profile logic here
            } else if (action.includes('edit')) {
                // Handle edit action
                console.log(`Editing profile for ${employeeName}`);
                // Add your edit profile logic here
            }
        });
    });

    // Add animation to stats cards on hover
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('pulse');
        });
        card.addEventListener('mouseleave', function() {
            this.classList.remove('pulse');
        });
    });

    // Add click handler for department filter
    const filterBtn = document.querySelector('.card-actions .btn-outline');
    if (filterBtn) {
        filterBtn.addEventListener('click', function() {
            // Add your department filter logic here
            console.log('Filtering departments');
        });
    }

    // Add click handler for download button
    const downloadBtn = document.querySelectorAll('.card-actions .btn-outline')[1];
    if (downloadBtn) {
        downloadBtn.addEventListener('click', function() {
            // Add your download logic here
            console.log('Downloading department data');
        });
    }

    // Add click handler for send reminders button
    const reminderBtn = document.querySelector('.compliance-status .btn-outline');
    if (reminderBtn) {
        reminderBtn.addEventListener('click', function() {
            // Add your reminder logic here
            console.log('Sending compliance reminders');
        });
    }
}); 