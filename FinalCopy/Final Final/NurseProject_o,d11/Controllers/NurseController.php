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
                    header("Location: index.php?controller=nurse&action=list");
                    exit();
                }
                break;

            case "viewProfile":
                $name = $_GET['name'] ?? null;
                $id = $_GET['id'] ?? null;
                $profileData = null;

                if ($name) {
                    $profileData = Nurse::getPatientByName($name);
                } else if ($id) {
                    $profileData = Nurse::getPatientById($id);
                }

                if ($profileData) {
                    $this->render("ProfilePage", "profilePageNurse", ["profileData" => $profileData]);
                } else {
                    header("Location: index.php?controller=nurse&action=mainpage");
                }
                break;

            case "register":
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $result = Nurse::register($_POST);

                    if ($result === true) {
                        $user = Users::authenticate($_POST['email'], $_POST['password']);
                        if ($user) {
                            $_SESSION['user_id'] = $user->id;
                            $_SESSION['user_email'] = $user->email;
                            $_SESSION['user_type'] = 'nurse';
                            $_SESSION['token'] = "NURSE_" . $user->id;
                            header("Location: index.php?controller=nurse&action=mainpage");
                            exit();
                        } else {
                            echo "<script>alert('Registered but login failed. Try logging in manually.'); window.history.back();</script>";
                            exit();
                        }
                    } else {
                        $safeMessage = htmlspecialchars($result, ENT_QUOTES);
                        echo "<script>alert('$safeMessage'); window.history.back();</script>";
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
                        $_SESSION['token'] = "NURSE_" . $user->Id;

                        if ($user->isActive == 0) {
                            $conn = Model::connect();
                            $stmt = $conn->prepare("UPDATE users SET isActive = 1 WHERE Id = ?");
                            $stmt->bind_param("i", $user->Id);
                            $stmt->execute();

                            $_SESSION['success_message_reactivation'] = "Welcome back! Your nurse account has been reactivated.";
                        }

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

            case "editProfile":
                if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'nurse') {
                    header("Location: index.php?controller=nurse&action=login");
                    exit();
                }

                $nurseData = Nurse::getNurseDataByUserId($_SESSION['user_id']);
                if ($nurseData) {
                    $_SESSION['nurse_data'] = $nurseData;
                    $this->render("NurseProfile", "editProfile", []);
                } else {
                    $_SESSION['error_message'] = "Failed to load profile data.";
                    header("Location: index.php?controller=nurse&action=mainpage");
                    exit();
                }
                break;

            case "updateProfile":
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $_POST['user_id'] = $_SESSION['user_id'];

                    if (!empty($_POST['password']) && $_POST['password'] !== $_POST['confirm_password']) {
                        $_SESSION['error_message'] = "Passwords do not match.";
                        header("Location: index.php?controller=nurse&action=editProfile");
                        exit();
                    }

                    $success = Nurse::updateProfile($_POST);

                    if ($success) {
                        $_SESSION['success_message'] = "Profile updated successfully.";
                        $_SESSION['nurse_data'] = Nurse::getNurseDataByUserId($_SESSION['user_id']);
                    } else {
                        $_SESSION['error_message'] = "Failed to update profile.";
                    }

                    header("Location: index.php?controller=nurse&action=editProfile");
                    exit();
                }
                break;

            case "deleteProfile":
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $success = Nurse::deleteProfile($_SESSION['user_id']);
                    if ($success) {
                        session_unset();
                        session_destroy();
                        header("Location: /NurseProject/Views/default/default.php");
                    } else {
                        $_SESSION['error_message'] = "Failed to deactivate account.";
                        header("Location: index.php?controller=nurse&action=editProfile");
                    }
                    exit();
                }
                break;

            default:
                $this->render("NurseLogin", "nurselogin", []);
                break;
        }
    }
}
