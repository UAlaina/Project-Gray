<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nurses List</title>
    <link rel="stylesheet" href="../../Views/styles/PatientMainPage.css">
</head>
<body>
    <header class="top-bar">
        <div class="left-section">
            <div class="logo">
                <img src="../../Views/images/logo.png" alt="Company Logo">
            </div>
            <input type="text" id="search" placeholder="Search by zipcode/city">
        </div>
        
        <nav>
            <a href="#">Chats</a>
            <a href="../../Views/Payment/Payment.php">Payment</a>
            <div class="profile-icon" id="profileIcon">
                <img src="../../Views/images/icon.jpg" alt="Profile">
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="../../Views/default/default.php">Log Out</a>
                    <a href="#">Edit Profile</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <h1>Nurses</h1>
        <div class="container">
            <?php if (isset($result) && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="nurse-card">
                        <div class="initials">
                            <?php echo strtoupper(substr($row['firstName'], 0, 1) . substr($row['lastName'], 0, 1)); ?>
                        </div>
                        <div class="info">
                            <div class="name"><?php echo $row['firstName'] . " " . $row['lastName']; ?></div>
                            <div class="details"><?php echo ucfirst($row['gender']); ?></div>
                        </div>
                        <div class="extra">
                            <div class="details">Years of experience: <?php echo $row['years_experience']; ?></div>
                            <div class="details">Zip Code: <?php echo $row['zipCode']; ?></div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No nurses found.</p>
            <?php endif; ?>
        </div>
    </main>

    <button class="dark-mode">Dark Mode</button>

    <script src="../../Views/javascript/PatientMainPage.js"></script>

    <footer>
      <div class="footer-content">
        <div class="footer-logo">
          <!-- <img src="<?php echo $basePath; ?>/Views/images/logo.png" alt="HomeCare Service Logo" /> -->
        </div>
        <div class="footer-links">
          <h3>Quick Links</h3>
          <ul>
            <li><a href="<?php echo $basePath; ?>/default">Home</a></li>
            <li><a href="<?php echo $basePath; ?>/default/services">Services</a></li>
            <li><a href="<?php echo $basePath; ?>/default/nurses">Our Nurses</a></li>
            <li><a href="<?php echo $basePath; ?>/Views/php/nurseRegistration.php">Join Our Team</a></li>
          </ul>
        </div>
        <div class="footer-contact">
          <h3>Contact Us</h3>
          <p>Email: contact@homecare.com</p>
          <p>Phone: (123) 456-7890</p>
        </div>
      </div>
      <div class="copyright">
        <p>&copy; <?php echo date('Y'); ?> HomeCare Service. All rights reserved.</p>
      </div>
    </footer>
</body>
</html>
