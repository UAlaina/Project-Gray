<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "nurserysystem";
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT u.firstName, u.lastName, n.gender, u.zipCode, n.years_experience 
        FROM nurse n
        JOIN users u ON n.NurseID = u.Id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nurses List</title>
    <link rel="stylesheet" href="PatientMainPage.css">
</head>
<body>
    <header class="top-bar">
        <div class="left-section">
            <div class="logo">
                <img src="logo.png" alt="Company Logo">
            </div>
            <input type="text" id="search" placeholder="Search by zipcode/city">
        </div>
        
        <nav>
            <a href="#">Chats</a>
            <a href="#">Payment</a>
            <div class="profile-icon" id="profileIcon">
                <img src="icon.jpg" alt="Profile">
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="#">Log Out</a>
                    <a href="#">Edit Profile</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <h1>Nurses</h1>
        <div class="container">
            <?php if ($result->num_rows > 0): ?>
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

    <script src="PatientMainPage.js"></script>
</body>
</html>

<?php $conn->close(); ?>
