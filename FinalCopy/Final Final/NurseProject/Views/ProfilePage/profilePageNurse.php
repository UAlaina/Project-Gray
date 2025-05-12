<?php
include_once "Models/Feedback.php";
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
            <span class="back-btn" onclick="window.location.href='index.php?controller=nurse&action=mainpage'">←</span>
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

                    <!-- Nurses cannot see patient rating -->
                </div>
            </div>

            <div class="description-section">
                <h3>Problem:</h3>
                <div class="description-box">
                    <?php echo htmlspecialchars($profileData['problem'] ?? 'No problem description available.'); ?>
                </div>
            </div>

            <!-- Reviews section hidden for nurses -->
            <!-- <div class="reviews-section"> ... </div> -->

            <div class="actions">
                <div class="action-row">
                    Would you like to communicate with this patient?
                    <button class="btn btn-primary" onclick="location.href='index.php?controller=chat&action=create&patientId=<?php echo $patientId; ?>'">Chat</button>
                     <!-- <button class="btn btn-primary"?>Chat</button> -->
                </div>

                <div class="action-row">
                    Would you like to create a service form for this patient?
                    <button class="btn btn-secondary" onclick="location.href='/NurseProject/Views/ServiceForm/servicePopUp.php'">Service Form</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
