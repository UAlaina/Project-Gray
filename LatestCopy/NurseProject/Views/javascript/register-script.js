document.getElementById('registrationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const fullName = document.getElementById('fullName').value;
    const zipCode = document.getElementById('zipCode').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    if (!validateName(fullName)) {
        showError('fullName', 'nameError');
        return;
    }
    
    if (!validateZipCode(zipCode)) {
        showError('zipCode', 'zipError');
        return;
    }
    
    if (!validateEmail(email)) {
        showError('email', 'emailError');
        return;
    }
    
    if (!validatePassword(password)) {
        showError('password', 'passwordError');
        return;
    }
    
    alert('Registration successful!');
    
});

function validateName(name) {
    return name.trim().length > 1 && /^[a-zA-Z\s]+$/.test(name);
}

function validateZipCode(zip) {
    return /^\d{5}(-\d{4})?$/.test(zip);
}

function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function validatePassword(password) {
    return password.length >= 8;
}

function showError(inputId, errorId) {
    document.getElementById(inputId).classList.add('invalid');
    document.getElementById(errorId).style.display = 'block';
}

const inputs = document.querySelectorAll('input');
inputs.forEach(input => {
    input.addEventListener('input', function() {
        const id = this.id;
        const value = this.value;
        const errorId = id + 'Error';
        
        let isValid = false;
        
        if (id === 'fullName') {
            isValid = validateName(value);
        } else if (id === 'zipCode') {
            isValid = validateZipCode(value);
        } else if (id === 'email') {
            isValid = validateEmail(value);
        } else if (id === 'password') {
            isValid = validatePassword(value);
        }
        
        if (isValid) {
            this.classList.remove('invalid');
            this.classList.add('field-valid');
            document.getElementById(errorId).style.display = 'none';
        } else {
            this.classList.remove('field-valid');
            if (value.trim() !== '') {
                this.classList.add('invalid');
                document.getElementById(errorId).style.display = 'block';
            } else {
                this.classList.remove('invalid');
                document.getElementById(errorId).style.display = 'none';
            }
        }
    });
});