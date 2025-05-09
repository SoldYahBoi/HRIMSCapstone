document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Update active tab button
            tabButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Update active tab content
            tabContents.forEach(content => content.classList.remove('active'));
            document.getElementById(`${tabId}-tab`).classList.add('active');
            
            // Reinitialize dropdowns when switching tabs
            setTimeout(() => {
                setupProvinceRelationships();
            }, 100);
        });
    });
    
    // Initialize all dropdowns and relationships
    initializeAllDropdowns();
    
    // Handle conditional fields visibility
    handleConditionalFields();
    
    // Handle form reset
    document.getElementById('resetBtn').addEventListener('click', function() {
        document.getElementById('birthCertificateForm').reset();
        handleConditionalFields(); // Reset conditional fields visibility
    });
    
    // Form validation before submission
    document.getElementById('birthCertificateForm').addEventListener('submit', function(event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });
    
    // Birth Attendant Type change event
    document.getElementById('birth_attendant_attendant_type').addEventListener('change', function() {
        const otherAttendantField = document.getElementById('other_attendant_type_field');
        const otherAttendantInput = document.getElementById('birth_attendant_other_attendant_type');
        
        if (this.value === '5') { // Other
            otherAttendantField.style.display = 'block';
            otherAttendantInput.setAttribute('required', 'required');
        } else {
            otherAttendantField.style.display = 'none';
            otherAttendantInput.removeAttribute('required');
            otherAttendantInput.value = '';
        }
    });
    
    // Child Type of Birth change event
    document.getElementById('child_type_of_birth').addEventListener('change', function() {
        const multipleBirthFields = document.querySelectorAll('.multiple-birth-field');
        
        if (this.value !== 'Single') {
            multipleBirthFields.forEach(field => field.style.display = 'block');
            document.getElementById('child_is_multiple_birth').value = '1'; // Set to yes for multiple births
        } else {
            multipleBirthFields.forEach(field => field.style.display = 'none');
            document.getElementById('child_is_multiple_birth').value = '0'; // Set to no for single births
            document.getElementById('child_multiple_birth_type').value = ''; // Clear the value
        }
    });
    
    // Toggle Father information
    document.getElementById('include_father').addEventListener('change', function() {
        const fatherFields = document.getElementById('father_information_fields');
        
        if (this.checked) {
            fatherFields.style.display = 'block';
            enableRequiredFields('father_information_fields');
        } else {
            fatherFields.style.display = 'none';
            disableRequiredFields('father_information_fields');
        }
    });
    
    // Toggle Marriage information
    document.getElementById('parents_married').addEventListener('change', function() {
        const marriageFields = document.getElementById('marriage_information_fields');
        
        if (this.checked) {
            marriageFields.style.display = 'block';
        } else {
            marriageFields.style.display = 'none';
            // Clear marriage fields
            document.getElementById('marriage_date').value = '';
            document.getElementById('marriage_place_country_id').value = '';
            document.getElementById('marriage_place_province_id').value = '';
            document.getElementById('marriage_place_city_municipality_id').value = '';
        }
    });
    
    // Copy mother's address to father's
    document.getElementById('same_as_mother_address').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('father_residence_house_no').value = document.getElementById('mother_residence_house_no').value;
            document.getElementById('father_residence_street').value = document.getElementById('mother_residence_street').value;
            document.getElementById('father_residence_barangay').value = document.getElementById('mother_residence_barangay').value;
            document.getElementById('father_residence_country_id').value = document.getElementById('mother_residence_country_id').value;
            
            // Trigger change event to load provinces
            const event = new Event('change');
            document.getElementById('father_residence_country_id').dispatchEvent(event);
            
            // We'll set the province and city after their options are loaded
            setTimeout(() => {
                document.getElementById('father_residence_province_id').value = document.getElementById('mother_residence_province_id').value;
                
                // Trigger change event to load cities
                const provinceEvent = new Event('change');
                document.getElementById('father_residence_province_id').dispatchEvent(provinceEvent);
                
                // Set city after cities are loaded
                setTimeout(() => {
                    document.getElementById('father_residence_city_municipality_id').value = document.getElementById('mother_residence_city_municipality_id').value;
                }, 500);
            }, 500);
            
            // Disable father's address fields
            const fatherAddressFields = document.querySelectorAll('#father_address_fields input, #father_address_fields select');
            fatherAddressFields.forEach(field => field.setAttribute('readonly', 'readonly'));
        } else {
            // Enable father's address fields
            const fatherAddressFields = document.querySelectorAll('#father_address_fields input, #father_address_fields select');
            fatherAddressFields.forEach(field => field.removeAttribute('readonly'));
        }
    });
    
    // Death Certificate Form Initialization
    if (document.getElementById('deathCertificateForm')) {
        // Handle form reset for death certificate
        document.getElementById('resetDeathBtn').addEventListener('click', function() {
            document.getElementById('deathCertificateForm').reset();
            handleDeathCertificateConditionalFields();
        });
        
        // Form validation before submission for death certificate
        document.getElementById('deathCertificateForm').addEventListener('submit', function(event) {
            if (!validateDeathCertificateForm()) {
                event.preventDefault();
            }
        });
        
        // Death Attendant Type change event
        document.getElementById('death_attendant_attendant_type').addEventListener('change', function() {
            const otherAttendantField = document.getElementById('death_other_attendant_type_field');
            const otherAttendantInput = document.getElementById('death_attendant_other_attendant_type');
            
            if (this.value === '5') { // Other
                otherAttendantField.style.display = 'block';
                otherAttendantInput.setAttribute('required', 'required');
            } else {
                otherAttendantField.style.display = 'none';
                otherAttendantInput.removeAttribute('required');
                otherAttendantInput.value = '';
            }
        });
        
        // Corpse Disposal Type change event
        document.getElementById('corpse_disposal_type').addEventListener('change', function() {
            const otherDisposalField = document.getElementById('other_disposal_type_field');
            const otherDisposalInput = document.getElementById('corpse_disposal_other_type');
            
            if (this.value === 'Other') {
                otherDisposalField.style.display = 'block';
                otherDisposalInput.setAttribute('required', 'required');
            } else {
                otherDisposalField.style.display = 'none';
                otherDisposalInput.removeAttribute('required');
                otherDisposalInput.value = '';
            }
        });
        
        // Age Category change event
        document.getElementById('deceased_age_category').addEventListener('change', function() {
            const ageFields = document.querySelectorAll('.age-field');
            ageFields.forEach(field => field.style.display = 'none');
            
            // Clear all age inputs
            document.getElementById('deceased_age_years').value = '';
            document.getElementById('deceased_age_months').value = '';
            document.getElementById('deceased_age_days').value = '';
            document.getElementById('deceased_age_hours').value = '';
            document.getElementById('deceased_age_minutes').value = '';
            
            // Show relevant age fields based on selection
            switch(this.value) {
                case 'years':
                    document.getElementById('age_years_field').style.display = 'block';
                    document.getElementById('deceased_age_years').setAttribute('required', 'required');
                    break;
                case 'months':
                    document.getElementById('age_months_field').style.display = 'block';
                    document.getElementById('deceased_age_months').setAttribute('required', 'required');
                    break;
                case 'days':
                    document.getElementById('age_days_field').style.display = 'block';
                    document.getElementById('deceased_age_days').setAttribute('required', 'required');
                    break;
                case 'hours':
                    document.getElementById('age_hours_field').style.display = 'block';
                    document.getElementById('age_minutes_field').style.display = 'block';
                    document.getElementById('deceased_age_hours').setAttribute('required', 'required');
                    document.getElementById('deceased_age_minutes').setAttribute('required', 'required');
                    break;
            }
        });
        
        // Initialize death certificate conditional fields
        handleDeathCertificateConditionalFields();
    }
});

