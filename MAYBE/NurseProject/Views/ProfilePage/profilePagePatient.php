<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "Models/Feedback.php";

function displayStars($rating) {
    $stars = '';
    $rating = floatval($rating);

    $fullStars = floor($rating);
    for ($i = 1; $i <= $fullStars; $i++) {
        $stars .= '<span class="star filled">★</span>';
    }

    if ($rating - $fullStars >= 0.5) {
        $stars .= '<span class="star half-filled">★</span>';
        $i++;
    }

    for (; $i <= 5; $i++) {
        $stars .= '<span class="star">☆</span>';
    }

    return $stars . ' <span class="rating-number">' . number_format($rating, 1) . '</span>';
}

// Ensure profile data exists
if (!isset($profileData)) {
    die("Error: No profile data available.");
}

$nurseId = $profileData['id'] ?? $profileData['NurseID'] ?? 0;

$feedbackList = Feedback::getFeedbackByNurseId($nurseId);
$averageRating = Feedback::getAverageRatingByNurseId($nurseId);

$basePath = '/NurseProject';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Page of Nurse</title>
    <link rel="stylesheet" href="/NurseProject/Views/styles/profilePagePatient.css">
</head>
<body>
    <div class="profile-container">
        <div class="header">
            <span class="back-btn" onclick="window.location.href='/NurseProject/patient/mainpage'">←</span>
            Profile Page of Nurse
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
                        <div class="detail-item">
                            <label>Years Of Experience</label>
                            <span><?php echo isset($profileData['years_experience']) ? htmlspecialchars($profileData['years_experience']) : 'N/A'; ?></span>
                        </div>
                    </div>

                    <div class="stars">
                        <?php echo displayStars($averageRating); ?>
                        <span class="review-count">(<?php echo count($feedbackList); ?> reviews)</span>
                    </div>
                </div>
            </div>

            <div class="description-section">
                <h3>Description:</h3>
                <div class="description-box">
                    <?php echo htmlspecialchars($profileData['info']); ?>
                </div>
            </div>

            <div class="reviews-section">
                <h3>Reviews:</h3>

                <?php if (count($feedbackList) > 0): ?>
                    <div class="reviews-list">
                        <?php foreach ($feedbackList as $feedback): ?>
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="reviewer-name">
                                      <?php echo htmlspecialchars($feedback->clientName); ?>
                                  </div>

                                  <div class="review-date"><?php echo date('M d, Y', strtotime($feedback->createdAt)); ?></div>
                              </div>
                              <div class="review-stars">
                                <?php echo displayStars($feedback->rating); ?>
                            </div>
                            <?php if (!empty($feedback->description)): ?>
                                <div class="review-text">
                                    <?php echo htmlspecialchars($feedback->description); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-reviews">No reviews yet.</p>
            <?php endif; ?>
        </div>

        <div class="actions">
            <div class="action-row">
                Would you like to book an appointment with them?
                <form method="POST" action="/NurseProject/chat/start">
                    <input type="hidden" name="clientId" value="<?php echo $_SESSION['user_id']; ?>">
                    <input type="hidden" name="nurseId" value="<?php echo $nurseId; ?>">
                    <input type="hidden" name="serviceCode" value="GEN-CHAT">
                    <button type="submit" class="btn btn-primary">Chat</button>
                </form>

            </div>

            <div class="action-row">
                Would you like to give feedback?
                <button class="btn btn-secondary" onclick="location.href='/NurseProject/feedback/form/<?= $nurseId ?>'"
                    >Feedback</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
