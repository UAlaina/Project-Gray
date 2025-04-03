<?php
$PATH = $_SERVER['SCRIPT_NAME'];
?>

<html lan="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration</title>
    <link rel="stylesheet" href="Views/styles/serviceformstyles.css">
</head>

<body>
    <div class="container">
        <h1>Service Form</h1>
        <form id="serviceform">
            <div class="form-group">
                <label for="Email">Full Name</label>
                <input type="text" id="email" name="email" required>
                <div class="error" id="nameError">Please enter a valid email address (name@example.com)</div>
            </div>
            
            <div class="form-group">
                <label for="date">Choose a date:</label>
                <input type="date" id="date" name="date"><br><br>

                <label for="time">Choose a time:</label>
                <input type="time" id="time" name="time"><br><br>

                <div class="error" id="timeDatError">please enter the time and date</div>
            </div>
            
            <div class="form-group">
                <label for="address"><Address></Address></label>
                <input type="address" id="address" name="address" required>
                <div class="error" id="addressError">Please enter a valid address</div>
            </div>
            
            <button type="submit">Submit</button>
        </form>
    </div>

    <script src=""></script>
</body>

</html>
