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
        });
    });
    
    // Load data for dropdowns
    loadCountries();
    loadProvinces();
    
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
    
    // Country change events to load provinces
    setupCountryProvinceRelationship('province_id', 'city_municipality_id');
    setupCountryProvinceRelationship('child_place_of_birth_province_id', 'child_place_of_birth_city_municipality_id');
    setupCountryProvinceRelationship('mother_residence_province_id', 'mother_residence_city_municipality_id', 'mother_residence_country_id');
    setupCountryProvinceRelationship('father_residence_province_id', 'father_residence_city_municipality_id', 'father_residence_country_id');
    setupCountryProvinceRelationship('marriage_place_province_id', 'marriage_place_city_municipality_id', 'marriage_place_country_id');
});

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

function loadCountries() {
    // In a real application, this would be an AJAX call to fetch countries from the server
    // For this example, we'll use a simplified approach with some common countries
    const countries = [
        { id: 1, name: 'Philippines', code: 'PHL' }
        // { id: 2, name: 'United States', code: 'USA' },
        // { id: 3, name: 'Japan', code: 'JPN' }
    ];
    
    const countrySelects = document.querySelectorAll('select[id$="country_id"]');
    
    countrySelects.forEach(select => {
        // Clear existing options except the first one (placeholder)
        while (select.options.length > 1) {
            select.remove(1);
        }
        
        // Add country options
        countries.forEach(country => {
            const option = document.createElement('option');
            option.value = country.id;
            option.textContent = country.name;
            select.appendChild(option);
        });
        
        // Set Philippines as default for country selects
        if (!select.value) {
            select.value = '1'; // Philippines ID
        }
    });
}

function loadProvinces(countryId = 1) {
    // In a real application, this would be an AJAX call to fetch provinces for the selected country
    // For this example, we'll use some sample provinces in the Philippines
    const provinces = [
        { id: 1, name: 'Pangasinan', country_id: 1 }
        // { id: 2, name: 'Cebu', country_id: 1 },
        // { id: 3, name: 'Davao', country_id: 1 },
        // { id: 4, name: 'California', country_id: 2 },
        // { id: 5, name: 'New York', country_id: 2 },
        // { id: 6, name: 'Tokyo', country_id: 3 },
        // { id: 7, name: 'Osaka', country_id: 3 }
    ];
    
    const provinceSelects = document.querySelectorAll('select[id$="province_id"]');
    
    provinceSelects.forEach(select => {
        // Clear existing options except the first one
        while (select.options.length > 1) {
            select.remove(1);
        }
        
        // Add filtered province options
        const filteredProvinces = provinces.filter(province => province.country_id == countryId);
        filteredProvinces.forEach(province => {
            const option = document.createElement('option');
            option.value = province.id;
            option.textContent = province.name;
            select.appendChild(option);
        });
        
        // Trigger change event to load cities
        select.dispatchEvent(new Event('change'));
    });
}

function loadCities(provinceId = 1) {
    // In a real application, this would be an AJAX call to fetch cities for the selected province
    // For this example, we'll use some sample cities
    const cities = [
        { id: 1, name: 'San Carlos', province_id: 1, is_city: true },
        { id: 2, name: 'Urbiztondo', province_id: 1, is_city: true },
        { id: 3, name: 'Dagupan', province_id: 1, is_city: true }
        // { id: 4, name: 'Cebu City', province_id: 2, is_city: true },
        // { id: 5, name: 'Mandaue', province_id: 2, is_city: true },
        // { id: 6, name: 'Davao City', province_id: 3, is_city: true },
        // { id: 7, name: 'Los Angeles', province_id: 4, is_city: true },
        // { id: 8, name: 'San Francisco', province_id: 4, is_city: true },
        // { id: 9, name: 'New York City', province_id: 5, is_city: true },
        // { id: 10, name: 'Shinjuku', province_id: 6, is_city: false },
        // { id: 11, name: 'Shibuya', province_id: 6, is_city: false },
        // { id: 12, name: 'Namba', province_id: 7, is_city: false }
    ];
    
    const citySelects = document.querySelectorAll('select[id$="city_municipality_id"]');
    
    citySelects.forEach(select => {
        // Clear existing options except the first one
        while (select.options.length > 1) {
            select.remove(1);
        }
        
        // Add filtered city options
        const filteredCities = cities.filter(city => city.province_id == provinceId);
        filteredCities.forEach(city => {
            const option = document.createElement('option');
            option.value = city.id;
            option.textContent = city.name + (city.is_city ? ' City' : '');
            select.appendChild(option);
        });
    });
}

function setupCountryProvinceRelationship(provinceSelectId, citySelectId, countrySelectId = null) {
    const provinceSelect = document.getElementById(provinceSelectId);
    const citySelect = document.getElementById(citySelectId);
    
    if (countrySelectId) {
        const countrySelect = document.getElementById(countrySelectId);
        countrySelect.addEventListener('change', function() {
            const selectedCountryId = this.value;
            if (selectedCountryId) {
                // Load provinces for the selected country
                const provinces = [
                    { id: 1, name: 'Pangasinan', country_id: 1 }
                    // { id: 2, name: 'Cebu', country_id: 1 },
                    // { id: 3, name: 'Davao', country_id: 1 },
                    // { id: 4, name: 'California', country_id: 2 },
                    // { id: 5, name: 'New York', country_id: 2 },
                    // { id: 6, name: 'Tokyo', country_id: 3 },
                    // { id: 7, name: 'Osaka', country_id: 3 }
                ];
                
                // Clear existing options except the first one
                while (provinceSelect.options.length > 1) {
                    provinceSelect.remove(1);
                }
                
                // Add filtered province options
                const filteredProvinces = provinces.filter(province => province.country_id == selectedCountryId);
                filteredProvinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.id;
                    option.textContent = province.name;
                    provinceSelect.appendChild(option);
                });
                
                // Clear city dropdown
                while (citySelect.options.length > 1) {
                    citySelect.remove(1);
                }
            }
        });
    }
    
    provinceSelect.addEventListener('change', function() {
        const selectedProvinceId = this.value;
        if (selectedProvinceId) {
            // Load cities for the selected province
            const cities = [
                { id: 1, name: 'San Carlos', province_id: 1, is_city: true },
                { id: 2, name: 'Urbiztondo', province_id: 1, is_city: true },
                { id: 3, name: 'Dagupan', province_id: 1, is_city: true }
                // { id: 4, name: 'Cebu City', province_id: 2, is_city: true },
                // { id: 5, name: 'Mandaue', province_id: 2, is_city: true },
                // { id: 6, name: 'Davao City', province_id: 3, is_city: true },
                // { id: 7, name: 'Los Angeles', province_id: 4, is_city: true },
                // { id: 8, name: 'San Francisco', province_id: 4, is_city: true },
                // { id: 9, name: 'New York City', province_id: 5, is_city: true },
                // { id: 10, name: 'Shinjuku', province_id: 6, is_city: false },
                // { id: 11, name: 'Shibuya', province_id: 6, is_city: false },
                // { id: 12, name: 'Namba', province_id: 7, is_city: false }
            ];
            
            // Clear existing options except the first one
            while (citySelect.options.length > 1) {
                citySelect.remove(1);
            }
            
            // Add filtered city options
            const filteredCities = cities.filter(city => city.province_id == selectedProvinceId);
            filteredCities.forEach(city => {
                const option = document.createElement('option');
                option.value = city.id;
                option.textContent = city.name + (city.is_city ? ' City' : '');
                citySelect.appendChild(option);
            });
        }
    });
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