// Initialize all dropdowns and relationships
function initializeAllDropdowns() {
    // Load countries and provinces
    loadAllCountriesAndProvinces();
    
    // Setup province-city relationships
    setupProvinceRelationships();
}

// Setup province-city relationships for both forms
function setupProvinceRelationships() {
    // Birth certificate form relationships
    if (document.getElementById('birthCertificateForm')) {
        setupDropdownRelationship('province_id', 'city_municipality_id');
        setupDropdownRelationship('child_place_of_birth_province_id', 'child_place_of_birth_city_municipality_id');
        setupDropdownRelationship('mother_residence_province_id', 'mother_residence_city_municipality_id');
        setupDropdownRelationship('father_residence_province_id', 'father_residence_city_municipality_id');
        setupDropdownRelationship('marriage_place_province_id', 'marriage_place_city_municipality_id');
    }
    
    // Death certificate form relationships
    if (document.getElementById('deathCertificateForm')) {
        setupDropdownRelationship('death_province_id', 'death_city_municipality_id');
        setupDropdownRelationship('deceased_residence_province_id', 'deceased_residence_city_municipality_id');
    }
}

// Setup relationship between province and city dropdowns
function setupDropdownRelationship(provinceSelectId, citySelectId) {
    const provinceSelect = document.getElementById(provinceSelectId);
    const citySelect = document.getElementById(citySelectId);
    
    if (!provinceSelect || !citySelect) return;
    
    // Clear existing event listeners (to prevent duplicates)
    const newProvinceSelect = provinceSelect.cloneNode(true);
    provinceSelect.parentNode.replaceChild(newProvinceSelect, provinceSelect);
    
    // Add event listener to province select
    newProvinceSelect.addEventListener('change', function() {
        const selectedProvinceId = this.value;
        if (selectedProvinceId) {
            loadCitiesForProvince(selectedProvinceId, citySelect);
        } else {
            // Clear city dropdown if no province selected
            while (citySelect.options.length > 1) {
                citySelect.remove(1);
            }
        }
    });
    
    // Initial load of cities if province is already selected
    if (newProvinceSelect.value) {
        loadCitiesForProvince(newProvinceSelect.value, citySelect);
    }
}

