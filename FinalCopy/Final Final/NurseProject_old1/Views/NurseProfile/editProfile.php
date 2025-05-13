<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'nurse') {
    header("Location: /NurseProject/Views/NurseLogin/nurseLogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Nurse Profile</title>
    <link rel="stylesheet" href="/NurseProject/Views/styles/editProfile.css">
</head>
<body>
<div class="form-container">
    <h2>Edit Your Profile</h2>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="success-message"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="error-message"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
    <?php endif; ?>

    <form method="POST" action="/NurseProject/index.php?controller=nurse&action=updateProfile">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="firstName" value="<?php echo htmlspecialchars($_SESSION['nurse_data']['firstName'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="lastName" value="<?php echo htmlspecialchars($_SESSION['nurse_data']['lastName'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['nurse_data']['email'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>Zip Code</label>
            <input type="text" name="zipCode" value="<?php echo htmlspecialchars($_SESSION['nurse_data']['zipCode'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>Gender</label>
            <select name="gender" required>
                <option value="">Select</option>
                <option value="male" <?php if (strtolower($_SESSION['nurse_data']['gender']) === 'male') echo 'selected'; ?>>Male</option>
                <option value="female" <?php if (strtolower($_SESSION['nurse_data']['gender']) === 'female') echo 'selected'; ?>>Female</option>
                <option value="other" <?php if (strtolower($_SESSION['nurse_data']['gender']) === 'other') echo 'selected'; ?>>Other</option>
            </select>
        </div>
        <div class="form-group">
            <label>DOB</label>
            <input type="date" name="DOB" value="<?php echo htmlspecialchars($_SESSION['nurse_data']['DOB'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label>Schedule</label>
            <input type="text" name="schedule" value="<?php echo htmlspecialchars($_SESSION['nurse_data']['schedule'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label>Years of Experience</label>
            <input type="number" name="years_experience" value="<?php echo htmlspecialchars($_SESSION['nurse_data']['years_experience'] ?? 0); ?>" min="0">
        </div>
        <div class="form-group">
            <label>Info / About Me</label>
            <textarea name="info" rows="4"><?php echo htmlspecialchars($_SESSION['nurse_data']['info'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label>New Password (optional)</label>
            <input type="password" name="password">
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password">
        </div>
        <div class="form-actions">
            <button type="submit">Save Changes</button>
            <a href="/NurseProject/index.php?controller=nurse&action=mainpage" class="cancel-btn">Cancel</a>
        </div>
    </form>

    <div class="delete-section">
        <h3>Deactivate Account</h3>
        <p>You can deactivate your account. You will be removed from nurse listings. To reactivate, simply log in again.</p>
        <button type="button" class="delete-btn" id="deleteAccountBtn">Deactivate My Account</button>
        <form id="deleteAccountForm" method="POST" action="/NurseProject/index.php?controller=nurse&action=deleteProfile" style="display:none;">
            <input type="hidden" name="confirm_delete" value="yes">
        </form>
    </div>

    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <h3>Confirm Account Deactivation</h3>
            <p>Are you sure you want to deactivate your account? You can reactivate it later by logging back in.</p>
            <div class="modal-buttons">
                <button id="confirmDelete" class="delete-btn">Yes, Deactivate My Account</button>
                <button id="cancelDelete" class="cancel-btn">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script src="/NurseProject/Views/javascript/editProfile.js"></script>
</body>
</html>
