<?php
include_once "Models/Users.php";
include_once "Models/NurseRegistrationModel.php";
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
            $model = new NurseRegistrationModel();

            //Create user 
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $zipCode = $_POST['zipCode'];

           

            $userId = $model->registerUser($email, $password, $firstName, $lastName, $zipCode);;

            //Add nurse details
            $DOB = $_POST['DOB'];
            $gender = $_POST['gender'];
            $licenseNumber = $_POST['licenseNumber'];
            $registrationFee = $_POST['registrationFee'];
            $schedule = $_POST['schedule'];
            $specialitiesGoodAt = $_POST['specialitiesGoodAt'];
            $clientHistory = $_POST['clientHistory'];
            $feedbackReceived = $_POST['feedbackReceived'];
            $rating = $_POST['rating'];

            $model->registerNurse($userId, $DOB, $gender, $licenseNumber, $registrationFee, $schedule, $specialitiesGoodAt, $clientHistory, $feedbackReceived, $rating);


            $_SESSION['success'] = "Nurse registered successfully!";
            header("Location: index.php?controller=nurseRegistration&action=registerForm");
            exit();
        }
    }
}
?>
