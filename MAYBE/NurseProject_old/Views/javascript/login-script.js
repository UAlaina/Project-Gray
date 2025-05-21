document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    if (!validateEmail(email)) {
        showError('email', 'emailError');
        return;
    }
    
    if (!validatePassword(password)) {
        showError('password', 'passwordError');
        return;
    }
    
    alert('Login successful!');
    
});

function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function validatePassword(password) {
    return password.length > 0;
}

function showError(inputId, errorId) {
    document.getElementById(inputId).classList.add('invalid');
    document.getElementById(errorId).style.display = 'block';
}

const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
inputs.forEach(input => {
    input.addEventListener('input', function() {
        const id = this.id;
        const value = this.value;
        const errorId = id + 'Error';
        
        let isValid = false;
        
        if (id === 'email') {
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