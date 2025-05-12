<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<pre>";
print_r($_SESSION);
echo "</pre>";

if (!empty($_SESSION['user_id'])) {
    echo "✅ Session is active for user ID: " . $_SESSION['user_id'];
} else {
    echo "❌ No valid session found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Patient Main Page</title>
    <link rel="stylesheet" href="/NurseProject/Views/styles/PatientMainPage.css?v=1">
</head>
<body>
<div class="page-wrapper">

    <header class="top-bar">
        <div class="left-section">
            <div class="logo">
                <img src="/NurseProject/Views/images/logo.png" alt="Logo" />
            </div>
            <input type="text" id="search" placeholder="Search nurse by name" />
        </div>
        <nav>
            <a href="#">Chat</a>
            <a href="/NurseProject/Views/Payment/Payment.php">Payment</a>
            <div class="profile-icon" id="profileIcon">
                <img src="/NurseProject/Views/images/icon.jpg" alt="Profile" />
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="index.php?controller=patient&action=logout">Log Out</a>
                    <a href="index.php?controller=patient&action=editProfile">Edit Profile</a>
                </div>
            </div>
        </nav>
    </header>

    <button class="dark-mode" id="darkModeBtn">Dark Mode</button>
    
    <main>
        <h1>Nurses</h1>
        <div class="container">
            <?php if (!empty($nurses)): ?>
                <?php foreach ($nurses as $row): ?>
                    <?php
                        $fullName = strtolower($row->firstName . ' ' . $row->lastName);
                        $dataName = urlencode($fullName);
                    ?>
                    <div class="nurse-card" data-name="<?php echo $dataName; ?>">
                        <div class="row">
                            <div class="info">
                                <div class="icon">
                                    <?php echo strtoupper(substr($row->firstName, 0, 1) . substr($row->lastName, 0, 1)); ?>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($row->firstName . ' ' . $row->lastName); ?><br />
                                    <?php echo htmlspecialchars(ucfirst($row->gender)); ?>
                                </div>
                            </div>
                            <div>
                                Years of experience: <?php echo htmlspecialchars($row->years_experience); ?><br />
                                Zip Code: <?php echo htmlspecialchars($row->zipCode); ?>
                            </div>
                        </div>
                        <div class="about">
                            <?php echo "About me: " . (!empty($row->info) ? htmlspecialchars($row->info) : "No info available."); ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <p id="noNursesMsg" style="display:none; text-align:center; color:red;">No nurses found.</p>
            <?php else: ?>
                <p>No nurses found.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="/NurseProject/Views/default/default.php">Home</a></li>
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

<script src="/NurseProject/Views/javascript/PatientMainPage.js?v=1"></script>
</body>
</html>
