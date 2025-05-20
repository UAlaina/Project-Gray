<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$basePath = '/NurseProject';

$successMsg = '';
if (isset($_SESSION['success_message_reactivation'])) {
    $successMsg = $_SESSION['success_message_reactivation'];
    unset($_SESSION['success_message_reactivation']);
}

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Nurse Main Page</title>
    <link rel="stylesheet" href="/NurseProject/Views/styles/NurseMainPage.css?v=1">
</head>
<?php if (!empty($successMsg)): ?>
<script>
    alert("<?php echo addslashes($successMsg); ?>");
</script>
<?php endif; ?>

<body>
    <div class="page-wrapper">
        <header class="top-bar">
            <div class="left-section">
                <div class="logo">
                    <img src="/NurseProject/Views/images/logo.png" alt="Logo" />
                </div>
                <input type="text" id="search" placeholder="Search patient by name" />
            </div>
            <nav>
                <a href="<?php echo $basePath; ?>/chat/list">Chat</a>
                <a href="#" id="reviewsBtn">My Reviews</a>
                <div class="profile-icon" id="profileIcon">
                    <img src="/NurseProject/Views/images/icon.jpg" alt="Profile" />
                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="<?php echo $basePath; ?>/nurse/login">Log Out</a>
                        <a href="<?php echo $basePath; ?>/nurse/editProfile">Edit Profile</a>
                    </div>
                </div>
            </nav>
        </header>

        <button class="dark-mode" id="darkModeBtn">Dark Mode</button>

        <div id="reviewsModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>My Reviews</h2>
                <div class="reviews-container">
                    <?php 
                    include_once "Models/Feedback.php";
                    $nurseId = $_SESSION['user_id'] ?? 0;
                    $feedbackList = Feedback::getFeedbackByNurseId($nurseId);
                    $averageRating = Feedback::getAverageRatingByNurseId($nurseId);
                    ?>

                    <div class="rating-summary">
                        <h3>Your Average Rating: <?php echo number_format($averageRating, 1); ?></h3>
                        <div class="stars">
                            <?php echo displayStars($averageRating); ?>
                            <span class="review-count">(<?php echo count($feedbackList); ?> reviews)</span>
                        </div>
                    </div>

                    <?php if (count($feedbackList) > 0): ?>
                        <div class="reviews-list">
                            <?php foreach ($feedbackList as $feedback): ?>
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="reviewer-name"><?php echo htmlspecialchars($feedback->clientName); ?></div>
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
                        <p class="no-reviews">You haven't received any reviews yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <main>
            <h1>Patients</h1>
            <div class="container">
                <?php if (!empty($patients)): ?>
                    <?php foreach ($patients as $row): ?>
                        <?php
                        $fullName = strtolower(trim($row->firstName . ' ' . $row->lastName));
                        $dataName = urlencode($fullName);
                        ?>
                        <div class="patient-card" data-name="<?php echo $dataName; ?>">
                            <div class="row">
                                <div class="info">
                                    <div class="icon">
                                        <?php echo strtoupper(substr($row->firstName, 0, 1) . substr($row->lastName, 0, 1)); ?>
                                    </div>
                                    <div>
                                        <?php echo htmlspecialchars($row->firstName . ' ' . $row->lastName); ?><br />
                                        Zip Code: <?php echo htmlspecialchars($row->zipCode); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="about">
                                Problem: <?php echo htmlspecialchars($row->problem); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <p id="noNursesMsg" style="display:none; text-align:center; color:red;">No patients found.</p>
                <?php else: ?>
                    <p>No patients found.</p>
                <?php endif; ?>
            </div>
        </main>

        <footer>
            <div class="footer-content">
                <div class="footer-links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="<?php echo $basePath; ?>/default/home">Home</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h3>Contact Us</h3>
                    <p>Email: nurserywebsystem@gmail.com</p>
                    <p>Phone: (123) 456-7890</p>
                </div>
            </div>
            <div class="copyright">
                &copy; <?php echo date('Y'); ?> HomeCare Service. All rights reserved.
            </div>
        </footer>
    </div>

    <script src="/NurseProject/Views/javascript/NurseMainPage.js?v=1"></script>
</body>
</html>