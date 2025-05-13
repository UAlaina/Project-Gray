document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registrationForm');

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        const errorElements = document.querySelectorAll('.error');
        errorElements.forEach(el => el.textContent = '');

        const namePattern = /^[A-Za-z\s'-]+$/;
        const firstName = document.getElementById('firstName').value.trim();
        const lastName = document.getElementById('lastName').value.trim();

        if (!firstName || !namePattern.test(firstName)) {
            document.getElementById('firstNameError').textContent = 'Please enter a valid first name (letters only)';
            alert('Invalid First Name: Only letters, spaces, apostrophes and hyphens are allowed.');
            return;
        }

        if (!lastName || !namePattern.test(lastName)) {
            document.getElementById('lastNameError').textContent = 'Please enter a valid last name (letters only)';
            alert('Invalid Last Name: Only letters, spaces, apostrophes and hyphens are allowed.');
            return;
        }

        const email = document.getElementById('email').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.(com|ca)$/i;
        if (!email || !emailRegex.test(email)) {
            document.getElementById('emailError').textContent = 'Enter a valid email ending in .com or .ca';
            alert('Invalid Email: Must contain @ and end with .com or .ca');
            return;
        }

        const password = document.getElementById('password').value;
        if (!password || password.length < 8) {
            document.getElementById('passwordError').textContent = 'Password must be at least 8 characters long';
            alert('Password too short: Must be at least 8 characters.');
            return;
        }

        const dob = document.getElementById('DOB').value;
        if (!dob) {
            document.getElementById('DOBError').textContent = 'Date of birth is required';
            alert('Date of birth is required.');
            return;
        } else {
            const dobDate = new Date(dob);
            const today = new Date();
            const age = today.getFullYear() - dobDate.getFullYear();
            const m = today.getMonth() - dobDate.getMonth();
            const dayValid = m > 0 || (m === 0 && today.getDate() >= dobDate.getDate());
            const is22 = age > 22 || (age === 22 && dayValid);

            if (dobDate > today) {
                document.getElementById('DOBError').textContent = 'Date of birth cannot be in the future';
                alert('Date of birth cannot be in the future.');
                return;
            } else if (!is22) {
                document.getElementById('DOBError').textContent = 'You must be at least 22 years old to register';
                alert('You must be at least 22 years old to register.');
                return;
            }
        }

        const gender = document.getElementById('gender').value;
        if (!gender) {
            document.getElementById('genderError').textContent = 'Please select a gender';
            alert('Gender is required.');
            return;
        }

        const yearsExperience = document.getElementById('yearsExperience').value;
        if (!yearsExperience || isNaN(yearsExperience) || Number(yearsExperience) < 4) {
            document.getElementById('yearsExperienceError').textContent = 'Minimum 4 years experience required';
            alert('Minimum 4 years of experience required.');
            return;
        }

        const licenseNumber = document.getElementById('licenseNumber').value.trim();
        if (!licenseNumber || licenseNumber.length < 5) {
            document.getElementById('licenseNumberError').textContent = 'Please enter a valid license number';
            alert('License number must be at least 5 characters.');
            return;
        }

        const zipCode = document.getElementById('zipCode').value.trim();
        const zipRegex = /^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/;
        if (!zipRegex.test(zipCode)) {
            document.getElementById('zipCodeError').textContent = 'Enter a valid Canadian zip code (e.g. A1B 2C3)';
            alert('Invalid Zip Code: Must be Canadian format (e.g. A1B 2C3)');
            return;
        }

        const schedule = document.getElementById('schedule').value.trim();
        if (!schedule) {
            document.getElementById('scheduleError').textContent = 'Schedule is required';
            alert('Schedule is required.');
            return;
        }

        const cardNumber = document.getElementById('cardNumber').value.replace(/\s+/g, '');
        if (!/^\d{16}$/.test(cardNumber)) {
            document.getElementById('cardNumberError').textContent = 'Card number must be 16 digits (numbers only)';
            alert('Invalid Card Number: Must be 16 digits with no letters.');
            return;
        }

        const expireDate = document.getElementById('expireDate').value.trim();
        const expireMatch = expireDate.match(/^(0[1-9]|1[0-2])\/\d{2}$/);
        if (!expireMatch) {
            document.getElementById('expireDateError').textContent = 'Use MM/YY format';
            alert('Invalid Expiry Date: Use MM/YY format.');
            return;
        } else {
            const [month, year] = expireDate.split('/');
            const expiry = new Date(`20${year}`, parseInt(month), 0);
            const now = new Date();
            if (expiry < now) {
                document.getElementById('expireDateError').textContent = 'Card has expired';
                alert('Card has expired.');
                return;
            }
        }

        const cvv = document.getElementById('cvv').value.trim();
        if (!/^\d{3,4}$/.test(cvv)) {
            document.getElementById('cvvError').textContent = 'CVV must be 3 or 4 digits';
            alert('Invalid CVV: Must be 3 or 4 digits only.');
            return;
        }

        const description = document.getElementById('description').value.trim();
        if (!description || description.length < 5) {
            alert("Description is required.");
            return;
        }

        const cardName = document.getElementById('cardName').value.trim();
        if (!/^[A-Za-z\s'-]+$/.test(cardName)) {
            alert("Name on card must be letters only.");
            return;
        }

        form.querySelector('button[type="submit"]').disabled = true;
        form.submit();
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
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, 4);
    });
});
