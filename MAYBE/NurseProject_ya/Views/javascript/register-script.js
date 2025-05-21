document.getElementById('registrationForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const firstName = document.getElementById('firstName').value.trim();
    const lastName = document.getElementById('lastName').value.trim();
    const zipCode = document.getElementById('zipCode').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const description = document.getElementById('description').value.trim();
    const dob = document.getElementById('DOB').value;
    const gender = document.getElementById('gender').value;

    let isValid = true;

    if (!validateName(firstName)) {
        showError('firstName', 'firstNameError');
        isValid = false;
    }

    if (!validateName(lastName)) {
        showError('lastName', 'lastNameError');
        isValid = false;
    }

    if (!validateZipCode(zipCode)) {
        showError('zipCode', 'zipError');
        isValid = false;
    }

    if (!validateEmail(email)) {
        showError('email', 'emailError');
        isValid = false;
    }

    if (!validatePassword(password)) {
        showError('password', 'passwordError');
        isValid = false;
    }

    if (password !== confirmPassword) {
        showError('confirmPassword', 'confirmPasswordError');
        isValid = false;
    }

    if (description.length < 5) {
        alert("Description must be filled out.");
        isValid = false;
    }

    if (!dob || !isAdult(dob)) {
        alert("You must be at least 18 years old to register.");
        isValid = false;
    }

    if (!gender) {
        alert("Please select a gender.");
        isValid = false;
    }

    if (isValid) {
        this.submit();
    }
});

function validateName(name) {
    const namePattern = /^[A-Za-z\s'-]+$/;
    return name.length > 1 && namePattern.test(name);
}

function validateZipCode(zip) {
    return /^[A-Za-z]\d[A-Za-z][\s-]?\d[A-Za-z]\d$/i.test(zip);
}

function validateEmail(email) {
    const pattern = /^[^\s@]+@[^\s@]+\.(com|ca)$/i;
    return pattern.test(email);
}

function validatePassword(password) {
    return password.length >= 8;
}

function isAdult(dob) {
    const dobDate = new Date(dob);
    const today = new Date();
    const age = today.getFullYear() - dobDate.getFullYear();
    const monthDiff = today.getMonth() - dobDate.getMonth();
    const dayDiff = today.getDate() - dobDate.getDate();

    return age > 18 || (age === 18 && (monthDiff > 0 || (monthDiff === 0 && dayDiff >= 0)));
}

function showError(inputId, errorId) {
    document.getElementById(inputId).classList.add('invalid');
    document.getElementById(errorId).style.display = 'block';
}