<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/src/Exception.php';
require 'mailer/src/PHPMailer.php';
require 'mailer/src/SMTP.php';

$message = ''; 

if (isset($_POST['forgot'])) {
    $email = $_POST['email'];

    // Database connection
    $conn = new mysqli("localhost", "root", "", "nurserysystem", 3307);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL to retrieve the user's password based on the provided email
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // If email is found in the database, send password recovery email
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($password);
        $stmt->fetch();

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';  
            $mail->SMTPAuth   = true;
            $mail->Username   = 'nurserywebsystem@gmail.com';  // Use your Gmail address
            $mail->Password   = 'mvnn ifin jblh sfuc';  // Use the generated app password from Google
            $mail->SMTPSecure = 'tls';  // Use TLS encryption
            $mail->Port       = 587;

            // Sender and recipient details
            $mail->setFrom('nurseryappsystem@gmail.com', 'Nursery App System');
            $mail->addAddress($email);  // Add the recipient's email address
            $mail->Subject = 'Password Recovery';
            $mail->Body    = "Hello,\n\nYour password is: $password\n\n- Nursery App System";

            // Send the email
            $mail->send();
            $message = "✅ Password sent to your email!";
        } catch (Exception $e) {
            $message = "❌ Mail Error: {$mail->ErrorInfo}";
        }

    } else {
        $message = "❌ Email not found.";
    }

    // Close database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../../Views/styles/ForgotPass.css">
</head>
<body>
    <div class="container">
        <img src="../../Views/images/lock.png" alt="lock" class="lock-img">
        <h2>Forgot Password?</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit" name="forgot">Send to my email</button>
        </form>

        <div class="message <?= $message ? 'visible' : '' ?>">
            <?= $message ?>
        </div>
    </div>
</body>
</html>
