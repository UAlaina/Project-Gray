<?php
session_start();
include_once "Models/Users.php";
include_once "Controllers/Controller.php";

class NurseLoginController extends Controller {

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Both fields are required.";
                header("Location: nurselogin.php");
                exit();
            }

            $user = Users::authenticate($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_email'] = $user->email;
                header("Location: nurse_dashboard.php");
                exit();
            } else {
                $_SESSION['error'] = "Invalid email or password.";
                header("Location: nurselogin.php");
                exit();
            }
        }
    }
}
?>
