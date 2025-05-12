<?php session_start(); ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients List</title>
    <link rel="stylesheet" href="../../Views/styles/NurseMainPage.css">
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
        <h1>Patients</h1>
        <div class="container">
            <?php if (isset($result) && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="patient-card">
                        <div class="initials">
                            <?php echo strtoupper(substr($row['firstName'], 0, 1) . substr($row['lastName'], 0, 1)); ?>
                        </div>
                        <div class="info">
                            <div class="details">
                                <?php echo $row['firstName'] . ' ' . $row['lastName'] . "<br>"; ?>
                                <?php echo ucfirst($row['zipCode']) . "<br>"; ?>
                                <?php echo ucfirst($row['problem']); ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No Patients found.</p>
            <?php endif; ?>
        </div>
    </main>

    <button class="dark-mode">Dark Mode</button>

    <script src="../../Views/javascript/NurseMainPage.js"></script>
</body>
</html>
