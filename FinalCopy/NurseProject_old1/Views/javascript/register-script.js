document.addEventListener('DOMContentLoaded', function () {
    const registrationForm = document.getElementById('registrationForm');
    const emailField = document.getElementById('email');
    const dobField = document.getElementById('DOB');
    const emailError = document.getElementById('emailError');
    const dobError = document.getElementById('DOBError');

    if (!registrationForm || !emailField || !dobField || !emailError || !dobError) {
        console.error('One or more form elements are missing. Please check the HTML.')
        return; 
    }

    registrationForm.addEventListener('submit', function (e) {
        e.preventDefault();

        let isValid = true;
        const email = emailField.value;
        const DOB = dobField.value;

        emailError.style.display = 'none';
        dobError.style.display = 'none';

        if (!validateEmail(email)) {
            emailError.style.display = 'block';
            isValid = false;
        }

        if (!validateDOB(DOB)) {
            dobError.style.display = 'block';
            isValid = false;
        }

        if (isValid) {
            registrationForm.submit();
        }
    });

    // Email validation function
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function validateDOB(dob) {
        if (!dob) return false;

        const dobDate = new Date(dob);
        const today = new Date();

        if (dobDate > today) {
            dobError.textContent = 'Date of birth cannot be in the future';
            return false;
        }

        let age = today.getFullYear() - dobDate.getFullYear();
        const monthDiff = today.getMonth() - dobDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dobDate.getDate())) {
            age--;
        }

        if (age < 18) {
            dobError.textContent = 'You must be at least 18 years old';
            return false;
        }

        return true;
    }

    emailField.addEventListener('input', function () {
        emailError.style.display = 'none';
    });

    dobField.addEventListener('input', function () {
        dobError.style.display = 'none';
    });
});