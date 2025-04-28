<?php
$projectRoot = '/FinalCopy/NurseProject/';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration</title>
    <link rel="stylesheet" href="<?php echo $projectRoot; ?>Views/styles/clientregistrationstyle.css">
</head>
<body>
    <div class="container">
        <h1>Patient Registration</h1>
        <form method="POST" action="<?php echo $projectRoot; ?>Views/PatientLogin/patientLogin.php" id="registrationForm">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" required>
            </div>
            
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="DOB">Date of Birth</label>
                <input type="date" id="DOB" name="DOB" required>
            </div>

            <div class="form-group">
                <label for="description">Description of your health problems and what you need help with</label>
                <textarea name="description" id="description" rows="6" required></textarea>
                <!-- <div class="error" id="descriptionError">Please provide a description</div> -->
            </div>

            <div class="form-group">
                <label for="zipCode">Zip Code</label>
                <input type="text" id="zipCode" name="zipCode" required>
                <!-- <div class="error" id="zipCodeError">Please enter a valid zip code</div> -->
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <div class="select-wrapper">
                    <select name="gender" id="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Female">Female</option>
                        <option value="Male">Male</option>
                        <option value="Non-binary">Non-Binary</option>
                        <option value="Prefer not to say">Prefer not to say</option>
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
                <p class="patient-login">Already have an account? 
                    <a href="<?php echo $projectRoot; ?>Views/PatientLogin/patientLogin.php">Login</a>
                </p>
            </div>
        </form>
    </div>

    <script src="<?php echo $projectRoot; ?>Views/javascript/register-script.js"></script>
</body>
</html>
