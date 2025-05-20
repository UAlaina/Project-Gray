<?php
include_once "Models/Feedback.php";

// ✅ Ensure $profileData exists
if (!isset($profileData)) {
    echo "<p style='color:red;'>❌ No patient profile data found.</p>";
    return;
}

// ✅ Safe fallback for patientId
$patientId = $profileData['id'] ?? $profileData['patientID'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Page of Patient</title>
    <link rel="stylesheet" href="/NurseProject/Views/styles/profilePagePatient.css">
</head>
<body>
    <div class="profile-container">
        <div class="header">
            <span class="back-btn" onclick="window.location.href='/NurseProject/nurse/mainpage'">←</span>
            Profile Page of Patient
        </div>

        <div class="profile-content">
            <div class="profile-header">
                <div class="profile-image">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    </svg>
                </div>

                <div class="profile-details">
                    <div class="detail-row">
                        <div class="detail-item">
                            <label>Name</label>
                            <span><?php echo htmlspecialchars($profileData['firstName'] . ' ' . $profileData['lastName']); ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Gender</label>
                            <span><?php echo htmlspecialchars($profileData['gender']); ?></span>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-item">
                            <label>Zip Code</label>
                            <span><?php echo htmlspecialchars($profileData['zipCode']); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="description-section">
                <h3>Problem:</h3>
                <div class="description-box">
                    <?php echo htmlspecialchars($profileData['problem'] ?? 'No problem description available.'); ?>
                </div>
            </div>

            <div class="actions">
                <div class="action-row">
                    Would you like to communicate with this patient?
                    <?php if ($patientId > 0 && isset($_SESSION['user_id'])): ?>
                        <form method="POST" action="index.php?controller=chat&action=startChat">
                            <input type="hidden" name="clientId" value="<?php echo (int) $patientId; ?>">
                            <input type="hidden" name="nurseId" value="<?php echo (int) $_SESSION['user_id']; ?>">
                            <input type="hidden" name="serviceCode" value="GEN-CHAT">
                            <button type="submit" class="btn btn-primary">Chat</button>
                        </form>
                    <?php else: ?>
                        <p style="color:red;">Cannot start chat — patient or session ID is missing.</p>
                    <?php endif; ?>
                </div>



                <div class="action-row">
                    Would you like to create a service form for this patient?
                    <button class="btn btn-secondary" onclick="location.href='/NurseProject/service/form/<?php echo $patientId; ?>'">Service Form</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
