<?php
include_once "Models/Users.php";
include_once "Controllers/Controller.php";

class DefaultController extends Controller {
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = Users::authenticate($email, $password);

        if ($user !== null && $user->role === 'patient') {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_role'] = $user->role;

            header("Location: patient_dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid email, password, or you're not a patient!";
            header("Location: patientlogin.php");
            exit();
        }
    }
}
?>
