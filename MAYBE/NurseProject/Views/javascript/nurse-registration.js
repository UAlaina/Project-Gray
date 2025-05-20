document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registrationForm');

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        
        const errorElements = document.querySelectorAll('.error');
        errorElements.forEach(el => el.textContent = '');
        
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => input.classList.remove('input-error'));
        
        let isValid = true;

        const namePattern = /^[A-Za-z\s'-]+$/;
        const firstName = document.getElementById('firstName').value.trim();
        const lastName = document.getElementById('lastName').value.trim();

        if (!firstName || !namePattern.test(firstName)) {
            document.getElementById('firstNameError').textContent = 'Please enter a valid first name (letters only)';
            document.getElementById('firstName').classList.add('input-error');
            isValid = false;
        }

        if (!lastName || !namePattern.test(lastName)) {
            document.getElementById('lastNameError').textContent = 'Please enter a valid last name (letters only)';
            document.getElementById('lastName').classList.add('input-error');
            isValid = false;
        }

        const email = document.getElementById('email').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email || !emailRegex.test(email)) {
            document.getElementById('emailError').textContent = 'Enter a valid email address';
            document.getElementById('email').classList.add('input-error');
            isValid = false;
        }

        const description = document.getElementById('description').value.trim();
        if (!description || !/[A-Za-z]+/.test(description)) {
            document.getElementById('descriptionError').textContent = "Description must contain at least one letter.";
            document.getElementById('description').classList.add('input-error');
            isValid = false;
        }

        const password = document.getElementById('password').value;
        if (!password || password.length < 8) {
            document.getElementById('passwordError').textContent = 'Password must be at least 8 characters long';
            document.getElementById('password').classList.add('input-error');
            isValid = false;
        }

        const dob = document.getElementById('DOB').value;
        if (!dob) {
            document.getElementById('DOBError').textContent = 'Date of birth is required';
            document.getElementById('DOB').classList.add('input-error');
            isValid = false;
        } else {
            const dobDate = new Date(dob);
            const today = new Date();
            const age = today.getFullYear() - dobDate.getFullYear();
            const m = today.getMonth() - dobDate.getMonth();
            const dayValid = m > 0 || (m === 0 && today.getDate() >= dobDate.getDate());
            const is18 = age > 18 || (age === 18 && dayValid);

            if (dobDate > today) {
                document.getElementById('DOBError').textContent = 'Date of birth cannot be in the future';
                document.getElementById('DOB').classList.add('input-error');
                isValid = false;
            } else if (!is18) {
                document.getElementById('DOBError').textContent = 'You must be at least 18 years old to register';
                document.getElementById('DOB').classList.add('input-error');
                isValid = false;
            }
        }

        const gender = document.getElementById('gender').value;
        if (!gender) {
            document.getElementById('genderError').textContent = 'Please select a gender';
            document.getElementById('gender').classList.add('input-error');
            isValid = false;
        }

        const yearsExperience = document.getElementById('yearsExperience').value;
        if (!yearsExperience || isNaN(yearsExperience) || 
            Number(yearsExperience) < 4 || Number(yearsExperience) > 60) {
            document.getElementById('yearsExperienceError').textContent = 
                'Experience must be between 4 and 60 years';
            document.getElementById('yearsExperience').classList.add('input-error');
            isValid = false;
        }

        const licenseNumber = document.getElementById('licenseNumber').value.trim();
        if (!licenseNumber || licenseNumber.length < 5) {
            document.getElementById('licenseNumberError').textContent = 'Please enter a valid license number';
            document.getElementById('licenseNumber').classList.add('input-error');
            isValid = false;
        }

        const zipCode = document.getElementById('zipCode').value.trim();
        const zipRegex = /^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/;
        if (!zipRegex.test(zipCode)) {
            document.getElementById('zipCodeError').textContent = 'Enter a valid Quebec postal code (e.g. A1B 2C3)';
            document.getElementById('zipCode').classList.add('input-error');
            isValid = false;
        }

        const schedule = document.getElementById('schedule').value.trim();
        if (!schedule) {
            document.getElementById('scheduleError').textContent = 'Schedule is required';
            document.getElementById('schedule').classList.add('input-error');
            isValid = false;
        }

        const cardName = document.getElementById('cardName').value.trim();
        if (!cardName || !namePattern.test(cardName)) {
            document.getElementById('cardNameError').textContent = "Name on card must contain only letters, spaces, apostrophes and hyphens.";
            document.getElementById('cardName').classList.add('input-error');
            isValid = false;
        }

        const cardNumber = document.getElementById('cardNumber').value.replace(/\s+/g, '');
        if (!/^\d{16}$/.test(cardNumber)) {
            document.getElementById('cardNumberError').textContent = 'Card number must be 16 digits (numbers only)';
            document.getElementById('cardNumber').classList.add('input-error');
            isValid = false;
        }

        const expireDate = document.getElementById('expireDate').value.trim();
        const expireMatch = expireDate.match(/^(0[1-9]|1[0-2])\/\d{2}$/);
        if (!expireMatch) {
            document.getElementById('expireDateError').textContent = 'Use MM/YY format';
            document.getElementById('expireDate').classList.add('input-error');
            isValid = false;
        } else {
            const [month, year] = expireDate.split('/');
            const expiry = new Date(`20${year}`, parseInt(month), 0);
            const now = new Date();
            if (expiry < now) {
                document.getElementById('expireDateError').textContent = 'Card has expired';
                document.getElementById('expireDate').classList.add('input-error');
                isValid = false;
            }
        }

        const cvv = document.getElementById('cvv').value.trim();
        if (!/^\d{3}$/.test(cvv)) {
            document.getElementById('cvvError').textContent = 'CVV must be 3 digits';
            document.getElementById('cvv').classList.add('input-error');
            isValid = false;
        }

        if (isValid) {
            form.querySelector('button[type="submit"]').disabled = true;
            form.submit();
        } else {
            const firstError = document.querySelector('.error:not(:empty)');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });

    document.getElementById('cardNumber').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0) {
            value = value.match(/.{1,4}/g).join(' ');
        }
        e.target.value = value;
    });

    document.getElementById('expireDate').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 2) {
            value = value.slice(0, 2) + '/' + value.slice(2, 4);
        }
        e.target.value = value;
    });

    document.getElementById('cvv').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, 3);
    });
});