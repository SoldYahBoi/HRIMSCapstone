document.addEventListener("DOMContentLoaded", () => {
    // Form step navigation
    const steps = document.querySelectorAll(".form-step");
    const progressSteps = document.querySelectorAll(".progress-step");
    let currentStep = 0;

    // Initialize form with animations
    initializeForm();

    // Next step button click handler
    document.querySelectorAll(".next-step").forEach((button) => {
        button.addEventListener("click", () => {
            if (validateStep(currentStep)) {
                goToStep(currentStep + 1);
            }
        });
    });

    // Previous step button click handler
    document.querySelectorAll(".prev-step").forEach((button) => {
        button.addEventListener("click", () => {
            goToStep(currentStep - 1);
        });
    });

    // Progress step click handler for direct navigation
    progressSteps.forEach((step, index) => {
        step.addEventListener("click", () => {
            if (validateAllPreviousSteps(index)) {
                goToStep(index);
            }
        });
    });

    // Toggle autopsy performed checkbox
    const autopsyPerformedCheckbox = document.getElementById("death_cause_autopsy_performed");
    if (autopsyPerformedCheckbox) {
        autopsyPerformedCheckbox.addEventListener("change", () => {
            // Additional logic if needed when autopsy checkbox changes
        });
    }

    // Toggle attended deceased checkbox
    const attendedDeceasedCheckbox = document.getElementById("death_attendant_attended_deceased");
    if (attendedDeceasedCheckbox) {
        attendedDeceasedCheckbox.addEventListener("change", () => {
            // Additional logic if needed when attended deceased checkbox changes
        });
    }

    // Toggle other attendant type field
    const attendantTypeSelect = document.getElementById("death_attendant_attendant_type");
    const otherAttendantField = document.querySelector(".other-attendant-field");

    if (attendantTypeSelect && otherAttendantField) {
        attendantTypeSelect.addEventListener("change", function () {
            toggleFieldsVisibility(otherAttendantField, this.value === "5");
        });
    }

    // Toggle other disposal type field
    const disposalTypeSelect = document.getElementById("corpse_disposal_disposal_type");
    const otherDisposalField = document.querySelector(".other-disposal-field");

    if (disposalTypeSelect && otherDisposalField) {
        disposalTypeSelect.addEventListener("change", function () {
            toggleFieldsVisibility(otherDisposalField, this.value === "Others");
        });
    }

    // Province change handlers for city dropdowns
    document.querySelectorAll(".province-select").forEach((select) => {
        select.addEventListener("change", function () {
            const targetCitySelect = document.getElementById(this.dataset.target);
            if (targetCitySelect) {
                fetchCities(this.value, targetCitySelect);
            }
        });
    });

    // Country change handlers for province dropdowns
    document.querySelectorAll(".country-select").forEach((select) => {
        select.addEventListener("change", function () {
            const targetProvinceSelect = document.getElementById(this.dataset.target);
            if (targetProvinceSelect) {
                fetchProvinces(this.value, targetProvinceSelect);
            }
        });
    });

    // Form submission handler with validation
    const editCertForm = document.getElementById("editDeathCertForm");
    if (editCertForm) {
        editCertForm.addEventListener("submit", (event) => {
            if (!validateAllSteps()) {
                event.preventDefault();
                showValidationErrors();
            } else {
                // Show loading indicator
                showLoadingOverlay();
            }
        });
    }

    // Calculate age based on birth and death dates
    const dateOfBirthInput = document.getElementById("deceased_date_of_birth");
    const dateOfDeathInput = document.getElementById("deceased_date_of_death");
    const ageYearsInput = document.getElementById("deceased_age_years");
    const ageMonthsInput = document.getElementById("deceased_age_months");
    const ageDaysInput = document.getElementById("deceased_age_days");
    const ageHoursInput = document.getElementById("deceased_age_hours");
    const ageMinutesInput = document.getElementById("deceased_age_minutes");

    if (dateOfBirthInput && dateOfDeathInput) {
        const calculateAge = () => {
            const birthDate = new Date(dateOfBirthInput.value);
            const deathDate = new Date(dateOfDeathInput.value);

            if (isNaN(birthDate.getTime()) || isNaN(deathDate.getTime())) {
                return;
            }

            // Calculate difference in milliseconds
            const diffMs = deathDate - birthDate;

            if (diffMs < 0) {
                alert("Date of death cannot be earlier than date of birth");
                return;
            }

            // Calculate years, months, days, hours, minutes
            const msInYear = 1000 * 60 * 60 * 24 * 365.25;
            const msInMonth = msInYear / 12;
            const msInDay = 1000 * 60 * 60 * 24;
            const msInHour = 1000 * 60 * 60;
            const msInMinute = 1000 * 60;

            const years = Math.floor(diffMs / msInYear);
            const months = Math.floor((diffMs % msInYear) / msInMonth);
            const days = Math.floor(((diffMs % msInYear) % msInMonth) / msInDay);
            const hours = Math.floor((((diffMs % msInYear) % msInMonth) % msInDay) / msInHour);
            const minutes = Math.floor(((((diffMs % msInYear) % msInMonth) % msInDay) % msInHour) / msInMinute);

            // Update age fields
            if (ageYearsInput) ageYearsInput.value = years;
            if (ageMonthsInput) ageMonthsInput.value = months;
            if (ageDaysInput) ageDaysInput.value = days;
            if (ageHoursInput) ageHoursInput.value = hours;
            if (ageMinutesInput) ageMinutesInput.value = minutes;
        };

        dateOfBirthInput.addEventListener("change", calculateAge);
        dateOfDeathInput.addEventListener("change", calculateAge);
    }

    // Functions

    function initializeForm() {
        // Hide all steps except the first one
        steps.forEach((step, index) => {
            if (index !== 0) {
                step.style.display = "none";
            } else {
                step.classList.add("active");
                fadeIn(step);
            }
        });

        // Mark the first progress step as active
        progressSteps[0].classList.add("active");
    }

    function goToStep(stepIndex) {
        if (stepIndex < 0 || stepIndex >= steps.length) return;

        // Hide current step with fade out
        fadeOut(steps[currentStep], () => {
            steps[currentStep].style.display = "none";
            steps[currentStep].classList.remove("active");
            progressSteps[currentStep].classList.remove("active");

            // Show new step with fade in
            currentStep = stepIndex;
            steps[currentStep].style.display = "block";
            fadeIn(steps[currentStep]);
            steps[currentStep].classList.add("active");
            progressSteps[currentStep].classList.add("active");

            // Update progress bar
            updateProgressBar();

            // Scroll to top of the form
            window.scrollTo({
                top: document.querySelector(".form-progress-container").offsetTop - 20,
                behavior: "smooth",
            });
        });
    }

    function updateProgressBar() {
        // Update progress steps
        progressSteps.forEach((step, index) => {
            if (index <= currentStep) {
                step.classList.add("completed");
            } else {
                step.classList.remove("completed");
            }
        });
    }

    function validateStep(stepIndex) {
        const step = steps[stepIndex];
        const requiredFields = step.querySelectorAll("input[required], select[required], textarea[required]");
        let isValid = true;

        requiredFields.forEach((field) => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add("is-invalid");

                // Add error message if not already present
                if (!field.nextElementSibling || !field.nextElementSibling.classList.contains("invalid-feedback")) {
                    const errorMsg = document.createElement("div");
                    errorMsg.className = "invalid-feedback";
                    errorMsg.textContent = "This field is required";
                    field.parentNode.insertBefore(errorMsg, field.nextSibling);
                }
            } else {
                field.classList.remove("is-invalid");

                // Remove error message if present
                if (field.nextElementSibling && field.nextElementSibling.classList.contains("invalid-feedback")) {
                    field.parentNode.removeChild(field.nextElementSibling);
                }
            }
        });

        return isValid;
    }

    function validateAllPreviousSteps(targetStepIndex) {
        for (let i = 0; i < targetStepIndex; i++) {
            if (!validateStep(i)) {
                goToStep(i);
                return false;
            }
        }
        return true;
    }

    function validateAllSteps() {
        for (let i = 0; i < steps.length; i++) {
            if (!validateStep(i)) {
                goToStep(i);
                return false;
            }
        }
        return true;
    }

    function showValidationErrors() {
        const alertDiv = document.createElement("div");
        alertDiv.className = "alert alert-danger alert-dismissible fade show";
        alertDiv.innerHTML = `
            <strong>Error!</strong> Please fill in all required fields.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        `;

        const formContainer = document.querySelector(".edit-certificate-container");
        formContainer.insertBefore(alertDiv, formContainer.firstChild);

        // Auto dismiss after 5 seconds
        setTimeout(() => {
            alertDiv.classList.remove("show");
            setTimeout(() => alertDiv.remove(), 150);
        }, 5000);
    }

    function toggleFieldsVisibility(element, isVisible) {
        if (isVisible) {
            element.style.display = "block";
            fadeIn(element);
        } else {
            fadeOut(element, () => {
                element.style.display = "none";
            });
        }
    }

    function fetchCities(provinceId, citySelect) {
        // Show loading indicator in the select
        citySelect.innerHTML = "<option>Loading cities...</option>";

        // Fetch cities from the server
        fetch(`/certificates/cities/${provinceId}`)
            .then((response) => response.json())
            .then((cities) => {
                citySelect.innerHTML = "";
                cities.forEach((city) => {
                    const option = document.createElement("option");
                    option.value = city.id;
                    option.textContent = city.name;
                    citySelect.appendChild(option);
                });
            })
            .catch((error) => {
                console.error("Error fetching cities:", error);
                citySelect.innerHTML = '<option value="">Error loading cities</option>';
            });
    }

    function fetchProvinces(countryId, provinceSelect) {
        // Show loading indicator in the select
        provinceSelect.innerHTML = "<option>Loading provinces...</option>";

        // Fetch provinces from the server
        fetch(`/certificates/provinces/${countryId}`)
            .then((response) => response.json())
            .then((provinces) => {
                provinceSelect.innerHTML = "";
                provinces.forEach((province) => {
                    const option = document.createElement("option");
                    option.value = province.id;
                    option.textContent = province.name;
                    provinceSelect.appendChild(option);
                });

                // Trigger change event to update city dropdown
                const event = new Event("change");
                provinceSelect.dispatchEvent(event);
            })
            .catch((error) => {
                console.error("Error fetching provinces:", error);
                provinceSelect.innerHTML = '<option value="">Error loading provinces</option>';
            });
    }

    function fadeIn(element, callback) {
        element.style.opacity = 0;
        element.style.display = "block";

        let opacity = 0;
        const timer = setInterval(() => {
            opacity += 0.1;
            element.style.opacity = opacity;

            if (opacity >= 1) {
                clearInterval(timer);
                if (callback) callback();
            }
        }, 20);
    }

    function fadeOut(element, callback) {
        let opacity = 1;
        const timer = setInterval(() => {
            opacity -= 0.1;
            element.style.opacity = opacity;

            if (opacity <= 0) {
                clearInterval(timer);
                if (callback) callback();
            }
        }, 20);
    }

    function showLoadingOverlay() {
        // Create loading overlay if it doesn't exist
        if (!document.getElementById("loading-overlay")) {
            const loadingOverlay = document.createElement("div");
            loadingOverlay.id = "loading-overlay";
            loadingOverlay.innerHTML = `
                <div class="loading-spinner"></div>
                <p>Saving changes...</p>
            `;
            document.body.appendChild(loadingOverlay);

            // Add styles for loading overlay
            const style = document.createElement("style");
            style.textContent = `
                #loading-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.7);
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    z-index: 9999;
                    color: white;
                }
                .loading-spinner {
                    border: 5px solid #f3f3f3;
                    border-top: 5px solid #3498db;
                    border-radius: 50%;
                    width: 50px;
                    height: 50px;
                    animation: spin 2s linear infinite;
                    margin-bottom: 20px;
                }
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            `;
            document.head.appendChild(style);
        } else {
            document.getElementById("loading-overlay").style.display = "flex";
        }
    }
});