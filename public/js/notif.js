/**
 * Success Notification System
 * Handles showing and hiding success notification popups
 */

class SuccessNotification {
    constructor(duration = 5000) {
        this.duration = duration;
        this.activeNotifications = [];
        this.initialize();
    }

    initialize() {
        document.addEventListener('DOMContentLoaded', () => {
            // Check for success message on page load
            this.checkForSuccessMessage();
        });
    }

    checkForSuccessMessage() {
        const successPopup = document.querySelector('.success-popup');
        if (successPopup) {
            this.showNotification(successPopup);
        }
    }

    showNotification(element) {
        if (!element) return;

        // Create the inner structure if it doesn't exist
        if (!element.querySelector('.success-popup-content')) {
            this.buildNotificationStructure(element);
        }

        // Add to active notifications
        this.activeNotifications.push(element);

        // Show the notification
        setTimeout(() => {
            element.classList.add('show');
        }, 100);

        // Start the progress bar animation
        const progressBar = element.querySelector('.success-popup-progress-bar');
        if (progressBar) {
            progressBar.style.animation = `progress ${this.duration / 1000}s linear forwards`;
        }

        // Set timeout to hide notification
        const timeoutId = setTimeout(() => {
            this.hideNotification(element);
        }, this.duration);

        // Store the timeout ID on the element
        element.dataset.timeoutId = timeoutId;

        // Add event listeners for close button
        const closeButton = element.querySelector('.success-popup-close');
        if (closeButton) {
            closeButton.addEventListener('click', () => {
                this.hideNotification(element);
            });
        }
    }

    hideNotification(element) {
        if (!element) return;

        // Clear the timeout if it exists
        if (element.dataset.timeoutId) {
            clearTimeout(parseInt(element.dataset.timeoutId));
        }

        // Remove the show class to trigger the exit animation
        element.classList.remove('show');

        // Remove from active notifications
        this.activeNotifications = this.activeNotifications.filter(item => item !== element);

        // Remove the element after animation completes
        setTimeout(() => {
            if (element.parentNode) {
                element.parentNode.removeChild(element);
            }
        }, 400); // Match this with the CSS transition duration
    }

    buildNotificationStructure(element) {
        const message = element.textContent.trim();
        element.textContent = '';

        const content = document.createElement('div');
        content.className = 'success-popup-content';

        const icon = document.createElement('div');
        icon.className = 'success-popup-icon';
        icon.innerHTML = '<i class="fas fa-check-circle"></i>';

        const messageDiv = document.createElement('div');
        messageDiv.className = 'success-popup-message';
        messageDiv.textContent = message;

        const closeButton = document.createElement('button');
        closeButton.className = 'success-popup-close';
        closeButton.setAttribute('aria-label', 'Close notification');
        closeButton.innerHTML = '<i class="fas fa-times"></i>';

        content.appendChild(icon);
        content.appendChild(messageDiv);
        content.appendChild(closeButton);

        const progress = document.createElement('div');
        progress.className = 'success-popup-progress';
        
        const progressBar = document.createElement('div');
        progressBar.className = 'success-popup-progress-bar';
        
        progress.appendChild(progressBar);

        element.appendChild(content);
        element.appendChild(progress);
    }

    // Static method to create and show a notification programmatically
    static show(message, duration = 5000) {
        const notification = document.createElement('div');
        notification.className = 'success-popup';
        notification.textContent = message;
        document.body.appendChild(notification);

        const instance = new SuccessNotification(duration);
        instance.showNotification(notification);
    }
}

// Initialize the notification system
const successNotification = new SuccessNotification();

// Global function to show notifications from anywhere
function showSuccessNotification(message, duration = 5000) {
    SuccessNotification.show(message, duration);
}