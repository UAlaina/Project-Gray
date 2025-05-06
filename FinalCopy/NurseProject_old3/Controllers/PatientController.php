<?php
include_once "Controllers/Controller.php";
include_once "Models/Patients.php";
include_once "Models/Users.php";

class PatientController extends Controller {

    public function route() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        global $controller;
        $action = isset($_GET['action']) ? $_GET['action'] : "login";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        switch ($action) {

            case "list":
                $nurses = Patients::getNurses();
                $this->render($controller, "nurses", $nurses);
                break;

            case "services":
                $services = Patients::getServices();
                $this->render($controller, "services", $services);
                break;

            case "view":
                if ($id > 0) {
                    $userDetails = Patients::getUserDetails($id);
                    $this->render($controller, "userDetails", $userDetails);
                } else {
                    header("Location: http://localhost/NurseProject/index.php?controller=patient&action=list");
                    exit();
                }
                break;

            case "register":
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $success = Patients::register($_POST);
                    if ($success) {
                        header("Location: http://localhost/NurseProject/index.php?controller=patient&action=login");
                        exit();
                    } else {
                        echo "Registration failed. Try again.";
                    }
                } else {
                    $this->render($controller, "register", []);
                }
                break;

            case "login":
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $email = trim($_POST['email']);
                    $password = trim($_POST['password']);

                    $user = Patients::authenticate($email, $password);

                    if ($user) {
                        $_SESSION['user_id'] = $user->id;
                        $_SESSION['user_email'] = $user->email;

                        header("Location: http://localhost/NurseProject/Views/PatientMainPage/PatientMainPage.php");
                        exit();
                    } else {
                        $_SESSION['error'] = "Invalid email or password.";

                        header("Location: http://localhost/NurseProject/index.php?controller=patient&action=login");
                        exit();
                    }
                } else {
                    $this->render("PatientLogin", "patientlogin", []);
                }
                break;

            case "mainpage":
                $nurses = Patients::getAllNurses();
                $this->render($controller, "mainpage", $nurses);
                break;

            case "logout":
                session_destroy();
                header("Location: http://localhost/NurseProject/index.php?controller=patient&action=login");
                exit();
                break;
        }
    }
}
