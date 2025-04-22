document.addEventListener('DOMContentLoaded', function () {
    const registrationForm = document.getElementById('registrationForm');
    const emailField = document.getElementById('email');
    const dobField = document.getElementById('DOB');
    const emailError = document.getElementById('emailError');
    const dobError = document.getElementById('DOBError');

    if (!registrationForm || !emailField || !dobField || !emailError || !dobError) {
        console.error('One or more form elements are missing. Please check the HTML.')
        return; // Stop further execution if required elements are not found
    }

    // Form submission event listener
    registrationForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent form submission initially

        let isValid = true;
        const email = emailField.value;
        const DOB = dobField.value;

        // Reset error messages
        emailError.style.display = 'none';
        dobError.style.display = 'none';

        // Email validation
        if (!validateEmail(email)) {
            emailError.style.display = 'block';
            isValid = false;
        }

        // DOB validation
        if (!validateDOB(DOB)) {
            dobError.style.display = 'block';
            isValid = false;
        }

        // If all validations pass, submit the form
        if (isValid) {
            registrationForm.submit();
        }
    });

    // Email validation function
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // DOB validation function
    function validateDOB(dob) {
        if (!dob) return false;

        const dobDate = new Date(dob);
        const today = new Date();

        // Check if it's a future date
        if (dobDate > today) {
            dobError.textContent = 'Date of birth cannot be in the future';
            return false;
        }

        // Calculate age
        let age = today.getFullYear() - dobDate.getFullYear();
        const monthDiff = today.getMonth() - dobDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dobDate.getDate())) {
            age--;
        }

        // Check if user is at least 18
        if (age < 18) {
            dobError.textContent = 'You must be at least 18 years old';
            return false;
        }

        return true;
    }

    // Clear email error message when the user types
    emailField.addEventListener('input', function () {
        emailError.style.display = 'none';
    });

    // Clear DOB error message when the user types
    dobField.addEventListener('input', function () {
        dobError.style.display = 'none';
    });
});