/**
 * registration.js
 * Handles multi-step form logic, validation, and summary calculation.
 * Now includes Custom Toast Notifications.
 */

let currentStep = 1;

document.addEventListener('DOMContentLoaded', () => {
    showStep(1);
});

// Helper: Show Step (Validation not checked here, purely UI)
function showStep(step) {
    // Ensure all steps are hidden first
    document.querySelectorAll('.step-content').forEach(el => el.classList.add('d-none'));
    
    // Show target step
    const targetStepDiv = document.getElementById(`step-${step}`);
    if (targetStepDiv) {
        targetStepDiv.classList.remove('d-none');
        currentStep = step;
        updateStepperUI(currentStep);
    }
}

// Function to validate fields in the current step
function validateStep(step) {
    const stepContainer = document.getElementById(`step-${step}`);
    if (!stepContainer) return false;

    const inputs = stepContainer.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;
    let firstInvalidInput = null;

    inputs.forEach(input => {
        let isInputValid = true;

        if (input.type === 'checkbox') {
            // Checkbox: Check if checked
            if (!input.checked) isInputValid = false;
        } else {
            // Text/Select: Check if value is not empty
            if (!input.value.trim()) isInputValid = false;
        }

        if (!isInputValid) {
            isValid = false;
            input.classList.add('is-invalid');
            
            // Capture first invalid input to focus later
            if (!firstInvalidInput) firstInvalidInput = input;

            // Remove error on input
            input.addEventListener('input', function() {
                // Check validity again on input change
                let valid = false;
                if (this.type === 'checkbox') valid = this.checked;
                else valid = this.value.trim() !== '';

                if (valid) {
                    this.classList.remove('is-invalid');
                }
            }, { once: true }); 
        } else {
             input.classList.remove('is-invalid');
        }
    });

    if (!isValid) {
        showToast('Mohon lengkapi semua data wajib yang ditandai merah.', 'error');
        if (firstInvalidInput) {
            firstInvalidInput.focus();
        }
    }
    
    return isValid;
}

// Navigate to Next Step
function nextStep(targetStep) {
    // Validate current step before moving
    if (!validateStep(currentStep)) {
        return;
    }

    // Hide current step & Show next
    document.getElementById(`step-${currentStep}`).classList.add('d-none');
    document.getElementById(`step-${targetStep}`).classList.remove('d-none');

    // Update state
    currentStep = targetStep;
    updateStepperUI(currentStep);

    // If moving to step 3, populate summary
    if (targetStep === 3) {
        populateSummary();
    }
    
    // Scroll to top of form
    scrollToForm();
}

// Navigate to Previous Step
function prevStep(targetStep) {
    document.getElementById(`step-${currentStep}`).classList.add('d-none');
    document.getElementById(`step-${targetStep}`).classList.remove('d-none');

    currentStep = targetStep;
    updateStepperUI(currentStep);
    scrollToForm();
}

function scrollToForm() {
    const formCard = document.querySelector('.form-card');
    if (formCard) formCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

// Update the visual Stepper (Circles)
function updateStepperUI(step) {
    document.querySelectorAll('.stepper-circle').forEach((circle, index) => {
        const stepNum = index + 1;
        if (stepNum === step) {
            circle.classList.add('active');
            circle.classList.remove('inactive');
            circle.innerHTML = stepNum;
        } else if (stepNum < step) {
            circle.classList.add('active'); 
            circle.classList.remove('inactive');
            circle.innerHTML = '✓'; 
        } else {
            circle.classList.remove('active');
            circle.classList.add('inactive');
            circle.innerHTML = stepNum;
        }
    });
    
    document.querySelectorAll('.stepper-label').forEach((label, index) => {
         const stepNum = index + 1;
         if (stepNum === step) {
             label.classList.add('active-label');
         } else {
             label.classList.remove('active-label');
         }
    });
}

// Populate Summary Data in Step 3
function populateSummary() {
    const getValue = (id) => document.getElementById(id)?.value || '-';
    
    document.getElementById('sumName').textContent = getValue('fullName');
    document.getElementById('sumNIK').textContent = getValue('nik');
    document.getElementById('sumEmail').textContent = getValue('email');
    document.getElementById('sumPhone').textContent = getValue('phone');
    
    const address = getValue('address');
    const city = getValue('city');
    const district = getValue('district');
    
    document.getElementById('sumAddress').textContent = `${address}, ${district}, ${city}`;
}

// Handle Final Submission
function submitForm() {
    if (!validateStep(3)) return;

    const name = document.getElementById('fullName').value;
    
    // Save flag to LocalStorage to trigger popup on Homepage
    localStorage.setItem('registrationSuccess', 'true');
    localStorage.setItem('registrantName', name); // Optional: to personalize the message

    // Redirect immediately to Homepage
    window.location.href = '../index.html';
}

/**
 * Custom Toast Notification System
 * @param {string} message - The message to display
 * @param {string} type - 'error' or 'success'
 */
function showToast(message, type = 'error') {
    const container = document.getElementById('toast-container');
    if (!container) return; // Fail safe

    // Create Toast Element
    const toast = document.createElement('div');
    toast.className = `custom-toast ${type}`;
    
    // Icon based on type
    const iconSvg = type === 'success' 
        ? `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16"><path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/></svg>`
        : `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>`;

    toast.innerHTML = `
        <div class="toast-icon">
            ${iconSvg}
        </div>
        <div class="toast-message">${message}</div>
    `;

    // Append to container
    container.appendChild(toast);

    // Trigger Animation
    requestAnimationFrame(() => {
        toast.classList.add('show');
    });

    // Auto remove after 3 seconds
    setTimeout(() => {
        toast.classList.remove('show');
        toast.addEventListener('transitionend', () => {
            toast.remove();
        });
    }, 4000);
}
