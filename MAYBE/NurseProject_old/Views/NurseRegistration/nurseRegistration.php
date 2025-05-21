<?php $PATH = $_SERVER['SCRIPT_NAME']; 
$basePath = '/NurseProject';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account</title>
    <link rel="stylesheet" href="/NurseProject/Views/styles/nurseRegistration.css">
</head>
<body>
    <div class="form-container">
        <h2>Create an Account</h2>
        <?php if (!empty($error)): ?>
            <div class="form-error" style="background-color: #ffe6e6; color: #cc0000; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form id="registrationForm" method="POST" action="<?php echo $basePath; ?>/nurse/register">
            <div class="form-section">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" name="firstName" id="firstName" required>
                    <div class="error" id="firstNameError"></div>
                </div>

                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" name="lastName" id="lastName" required>
                    <div class="error" id="lastNameError"></div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                    <div class="error" id="emailError"></div>
                </div>

                <div class="form-group">
                    <label for="description">Description of how you want the patient to visualize you</label>
                    <textarea name="description" id="description" rows="6" required></textarea>
                    <div class="error" id="descriptionError"></div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                    <div class="error" id="passwordError"></div>
                </div>

                <div class="form-group">
                    <label for="DOB">Date of Birth</label>
                    <input type="date" name="DOB" id="DOB" required>
                    <div class="error" id="DOBError"></div>
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="non-binary">Non-Binary</option>
                        <option value="prefer-not-to-say">Prefer not to say</option>
                    </select>
                    <div class="error" id="genderError"></div>
                </div>

                <div class="form-group">
                    <label for="yearsExperience">Years of Experience</label>
                    <input type="text" name="yearsExperience" id="yearsExperience" required>
                    <div class="error" id="yearsExperienceError"></div>
                </div>

                <div class="form-group">
                    <label for="licenseNumber">License Number</label>
                    <input type="text" name="licenseNumber" id="licenseNumber" required>
                    <div class="error" id="licenseNumberError"></div>
                </div>

                <div class="form-group">
                    <label for="zipCode">Zip Code</label>
                    <input type="text" name="zipCode" id="zipCode" required>
                    <div class="error" id="zipCodeError"></div>
                </div>

                <div class="form-group">
                    <label for="schedule">Available Schedule</label>
                    <input type="text" name="schedule" id="schedule" required>
                    <div class="error" id="scheduleError"></div>
                </div>
            </div>

            <div class="payment-section">
                <h2>Register Payment</h2>
                <div class="form-section">
                    <div class="form-group">
                        <label for="cardName">Name on the Card</label>
                        <input type="text" name="cardName" id="cardName" required>
                        <div class="error" id="cardNameError"></div>
                    </div>

                    <div class="form-group">
                        <label for="cardNumber">Card Number</label>
                        <input type="text" name="cardNumber" id="cardNumber" required>
                        <div class="error" id="cardNumberError"></div>
                    </div>

                    <div class="card-info">
                        <div class="form-group">
                            <label for="expireDate">Expire Date</label>
                            <input type="text" name="expireDate" id="expireDate" placeholder="mm/yy" required>
                            <div class="error" id="expireDateError"></div>
                        </div>

                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" name="cvv" id="cvv" required>
                            <div class="error" id="cvvError"></div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit">Register</button>
                        <p class="nurse-login">Already have an account?
                            <a href="<?php echo $basePath; ?>/nurse/login">Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="/NurseProject/Views/javascript/nurse-registration.js" defer></script>
</body>
</html>