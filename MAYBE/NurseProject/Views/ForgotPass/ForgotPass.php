<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/src/Exception.php';
require 'mailer/src/PHPMailer.php';
require 'mailer/src/SMTP.php';

$message = ''; 

if (isset($_POST['forgot'])) {
    $email = $_POST['email'];

    $conn = new mysqli("localhost", "root", "", "nurserysystem");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($password);
        $stmt->fetch();

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';  
            $mail->SMTPAuth   = true;
            $mail->Username   = 'nurserywebsystem@gmail.com';  
            $mail->Password   = 'jfxn wtck joja jwqm';  
            $mail->SMTPSecure = 'tls';  
            $mail->Port       = 587;

            $mail->setFrom('nurserywebsystem@gmail.com', 'Nursery App System');
            $mail->addAddress($email);  
            $mail->Subject = 'Password Recovery';
            $mail->Body    = "Hello,\n\nYour password is: $password\n\n- Nursery App System";

            $mail->send();
            $message = "Password sent to your email!";
        } catch (Exception $e) {
            $message = "Mail Error: {$mail->ErrorInfo}";
        }

    } else {
        $message = "Email not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="/NurseProject/Views/styles/ForgotPass.css">
</head>
<body>
    <div class="container">
    <img src="/NurseProject/Views/images/lock.png" alt="lock" class="lock-img">
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
