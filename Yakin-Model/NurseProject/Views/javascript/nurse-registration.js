document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    
    // Form validation function
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        // Reset all error messages
        const errorElements = document.querySelectorAll('.error');
        errorElements.forEach(element => {
            element.textContent = '';
        });
        
        let isValid = true;
        
        // Validate full name
        const fullName = document.getElementById('fullName').value.trim();
        if (!fullName) {
            document.getElementById('fullNameError').textContent = 'Full name is required';
            isValid = false;
        } else if (fullName.length < 2) {
            document.getElementById('fullNameError').textContent = 'Please enter a valid name';
            isValid = false;
        }
        
        // Validate email
        const email = document.getElementById('email').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            document.getElementById('emailError').textContent = 'Email is required';
            isValid = false;
        } else if (!emailRegex.test(email)) {
            document.getElementById('emailError').textContent = 'Please enter a valid email address';
            isValid = false;
        }
        
        // Validate password
        const password = document.getElementById('password').value;
        if (!password) {
            document.getElementById('passwordError').textContent = 'Password is required';
            isValid = false;
        } else if (password.length < 8) {
            document.getElementById('passwordError').textContent = 'Password must be at least 8 characters long';
            isValid = false;
        }
        
        // Validate date of birth
        const dob = document.getElementById('dob').value;
        if (!dob) {
            document.getElementById('dobError').textContent = 'Date of birth is required';
            isValid = false;
        } else {
            const birthDate = new Date(dob);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            if (age < 18) {
                document.getElementById('dobError').textContent = 'You must be at least 18 years old';
                isValid = false;
            }
        }
        
        // Validate gender
        const gender = document.getElementById('gender').value;
        if (!gender) {
            document.getElementById('genderError').textContent = 'Please select a gender';
            isValid = false;
        }
        
        // Validate years of experience
        const experience = document.getElementById('experience').value;
        if (!experience) {
            document.getElementById('experienceError').textContent = 'Years of experience is required';
            isValid = false;
        } else if (experience < 0) {
            document.getElementById('experienceError').textContent = 'Years of experience cannot be negative';
            isValid = false;
        } else if (experience < 2) {
            document.getElementById('experienceError').textContent = 'Minimum 2 years of experience required';
            isValid = false;
        }
        
        // Validate license number
        const licenseNumber = document.getElementById('licenseNumber').value.trim();
        if (!licenseNumber) {
            document.getElementById('licenseNumberError').textContent = 'License number is required';
            isValid = false;
        } else if (licenseNumber.length < 5) {
            document.getElementById('licenseNumberError').textContent = 'Please enter a valid license number';
            isValid = false;
        }
        
        // Validate zip code
        const zipCode = document.getElementById('zipCode').value.trim();
        const zipRegex = /(^\d{5}$)|(^\d{5}-\d{4}$)/;
        if (!zipCode) {
            document.getElementById('zipCodeError').textContent = 'Zip code is required';
            isValid = false;
        } else if (!zipRegex.test(zipCode)) {
            document.getElementById('zipCodeError').textContent = 'Please enter a valid zip code (e.g., 12345 or 12345-6789)';
            isValid = false;
        }
        
        // Validate schedule
        const schedule = document.getElementById('schedule').value;
        if (!schedule) {
            document.getElementById('scheduleError').textContent = 'Please select a schedule';
            isValid = false;
        }
        
        // Validate specialties (at least one must be selected)
        const specialties = document.querySelectorAll('input[name="specialties"]:checked');
        if (specialties.length === 0) {
            document.getElementById('specialtiesError').textContent = 'Please select at least one specialty';
            isValid = false;
        }
        
        // Validate payment information
        const cardNumber = document.getElementById('cardNumber').value.trim();
        if (!cardNumber) {
            document.getElementById('cardNumberError').textContent = 'Card number is required';
            isValid = false;
        } else if (!/^\d{16}$/.test(cardNumber.replace(/\s/g, ''))) {
            document.getElementById('cardNumberError').textContent = 'Please enter a valid 16-digit card number';
            isValid = false;
        }
        
        const expiryDate = document.getElementById('expiryDate').value.trim();
        const expiryRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
        if (!expiryDate) {
            document.getElementById('expiryDateError').textContent = 'Expiry date is required';
            isValid = false;
        } else if (!expiryRegex.test(expiryDate)) {
            document.getElementById('expiryDateError').textContent = 'Please enter a valid expiry date (MM/YY)';
            isValid = false;
        } else {
            // Check if card is expired
            const [month, year] = expiryDate.split('/');
            const expiryMonth = parseInt(month, 10) - 1; // JS months are 0-based
            const expiryYear = 2000 + parseInt(year, 10);
            const currentDate = new Date();
            const expiryDateObj = new Date(expiryYear, expiryMonth, 1);
            
            if (expiryDateObj < currentDate) {
                document.getElementById('expiryDateError').textContent = 'Card has expired';
                isValid = false;
            }
        }
        
        const cvv = document.getElementById('cvv').value.trim();
        if (!cvv) {
            document.getElementById('cvvError').textContent = 'CVV is required';
            isValid = false;
        } else if (!/^\d{3,4}$/.test(cvv)) {
            document.getElementById('cvvError').textContent = 'Please enter a valid CVV (3 or 4 digits)';
            isValid = false;
        }
        
        // If form is valid, submit it
        if (isValid) {
            // For demonstration, we'll just show a success message
            // In a real application, you would send the data to the server
            alert('Registration successful! You can now log in.');
            form.reset();
            window.location.href = 'login.html'; // Redirect to login page
        }
    });
    
    // Format card number with spaces
    document.getElementById('cardNumber').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\s+/g, '');
        if (value.length > 0) {
            value = value.match(new RegExp('.{1,4}', 'g')).join(' ');
        }
        e.target.value = value;
    });
    
    // Format expiry date (MM/YY)
    document.getElementById('expiryDate').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 2) {
            value = value.slice(0, 2) + '/' + value.slice(2, 4);
        }
        e.target.value = value;
    });
    
    // Only allow numbers in CVV
    document.getElementById('cvv').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, 4);
    });
});