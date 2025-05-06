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
                $patients = Nurse::getPatients();
                $this->render($controller, "patients", $patients);
                break;

            case "view":
                if ($id > 0) {
                    $userDetails = Nurse::getUserDetails($id);
                    $this->render($controller, "userDetails", $userDetails);
                } else {
                    header("Location: http://localhost/NurseProject/index.php?controller=nurse&action=list");
                    exit();
                }
                break;

            case "register":
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Process the submitted form data
                    $data = [
                        'firstName' => $_POST['firstName'] ?? '',
                        'lastName' => $_POST['lastName'] ?? '',
                        'email' => $_POST['email'] ?? '',
                        'password' => $_POST['password'] ?? '',
                        'DOB' => $_POST['DOB'] ?? '',
                        'gender' => $_POST['gender'] ?? '',
                        'zipCode' => $_POST['zipCode'] ?? '',
                        'description' => $_POST['description'] ?? '',
                        'licenseNumber' => $_POST['licenseNumber'] ?? '',
                        'schedule' => $_POST['schedule'] ?? '',
                        'yearsExperience' => $_POST['yearsExperience'] ?? 0,
                        'specialitiesGoodAt' => isset($_POST['specialitiesGoodAt']) ? $_POST['specialitiesGoodAt'] : 'General Care',
                        'registrationFee' => isset($_POST['registrationFee']) ? $_POST['registrationFee'] : 0,
                    ];
                    
                    $success = Nurse::register($data);
                    
                    if ($success) {
                        // Redirect to login page after successful registration
                        header("Location: index.php?controller=nurse&action=login");
                        exit();
                    } else {
                        // Handle registration failure
                        $_SESSION['error'] = "Registration failed. Please try again.";
                        header("Location: index.php?controller=nurse&action=register");
                        exit();
                    }
                } else {
                    $this->render("NurseRegistration", "nurseregistrationform", []);
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

                        header("Location: http://localhost/NurseProject/Views/NurseMainPage/NurseMainPage.php");
                        exit();
                    } else {
                        $_SESSION['error'] = "Invalid email or password.";

                        header("Location: http://localhost/NurseProject/index.php?controller=nurse&action=login");
                        exit();
                    }
                } else {
                    $this->render("NurseLogin", "nurselogin", []);
                }
                break;

            case "mainpage":
                $patients = Nurse::getAllPatients();
                $this->render($controller, "mainpage", $patients);
                break;

            case "logout":
                session_destroy();
                header("Location: http://localhost/NurseProject/index.php?controller=nurse&action=login");
                exit();
                break;

            default:
                $this->render("NurseLogin", "nurselogin", []);
                break;
        }
    }
}
?>