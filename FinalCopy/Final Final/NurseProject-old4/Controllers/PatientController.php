<?php
include_once "Controllers/Controller.php";
include_once "Models/Patients.php";
include_once "Models/Users.php";
include_once "Models/Payment.php";

class PatientController extends Controller {

    public function route() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        global $controller;
        $action = $_GET['action'] ?? "login";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        switch ($action) {
            case "list":
                $nurses = Patients::getNurses();
                $this->render($controller, "nurses", ["nurses" => $nurses]);
                break;

            case "services":
                $services = Patients::getServices();
                $this->render($controller, "services", ["services" => $services]);
                break;

            case "view":
                if ($id > 0) {
                    $userDetails = Patients::getUserDetails($id);
                    $this->render($controller, "userDetails", ["userDetails" => $userDetails]);
                } else {
                    header("Location: index.php?controller=patient&action=list");
                    exit();
                }
                break;

            case "register":
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $success = Patients::register($_POST);
                    if ($success) {
                        $user = Users::authenticate($_POST['email'], $_POST['password']);
                        if ($user) {
                            $_SESSION['user_id'] = $user->id;
                            $_SESSION['user_email'] = $user->email;
                            $_SESSION['user_type'] = 'patient';
                            $_SESSION['token'] = "PATIENT_" . $user->id;
                            session_write_close();
                            header("Location: index.php?controller=patient&action=mainpage");
                            exit();
                        } else {
                            echo "Registration succeeded but login failed.";
                        }
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
                        $_SESSION['user_type'] = 'patient';
                        $_SESSION['token'] = "PATIENT_" . $user->id;
                        session_write_close();
                        header("Location: index.php?controller=patient&action=mainpage");
                        exit();
                    } else {
                        $_SESSION['error'] = "Invalid email or password.";
                        header("Location: index.php?controller=patient&action=login");
                        exit();
                    }
                } else {
                    $this->render("PatientLogin", "patientlogin", []);
                }
                break;

            case "submit":
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $paymentData = [
                        'patient_name' => $_POST['card_name'],
                        'service_code' => $_POST['service_code'],
                        'amount' => floatval($_POST['amount'])
                    ];

                    $success = Payment::insert($paymentData);

                    if ($success) {
                        $_SESSION['success'] = "✅ Payment successful.";
                    } else {
                        $_SESSION['error'] = "❌ Failed to process payment.";
                    }

                    header("Location: index.php?controller=patient&action=mainpage");
                    exit();
                }
                break;
            
            case "history":
                    $userID = $_SESSION['user_id'] ?? null;
                    if (!$userID) {
                        die("User not logged in");
                    }

                    $payments = Payment::getPaymentHistory($userID);
                    $this->render("PaymentHistory", "history", ["payments" => $payments]);
                    break;

            case "viewProfile":
                $name = isset($_GET['name']) ? $_GET['name'] : null;
                $id = isset($_GET['id']) ? intval($_GET['id']) : null;

                if ($name) {
                    $profileData = Patients::getNurseByName($name);
                } else if ($id) {
                    $profileData = Patients::getNurseById($id);
                } else if (isset($profile)) {
                    $profileData = Patients::formatProfileData($profile);
                } else {
                    $profileData = null;
                }

                if ($profileData) {
                    $this->render("ProfilePage", "profilePagePatient", ["profileData" => $profileData]);
                } else {
                    header("Location: index.php?controller=patient&action=mainpage");
                    exit();
                }
                break;

            case "mainpage":
                $nurses = Patients::getAllNurses();
                $this->render("PatientMainPage", "PatientMainPage", ["nurses" => $nurses]);
                break;

            case "logout":
                session_destroy();
                header("Location: index.php?controller=patient&action=login");
                exit();

            case "editProfile":
                $patientData = Patients::getPatientDataByUserId($_SESSION['user_id']);

                if ($patientData) {
                    $_SESSION['patient_data'] = $patientData;

                    $this->render("PatientProfile", "editProfile", []);
                } else {
                    $_SESSION['error_message'] = "Failed to load profile data.";
                    header("Location: index.php?controller=patient&action=mainpage");
                    exit();
                }
                break;

            case "updateProfile":
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $_POST['user_id'] = $_SESSION['user_id'];

                    if (!empty($_POST['password']) && $_POST['password'] !== $_POST['confirm_password']) {
                        $_SESSION['error_message'] = "Passwords do not match.";
                        header("Location: index.php?controller=patient&action=editProfile");
                        exit();
                    }

                    $success = Patients::updateProfile($_POST);

                    if ($success) {
                        $_SESSION['success_message'] = "Profile updated successfully.";

                        $patientData = Patients::getPatientDataByUserId($_SESSION['user_id']);
                        if ($patientData) {
                            $_SESSION['patient_data'] = $patientData;
                        }

                        header("Location: index.php?controller=patient&action=editProfile");
                    } else {
                        $_SESSION['error_message'] = "Failed to update profile.";
                        header("Location: index.php?controller=patient&action=editProfile");
                    }
                    exit();
                }
                break;

            case "deleteProfile":
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete']) && $_POST['confirm_delete'] === 'yes') {
                    $success = Patients::deleteProfile($_SESSION['user_id']);

                    if ($success) {
                        session_unset();
                        session_destroy();
                        session_start();
                        header("Location: /NurseProject/Views/default/default.php");
                    } else {
                        header("Location: index.php?controller=patient&action=editProfile");
                    }
                    exit();
                }
                break;

            default:
                $this->render("PatientLogin", "patientlogin", []);
                break;
        }
    }
}
