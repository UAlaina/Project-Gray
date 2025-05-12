<?php
include_once "Controllers/Controller.php";
include_once "Models/Nurses.php";
include_once "Models/Users.php";

class NurseController extends Controller {

    public function route() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        global $controller;
        $action = isset($_GET['action']) ? $_GET['action'] : "login";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        switch ($action) {

            case "list":
                $patients = Nurse::getPatients(true);
                $this->render($controller, "patients", ["patients" => $patients]);
                break;

            case "view":
                if ($id > 0) {
                    $userDetails = Nurse::getUserDetails($id);
                    $this->render($controller, "userDetails", ["userDetails" => $userDetails]);
                } else {
                    error_log("❌ Invalid patient ID for view");
                    header("Location: index.php?controller=nurse&action=list");
                    exit();
                }
                break;

            case "register":
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $success = Nurse::register($_POST);

                    if ($success) {
                        $_SESSION['success'] = "Nurse registered successfully!";
                        $_SESSION['user_email'] = $_POST['email'];
                        $_SESSION['user_type'] = 'nurse';
                        header("Location: index.php?controller=nurse&action=mainpage");
                        exit();
                    } else {
                        header("Location: index.php?controller=nurse&action=register");
                        exit();
                    }
                } else {
                    $this->render("NurseRegistration", "nurseRegistration", []);
                }
                break;

            case "login":
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $email = trim($_POST['email']);
                    $password = trim($_POST['password']);

                    $user = Nurse::authenticate($email, $password);

                    if ($user) {
                        $_SESSION['user_id'] = $user->Id;
                        $_SESSION['user_email'] = $user->email;
                        $_SESSION['user_type'] = 'nurse';
                        header("Location: index.php?controller=nurse&action=mainpage");
                        exit();
                    } else {
                        $_SESSION['error'] = "Invalid email or password.";
                        header("Location: index.php?controller=nurse&action=login");
                        exit();
                    }
                } else {
                    $this->render("NurseLogin", "nurselogin", []);
                }
                break;

            case "mainpage":
                $patients = Nurse::getPatients(true);
                $this->render("NurseMainPage", "NurseMainPage", ["patients" => $patients]);
                break;

            case "logout":
                session_destroy();
                header("Location: index.php?controller=nurse&action=login");
                exit();
                break;

            default:
                $this->render("NurseLogin", "nurselogin", []);
                break;
        }
    }
}