// Load cities for a specific province
function loadCitiesForProvince(provinceId, citySelect) {
    // Clear existing options except the first one
    while (citySelect.options.length > 1) {
        citySelect.remove(1);
    }
    
    // Sample cities data - in a real app, this would come from an AJAX call
    const cities = [
        { id: 1, name: 'San Carlos', province_id: 1, is_city: true },
        { id: 2, name: 'Urbiztondo', province_id: 1, is_city: false },
        { id: 3, name: 'Dagupan', province_id: 1, is_city: true },
        { id: 4, name: 'Lingayen', province_id: 1, is_city: false },
        { id: 5, name: 'Alaminos', province_id: 1, is_city: true }
    ];
    
    // Add filtered city options
    const filteredCities = cities.filter(city => city.province_id == provinceId);
    filteredCities.forEach(city => {
        const option = document.createElement('option');
        option.value = city.id;
        option.textContent = city.name + (city.is_city ? ' City' : '');
        citySelect.appendChild(option);
    });
}

// Load all countries and provinces
function loadAllCountriesAndProvinces() {
    // Load countries for all country dropdowns
    const countrySelects = document.querySelectorAll('select[id$="country_id"]');
    countrySelects.forEach(select => {
        loadCountriesForSelect(select);
        
        // Add event listener for country change
        select.addEventListener('change', function() {
            const countryId = this.value;
            const selectId = this.id;
            const provinceSelectId = selectId.replace('country', 'province');
            const provinceSelect = document.getElementById(provinceSelectId);
            
            if (provinceSelect) {
                loadProvincesForSelect(provinceSelect, countryId);
            }
        });
    });
    
    // Load provinces for all province dropdowns
    const provinceSelects = document.querySelectorAll('select[id$="province_id"]');
    provinceSelects.forEach(select => {
        // Get country ID if this is a province select that depends on a country
        let countryId = 1; // Default to Philippines
        const selectId = select.id;
        if (selectId.includes('residence') || selectId.includes('place')) {
            const countrySelectId = selectId.replace('province', 'country');
            const countrySelect = document.getElementById(countrySelectId);
            if (countrySelect && countrySelect.value) {
                countryId = countrySelect.value;
            }
        }
        
        loadProvincesForSelect(select, countryId);
    });
}

// Load countries for a select element
function loadCountriesForSelect(select) {
    // Clear existing options except the first one
    while (select.options.length > 1) {
        select.remove(1);
    }
    
    // Sample countries data
    const countries = [
        { id: 1, name: 'Philippines', code: 'PHL' },
        { id: 2, name: 'United States', code: 'USA' },
        { id: 3, name: 'Japan', code: 'JPN' }
    ];
    
    // Add country options
    countries.forEach(country => {
        const option = document.createElement('option');
        option.value = country.id;
        option.textContent = country.name;
        select.appendChild(option);
    });
    
    // Set Philippines as default
    select.value = '1';
}

// Load provinces for a select element
function loadProvincesForSelect(select, countryId = 1) {
    // Clear existing options except the first one
    while (select.options.length > 1) {
        select.remove(1);
    }
    
    // Sample provinces data
    const provinces = [
        { id: 1, name: 'Pangasinan', country_id: 1 },
        { id: 2, name: 'Metro Manila', country_id: 1 },
        { id: 3, name: 'Cebu', country_id: 1 },
        { id: 4, name: 'Davao', country_id: 1 },
        { id: 5, name: 'California', country_id: 2 },
        { id: 6, name: 'New York', country_id: 2 },
        { id: 7, name: 'Tokyo', country_id: 3 },
        { id: 8, name: 'Osaka', country_id: 3 }
    ];
    
    // Add filtered province options
    const filteredProvinces = provinces.filter(province => province.country_id == countryId);
    filteredProvinces.forEach(province => {
        const option = document.createElement('option');
        option.value = province.id;
        option.textContent = province.name;
        select.appendChild(option);
    });
    
    // Set first province as default
    if (filteredProvinces.length > 0) {
        select.value = filteredProvinces[0].id;
    }
    
    // Trigger change event to load cities
    select.dispatchEvent(new Event('change'));
}

