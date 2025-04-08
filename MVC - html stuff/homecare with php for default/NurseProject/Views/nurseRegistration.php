<?php
$PATH = $_SERVER['SCRIPT_NAME'];
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nurse Registration</title>
    <link rel="stylesheet" href="Views/styles/nurseRegistration.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Nurse Registration</h1>
            <form id="registrationForm">
                <div class="form-group">
                    <label for="fullName">Full Name*</label>
                    <input type="text" id="fullName" name="fullName" required>
                    <span class="error" id="fullNameError"></span>
                </div>

                <div class="form-group">
                    <label for="email">Email Address*</label>
                    <input type="email" id="email" name="email" required>
                    <span class="error" id="emailError"></span>
                </div>

                <div class="form-group">
                    <label for="password">Password*</label>
                    <input type="password" id="password" name="password" required>
                    <span class="error" id="passwordError"></span>
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth*</label>
                    <input type="date" id="dob" name="dob" required>
                    <span class="error" id="dobError"></span>
                </div>

                <div class="form-group">
                    <label for="gender">Gender*</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                        <option value="prefer-not-to-say">Prefer not to say</option>
                    </select>
                    <span class="error" id="genderError"></span>
                </div>

                <div class="form-group">
                    <label for="experience">Years of Experience*</label>
                    <input type="number" id="experience" name="experience" min="0" required>
                    <span class="error" id="experienceError"></span>
                </div>

                <div class="form-group">
                    <label for="licenseNumber">License Number*</label>
                    <input type="text" id="licenseNumber" name="licenseNumber" required>
                    <span class="error" id="licenseNumberError"></span>
                </div>

                <div class="form-group">
                    <label for="zipCode">Zip Code*</label>
                    <input type="text" id="zipCode" name="zipCode" required>
                    <span class="error" id="zipCodeError"></span>
                </div>

                <div class="form-group">
                    <label for="schedule">Available Schedule*</label>
                    <select id="schedule" name="schedule" required>
                        <option value="">Select Schedule</option>
                        <option value="full-time">Full Time</option>
                        <option value="part-time">Part Time</option>
                        <option value="weekends">Weekends Only</option>
                        <option value="nights">Night Shifts</option>
                        <option value="flexible">Flexible</option>
                    </select>
                    <span class="error" id="scheduleError"></span>
                </div>

                <div class="form-group">
                    <label for="specialties">Specialties*</label>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="icu" name="specialties" value="ICU">
                            <label for="icu">ICU</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="er" name="specialties" value="ER">
                            <label for="er">Emergency Room</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="pediatric" name="specialties" value="Pediatric">
                            <label for="pediatric">Pediatric</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="psychiatric" name="specialties" value="Psychiatric">
                            <label for="psychiatric">Psychiatric</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="geriatric" name="specialties" value="Geriatric">
                            <label for="geriatric">Geriatric</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="obgyn" name="specialties" value="OBGYN">
                            <label for="obgyn">OB/GYN</label>
                        </div>
                    </div>
                    <span class="error" id="specialtiesError"></span>
                </div>

                <div class="payment-section">
                    <h2>Registration Payment</h2>
                    <div class="form-group">
                        <label for="cardNumber">Card Number*</label>
                        <input type="text" id="cardNumber" name="cardNumber" required>
                        <span class="error" id="cardNumberError"></span>
                    </div>
                    <div class="form-row">
                        <div class="form-group half">
                            <label for="expiryDate">Expiry Date*</label>
                            <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY" required>
                            <span class="error" id="expiryDateError"></span>
                        </div>
                        <div class="form-group half">
                            <label for="cvv">CVV*</label>
                            <input type="text" id="cvv" name="cvv" required>
                            <span class="error" id="cvvError"></span>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" id="submitBtn">Complete Registration</button>
                    <p class="login-link">Already registered? <a href="login.html">Login here</a></p>
                </div>
            </form>
        </div>
    </div>
    <script src="Views/javascript/nurse-registration.js"></script>
</body>
</html>