<?php
session_start();

include_once "Models/Users.php";
include_once "Controllers/Controller.php";

class DefaultController extends Controller {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Both fields are required.";
            header("Location: nurselogin.php");
            exit();
        }

        $stmt = $pdo->prepare("SELECT * FROM nurses WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $nurse = $stmt->fetch();

        if ($nurse && password_verify($password, $nurse['password'])) {
            $_SESSION['nurse_id'] = $nurse['id'];
            header("Location: nurse_dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password.";
            header("Location: nurselogin.php");
            exit();
        }
    }
}
?>
