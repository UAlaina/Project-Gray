<?php
$PATH = $_SERVER['SCRIPT_NAME'];
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Login</title>
    <link rel="stylesheet" href="Views/styles/patientlogin.css">
</head>
<body>
    <div class="container">
        <h1>Patient Login</h1>
        <form id="loginForm">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <div class="error" id="emailError">Please enter a valid email address</div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <div class="error" id="passwordError">Please enter your password</div>
            </div>
            
            <div class="remember-forgot">
                <div class="remember">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember" class="checkbox-label">Remember me</label>
                </div>
                <a href="#" class="forgot-link">Forgot password?</a>
            </div>
            
            <button type="submit">Log In</button>
        </form>
        
        <div class="register-link">
            <p>Don't have an account? <a href="clientRegistration.html">Register</a></p>
        </div>

        <div class="nurse-link">
            <p>Nurse? <a href="nurselogin.html">Register</a></p>
        </div>
    </div>

    <script src="Views/javascript/login-script.js"></script>
</body>
</html>