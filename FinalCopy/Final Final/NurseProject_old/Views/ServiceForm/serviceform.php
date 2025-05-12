<?php
$PATH = $_SERVER['SCRIPT_NAME'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Service Form</title>
    <link rel="stylesheet" href="/NurseProject/Views/styles/serviceformstyles.css">
</head>
<body>
<div class="container">
    <h1>Service Form</h1>
        <form action="/NurseProject/index.php?controller=service&action=submitServiceForm" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" id="date" name="date" required>
        </div>

        <div class="form-group">
            <label for="time">Time</label>
            <input type="time" id="time" name="time" required>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" required>
        </div>

        <button type="submit">Submit</button>
    </form>
</div>
</body>
</html>