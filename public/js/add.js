/**
 * Employee Form JavaScript
 * Handles dynamic form behavior and AJAX requests
 */

document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const departmentSelect = document.getElementById('department_id');
    const positionSelect = document.getElementById('position_id');
    const departmentLoader = document.getElementById('department-loader');
    const positionLoader = document.getElementById('position-loader');
    
    // Store the original positions for resetting
    const originalPositions = Array.from(positionSelect.options).map(option => {
        return {
            value: option.value,
            text: option.text,
            selected: option.selected
        };
    });
    
    /**
     * Load positions based on selected department
     */
    function loadPositions(departmentId) {
        if (!departmentId) {
            // Reset positions to original state if no department selected
            resetPositions();
            return;
        }
        
        // Show loader
        positionLoader.classList.add('active');
        positionSelect.disabled = true;
        
        // Make AJAX request
        fetch(`/api/departments/${departmentId}/positions`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                updatePositionOptions(data);
            })
            .catch(error => {
                console.error('Error loading positions:', error);
                showErrorMessage('Failed to load positions. Please try again.');
                resetPositions();
            })
            .finally(() => {
                // Hide loader
                positionLoader.classList.remove('active');
                positionSelect.disabled = false;
            });
    }
    
    /**
     * Update position select options with new data
     */
    function updatePositionOptions(positions) {
        // Clear current options
        positionSelect.innerHTML = '<option value="">Select Position</option>';
        
        // Add new options
        if (positions && positions.length > 0) {
            positions.forEach(position => {
                const option = document.createElement('option');
                option.value = position.id;
                option.textContent = position.position_name;
                positionSelect.appendChild(option);
            });
        } else {
            // No positions found
            const option = document.createElement('option');
            option.value = "";
            option.textContent = "No positions available for this department";
            option.disabled = true;
            positionSelect.appendChild(option);
        }
        
        // If there was a previously selected value, try to reselect it
        const oldValue = positionSelect.getAttribute('data-old-value');
        if (oldValue) {
            const matchingOption = Array.from(positionSelect.options).find(option => option.value === oldValue);
            if (matchingOption) {
                matchingOption.selected = true;
            }
        }
    }
    
    /**
     * Reset positions to original state
     */
    function resetPositions() {
        positionSelect.innerHTML = '';
        originalPositions.forEach(position => {
            const option = document.createElement('option');
            option.value = position.value;
            option.textContent = position.text;
            option.selected = position.selected;
            positionSelect.appendChild(option);
        });
    }
    
    /**
     * Show error message
     */
    function showErrorMessage(message) {
        // Create error element
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger mt-2';
        errorDiv.textContent = message;
        
        // Insert after position select
        positionSelect.parentNode.insertBefore(errorDiv, positionSelect.nextSibling);
        
        // Remove after 5 seconds
        setTimeout(() => {
            errorDiv.remove();
        }, 5000);
    }
    
    /**
     * Store the current position value as a data attribute
     */
    function storeCurrentPositionValue() {
        if (positionSelect.value) {
            positionSelect.setAttribute('data-old-value', positionSelect.value);
        }
    }
    
    // Event Listeners
    if (departmentSelect && positionSelect) {
        // When department changes, load positions
        departmentSelect.addEventListener('change', function() {
            storeCurrentPositionValue();
            loadPositions(this.value);
        });
        
        // If department already has a value on page load, load positions
        if (departmentSelect.value) {
            storeCurrentPositionValue();
            loadPositions(departmentSelect.value);
        }
    }
    
    // Form validation enhancement
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(event) {
            // Check if required fields are filled
            const requiredFields = form.querySelectorAll('[required]');
            let hasError = false;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    hasError = true;
                    
                    // Add error message if not already present
                    const errorMessage = field.parentNode.querySelector('.text-danger');
                    if (!errorMessage) {
                        const label = field.parentNode.querySelector('label');
                        const fieldName = label ? label.textContent : 'This field';
                        
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'text-danger';
                        errorDiv.textContent = `${fieldName} is required.`;
                        field.parentNode.appendChild(errorDiv);
                    }
                } else {
                    field.classList.remove('is-invalid');
                    
                    // Remove error message if present
                    const errorMessage = field.parentNode.querySelector('.text-danger');
                    if (errorMessage) {
                        errorMessage.remove();
                    }
                }
            });
            
            if (hasError) {
                event.preventDefault();
                
                // Scroll to first error
                const firstError = form.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        });
    }
    
    // Initialize any date pickers or other form enhancements
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        // You could initialize a date picker library here if needed
        // For now, we'll just ensure the input has a default value if empty
        if (!input.value && input.id === 'hire_date') {
            const today = new Date().toISOString().split('T')[0];
            input.value = today;
        }
    });
});
