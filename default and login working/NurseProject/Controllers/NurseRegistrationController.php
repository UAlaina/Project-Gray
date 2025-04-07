<?php
include_once "Models/Users.php";
include_once "Models/Nurse.php";
include_once "Controllers/Controller.php";

class NurseRegistrationController extends Controller {

    public function __construct() {
        session_start();
    }

    public function registerForm() {
        include "Views/NurseRegistration/nurseRegistration.php";
    }

    public function registerNurse() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $conn = Model::connect();

            // 1. Create user account
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $zipCode = $_POST['zipCode'];

            $stmtUser = $conn->prepare("INSERT INTO users (email, password, firstName, lastName, zipCode) VALUES (?, ?, ?, ?, ?)");
            $stmtUser->bind_param("sssss", $email, $password, $firstName, $lastName, $zipCode);
            $stmtUser->execute();

            $userId = $conn->insert_id;

            // 2. Add nurse details
            $DOB = $_POST['DOB'];
            $gender = $_POST['gender'];
            $licenseNumber = $_POST['licenseNumber'];
            $registrationFee = $_POST['registrationFee'];
            $schedule = $_POST['schedule'];
            $specialitiesGoodAt = $_POST['specialitiesGoodAt'];
            $clientHistory = $_POST['clientHistory'];
            $feedbackReceived = $_POST['feedbackReceived'];
            $rating = $_POST['rating'];

            $stmtNurse = $conn->prepare("INSERT INTO nurse (NurseID, DOB, gender, licenseNumber, registrationFee, schedule, specialitiesGoodAt, clientHistory, feedbackReceived, rating)
                                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmtNurse->bind_param("isssdssssi", $userId, $DOB, $gender, $licenseNumber, $registrationFee, $schedule, $specialitiesGoodAt, $clientHistory, $feedbackReceived, $rating);
            $stmtNurse->execute();

            $_SESSION['success'] = "Nurse registered successfully!";
            header("Location: index.php?controller=nurseRegistration&action=registerForm");
            exit();
        }
    }
}
?>
