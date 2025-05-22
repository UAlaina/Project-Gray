<?php
$PATH = $_SERVER['SCRIPT_NAME'];
$basePath = '/NurseProject';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nurse Login</title>
    <link rel="stylesheet" href="/NurseProject/Views/styles/nurselogin.css">
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h1>Nurse Login</h1>
            <form action="<?php echo $basePath; ?>/nurse/login" method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                    <span class="error" id="emailError"></span>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-field">
                        <input type="password" id="password" name="password" required>
                        <button type="button" id="togglePassword" aria-label="Toggle password visibility">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    <span class="error" id="passwordError"></span>
                </div>
                
                <div class="form-options">
                   <a href="/NurseProject/forgot-password" class="forgot-password">Forgot Password?</a>
                </div>
                
                <div class="form-actions">
                    <button type="submit" id="loginBtn">Login</button>
                    <p class="nurseRegister-link">Not registered yet? <a href="<?php echo $basePath; ?>/nurse/register">Register here</a></p>
                    <p class="patient-login">Patient? <a href="<?php echo $basePath; ?>/patient/login">Login</a></p>
                </div>
            </form>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-message" style="color: red;">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="/NurseProject/Views/javascript/nurse-login.js"></script>
</body>
</html>