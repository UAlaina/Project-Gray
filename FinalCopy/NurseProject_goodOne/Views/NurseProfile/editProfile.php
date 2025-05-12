<?php
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'nurse') {
    header("Location: /NurseProject/Views/NurseLogin/nurseLogin.php");
    exit();
}

echo "<pre style='display:none;'>";
print_r($_SESSION['nurse_data']);
echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="/NurseProject/Views/styles/editProfile.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Your Profile</h2>
        
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="success-message"><?php echo $_SESSION['success_message']; ?></div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="error-message"><?php echo $_SESSION['error_message']; ?></div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
        
        <form method="POST" action="/NurseProject/index.php?controller=nurse&action=updateProfile">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <div class="form-section">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" name="firstName" id="firstName" value="<?php echo htmlspecialchars($_SESSION['nurse_data']['firstName'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" name="lastName" id="lastName" value="<?php echo htmlspecialchars($_SESSION['nurse_data']['lastName'] ?? ''); ?>" required>
                </div>
            </div>

            <div class="form-section">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($_SESSION['nurse_data']['email'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="zipCode">Zip Code</label>
                    <input type="text" name="zipCode" id="zipCode" value="<?php echo htmlspecialchars($_SESSION['nurse_data']['zipCode'] ?? ''); ?>" required>
                </div>
            </div>

            <div class="form-section">
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male" <?php echo (isset($_SESSION['nurse_data']['gender']) && strtolower($_SESSION['nurse_data']['gender']) == 'male') ? 'selected' : ''; ?>>Male</option>
                        <option value="female" <?php echo (isset($_SESSION['nurse_data']['gender']) && strtolower($_SESSION['nurse_data']['gender']) == 'female') ? 'selected' : ''; ?>>Female</option>
                        <option value="other" <?php echo (isset($_SESSION['nurse_data']['gender']) && strtolower($_SESSION['nurse_data']['gender']) == 'other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="DOB">Date of Birth</label>
                    <input type="date" name="DOB" id="DOB" value="<?php echo htmlspecialchars($_SESSION['nurse_data']['DOB'] ?? ''); ?>">
                </div>
            </div>

            <div class="form-section">
                <div class="form-group">
                    <label for="licenseNumber">License Number (Not Editable)</label>
                    <input type="text" id="licenseNumber" value="<?php echo htmlspecialchars($_SESSION['nurse_data']['licenseNumber'] ?? ''); ?>" readonly>
                    <input type="hidden" name="licenseNumber" value="<?php echo htmlspecialchars($_SESSION['nurse_data']['licenseNumber'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="schedule">Available Schedule</label>
                    <input type="text" name="schedule" id="schedule" value="<?php echo htmlspecialchars($_SESSION['nurse_data']['schedule'] ?? ''); ?>">
                </div>
            </div>

            <div class="form-section">
                <div class="form-group">
                    <label for="years_experience">Years of Experience</label>
                    <input type="number" name="years_experience" id="years_experience" value="<?php echo htmlspecialchars($_SESSION['nurse_data']['years_experience'] ?? ''); ?>" min="0">
                </div>
            </div>

            <div class="form-section">
                <div class="form-group">
                    <label for="info">About Me / Professional Info</label>
                    <textarea name="info" id="info" rows="4"><?php echo htmlspecialchars($_SESSION['nurse_data']['info'] ?? ''); ?></textarea>
                </div>
            </div>

            <div class="form-section">
                <div class="form-group">
                    <label for="password">New Password (leave blank to keep current)</label>
                    <input type="password" name="password" id="password">
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Save Changes</button>
                <a href="/NurseProject/index.php?controller=nurse&action=mainpage" class="cancel-btn">Cancel</a>
            </div>
        </form>
        
        <div class="delete-section">
            <h3>Delete Account</h3>
            <p>Warning: This action cannot be undone. All your data will be permanently deleted.</p>
            <button type="button" class="delete-btn" id="deleteAccountBtn">Delete My Account</button>
            <form id="deleteAccountForm" method="POST" action="/NurseProject/index.php?controller=nurse&action=deleteProfile" style="display:none;"></form>
        </div>

        <div id="confirmationModal" class="modal">
            <div class="modal-content">
                <h3>Confirm Account Deletion</h3>
                <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                <div class="modal-buttons">
                    <button id="confirmDelete" class="delete-btn">Yes, Delete My Account</button>
                    <button id="cancelDelete" class="cancel-btn">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="/NurseProject/Views/javascript/editProfile.js"></script>
</body>
</html>