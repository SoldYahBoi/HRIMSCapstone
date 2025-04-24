/**
 * Employee View
 * Handles tab switching and animations for the employee details page
 */

document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    /**
     * Initialize the view functionality
     */
    function init() {
        // Add event listeners for tab switching
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabName = this.getAttribute('data-tab');
                switchTab(tabName);
            });
        });
        
        // Add animation classes to elements
        animateContent();
    }
    
    /**
     * Switch between tabs
     */
    function switchTab(tabName) {
        // Remove active class from all tabs
        tabButtons.forEach(button => {
            button.classList.remove('active');
        });
        
        tabContents.forEach(content => {
            content.classList.remove('active');
        });
        
        // Add active class to selected tab
        const selectedButton = document.querySelector(`.tab-button[data-tab="${tabName}"]`);
        const selectedContent = document.getElementById(`${tabName}-tab`);
        
        if (selectedButton) {
            selectedButton.classList.add('active');
        }
        
        if (selectedContent) {
            selectedContent.classList.add('active');
        }
    }
    
    /**
     * Add animation classes to elements
     */
    function animateContent() {
        // Add staggered animation to info items
        const infoItems = document.querySelectorAll('.info-item');
        
        infoItems.forEach((item, index) => {
            item.style.animationDelay = `${index * 0.05}s`;
            item.style.animationName = 'slideIn';
            item.style.animationDuration = '0.3s';
            item.style.animationFillMode = 'both';
        });
    }
    
    // Initialize the module
    init();
});