<?php
$PATH = $_SERVER['SCRIPT_NAME'];

$today = date('Y-m-d');

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
        <form action="/NurseProject/service/submit" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" id="date" name="date" required min = "<?php echo $today;?>">
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
    <script>
    const dateInput = document.getElementById('date');
    const timeInput = document.getElementById('time');

    function setMinTime() {
        const selectedDate = new Date(dateInput.value);
        const today = new Date();

        if (!dateInput.value) {
            timeInput.min = '';
            return;
        }

        if (
            selectedDate.getFullYear() === today.getFullYear() &&
            selectedDate.getMonth() === today.getMonth() &&
            selectedDate.getDate() === today.getDate()
        ) {
            let hours = today.getHours();
            let minutes = today.getMinutes();

            let formattedTime = (hours < 10 ? '0' : '') + hours + ':' + (minutes < 10 ? '0' : '') + minutes;
            timeInput.min = formattedTime;
        } else {
            timeInput.min = '';
        }
    }

    dateInput.addEventListener('change', setMinTime);
    window.addEventListener('load', setMinTime);
</script>

</div>
</body>
</html>