// Helper functions
function handleConditionalFields() {
    // Initial setup for birth attendant type
    const attendantType = document.getElementById('birth_attendant_attendant_type');
    const otherAttendantField = document.getElementById('other_attendant_type_field');
    
    if (attendantType.value === '5') {
        otherAttendantField.style.display = 'block';
    } else {
        otherAttendantField.style.display = 'none';
    }
    
    // Initial setup for type of birth
    const typeOfBirth = document.getElementById('child_type_of_birth');
    const multipleBirthFields = document.querySelectorAll('.multiple-birth-field');
    
    if (typeOfBirth.value !== 'Single') {
        multipleBirthFields.forEach(field => field.style.display = 'block');
    } else {
        multipleBirthFields.forEach(field => field.style.display = 'none');
    }
    
    // Initial setup for father information
    const includeFather = document.getElementById('include_father');
    const fatherFields = document.getElementById('father_information_fields');
    
    if (includeFather.checked) {
        fatherFields.style.display = 'block';
    } else {
        fatherFields.style.display = 'none';
    }
    
    // Initial setup for marriage information
    const parentsMarried = document.getElementById('parents_married');
    const marriageFields = document.getElementById('marriage_information_fields');
    
    if (parentsMarried.checked) {
        marriageFields.style.display = 'block';
    } else {
        marriageFields.style.display = 'none';
    }
}

function handleDeathCertificateConditionalFields() {
    // Initial setup for death attendant type
    const deathAttendantType = document.getElementById('death_attendant_attendant_type');
    const deathOtherAttendantField = document.getElementById('death_other_attendant_type_field');
    
    if (deathAttendantType && deathAttendantType.value === '5') {
        deathOtherAttendantField.style.display = 'block';
    } else if (deathOtherAttendantField) {
        deathOtherAttendantField.style.display = 'none';
    }
    
    // Initial setup for corpse disposal type
    const disposalType = document.getElementById('corpse_disposal_type');
    const otherDisposalField = document.getElementById('other_disposal_type_field');
    
    if (disposalType && disposalType.value === 'Other') {
        otherDisposalField.style.display = 'block';
    } else if (otherDisposalField) {
        otherDisposalField.style.display = 'none';
    }
    
    // Initial setup for age category
    const ageCategory = document.getElementById('deceased_age_category');
    if (ageCategory) {
        const ageFields = document.querySelectorAll('.age-field');
        ageFields.forEach(field => field.style.display = 'none');
        
        switch(ageCategory.value) {
            case 'years':
                document.getElementById('age_years_field').style.display = 'block';
                break;
            case 'months':
                document.getElementById('age_months_field').style.display = 'block';
                break;
            case 'days':
                document.getElementById('age_days_field').style.display = 'block';
                break;
            case 'hours':
                document.getElementById('age_hours_field').style.display = 'block';
                document.getElementById('age_minutes_field').style.display = 'block';
                break;
        }
    }
}

function enableRequiredFields(containerId) {
    const container = document.getElementById(containerId);
    const requiredFields = container.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        field.setAttribute('required', 'required');
    });
}

function disableRequiredFields(containerId) {
    const container = document.getElementById(containerId);
    const requiredFields = container.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        field.removeAttribute('required');
    });
}

function validateForm() {
    let isValid = true;
    const form = document.getElementById('birthCertificateForm');
    const requiredFields = form.querySelectorAll('[required]');
    
    // Clear previous error messages
    const errorMessages = form.querySelectorAll('.error-message');
    errorMessages.forEach(message => message.remove());
    
    // Reset error class
    const formElements = form.querySelectorAll('input, select, textarea');
    formElements.forEach(element => element.classList.remove('error'));
    
    // Validate required fields
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.classList.add('error');
            
            // Add error message
            const errorMessage = document.createElement('span');
            errorMessage.classList.add('error-message');
            errorMessage.textContent = 'This field is required.';
            field.parentNode.appendChild(errorMessage);
        }
    });
    
    // If the form is invalid, scroll to the first error
    if (!isValid) {
        const firstError = form.querySelector('.error');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
    }
    
    return isValid;
}

function validateDeathCertificateForm() {
    let isValid = true;
    const form = document.getElementById('deathCertificateForm');
    const requiredFields = form.querySelectorAll('[required]');
    
    // Clear previous error messages
    const errorMessages = form.querySelectorAll('.error-message');
    errorMessages.forEach(message => message.remove());
    
    // Reset error class
    const formElements = form.querySelectorAll('input, select, textarea');
    formElements.forEach(element => element.classList.remove('error'));
    
    // Validate required fields
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.classList.add('error');
            
            // Add error message
            const errorMessage = document.createElement('span');
            errorMessage.classList.add('error-message');
            errorMessage.textContent = 'This field is required.';
            field.parentNode.appendChild(errorMessage);
        }
    });
    
    // If the form is invalid, scroll to the first error
    if (!isValid) {
        const firstError = form.querySelector('.error');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
    }
    
    return isValid;
}