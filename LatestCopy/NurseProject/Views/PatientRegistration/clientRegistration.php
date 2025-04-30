<?php
$PATH = $_SERVER['SCRIPT_NAME'];
?>

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
        <form id="registrationForm">
            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input type="text" id="fullName" name="fullName" required>
                <div class="error" id="nameError">Please enter a valid name</div>
            </div>
            
            <div class="form-group">
                <label for="zipCode">Zip Code</label>
                <input type="text" id="zipCode" name="zipCode" required>
                <div class="error" id="zipError">Please enter a valid zip code</div>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <div class="error" id="emailError">Please enter a valid email address</div>
            </div>

            <div class="form-group">
                    <label for="description">Description of your health problems and what you need help with</label>
                    <textarea name="description" id="description" rows="6" required></textarea>
            </div>

            <div class="form-group">
                    <label for="DOB">Date of Birth</label>
                    <div class="date-input">
                        <input type="date" name="DOB" id="DOB" placeholder="yyyy-mm-dd" required>
                        <!-- <div class="date-icon">📅</div> -->
                    </div>
                </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <div class="select-wrapper">
                    <select name="gender" id="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="non-binary">Non-Binary</option>
                        <option value="prefer-not-to-say">Prefer not to say</option>
                    </select>
                    <div class="dropdown-arrow">▼</div>
                </div>
            </div>
            
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