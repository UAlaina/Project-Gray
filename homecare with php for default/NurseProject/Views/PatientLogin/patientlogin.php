<?php
session_start();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Login</title>
    <link rel="stylesheet" href="/NurseProject/Views/styles/patientlogin.css">
</head>
<body>
    <div class="container">
        <h1>Patient Login</h1>
        <form action="patientlogin_controller.php" method="POST" id="loginForm">
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

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message" style="color: red;">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <div class="register-link">
            <p>Don't have an account? <a href="clientRegistration.php">Register</a></p>
        </div>

        <div class="nurse-link">
            <p>Nurse? <a href="NurseProject/Views/NurseLogin/nurseLogin.php">Login</a></p>
        </div>
    </div>

    <script src="Views/javascript/login-script.js"></script>
</body>
</html>
