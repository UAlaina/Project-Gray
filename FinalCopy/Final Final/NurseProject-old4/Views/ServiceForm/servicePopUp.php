<?php
$PATH = $_SERVER['SCRIPT_NAME'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Service Pop-Up</title>
    <link rel="stylesheet" href="/NurseProject/Views/styles/servicepopupstyle.css">
</head>
<body>
<div class="popup-container">
    <h3>Do you want to do service for this patient?</h3>

    <form action="/NurseProject/Views/ServiceForm/serviceform.php" method="POST" class="popup-actions">
        <button type="submit" name="service" value="no" class="no-btn">No</button>
        <button type="submit" name="service" value="yes" class="yes-btn">Yes</button>
    </form>
</div>
</body>
</html>
