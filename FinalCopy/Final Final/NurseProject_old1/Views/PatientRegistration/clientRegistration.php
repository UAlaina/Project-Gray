<?php $PATH = $_SERVER['SCRIPT_NAME']; ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration</title>
    <link rel="stylesheet" href="../../Views/styles/clientregistrationstyle.css">
</head>
<body>
    <div class="container">
        <h1>Patient Registration</h1>

        <form id="registrationForm" method="POST" action="../../index.php?controller=patient&action=register">

            <!-- First Name -->
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" required>
                <div class="error" id="firstNameError">Please enter a valid first name</div>
            </div>

            <!-- Last Name -->
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" required>
                <div class="error" id="lastNameError">Please enter a valid last name</div>
            </div>

            <!-- Zip Code -->
            <div class="form-group">
                <label for="zipCode">Zip Code</label>
                <input type="text" id="zipCode" name="zipCode" required>
                <div class="error" id="zipError">Please enter a valid zip code</div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <div class="error" id="emailError">Please enter a valid email address</div>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description">Description of your health problems and what you need help with</label>
                <textarea name="description" id="description" rows="6" required></textarea>
            </div>

            <!-- Date of Birth -->
            <div class="form-group">
                <label for="DOB">Date of Birth</label>
                <input type="date" name="DOB" id="DOB" required>
            </div>

            <!-- Gender (Styled like nurse form) -->
<div class="form-group select-wrapper">
    <label for="gender">Gender</label>
    <select name="gender" id="gender" required>
        <option value="">Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="non-binary">Non-Binary</option>
        <option value="prefer-not-to-say">Prefer not to say</option>
    </select>
    <span class="dropdown-arrow">▼</span>
</div>


            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <div class="error" id="passwordError">Password must be at least 8 characters</div>
            </div>

            <div class="form-actions">
                <button type="submit">Register</button>
                <p class="patient-login">Already have an account? <a href="../../Views/PatientLogin/patientLogin.php">Login</a></p>
            </div>
        </form>
    </div>

    <script src="../../Views/javascript/register-script.js"></script>
</body>
</html>