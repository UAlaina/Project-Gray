<?php
include_once "Models/Users.php";
include_once "Controllers/Controller.php";

class PatientLoginController extends Controller {
    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = Users::authenticate($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_email'] = $user->email;
                $_SESSION['user_role'] = $user->role;

            header("Location: ../../Views/PatientMainPage/PatientMainPage.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid email, password, or you're not a patient!";
            header("Location: /Views/PatientLogin/patientLogin.php");
            exit();
        }
    }
}
?>
