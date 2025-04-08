<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "nurserysystem";
$conn = new mysqli($host, $user, $password, $database); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} //use model.php for the connection

$sql = "SELECT u.firstName, u.lastName, u.zipCode, p.problem 
        FROM patients p
        JOIN users u ON p.patientID = u.Id";
$result = $conn->query($sql);
?> 
<!-- use the patients.php, only select the ones that are isActive = 1 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients List</title>
    <link rel="stylesheet" href="NurseMainPage.css">
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
            <div class="profile-icon" id="profileIcon">
                <img src="icon.jpg" alt="Profile">
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="#">Log Out</a> 
                    <!-- log out should send them to default page -->
                    <a href="#">Edit Profile</a>
                    <!-- should send to edit profile which is similar to register -->
                    <a href="#">Deactivate</a> 
                    <!-- is active to 0, add the new files in the new location-->
                </div>
            </div>
        </nav>
    </header>

    <main>
        <h1>Patients</h1>
        <div class="container">
            <?php if ($result->num_rows > 0): ?>
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

    <script src="NurseMainPage.js"></script>
</body>
</html>

<?php $conn->close(); ?>
