<?php
include_once "Models/Model.php";
include_once "Controllers/Controller.php";
include_once "Models/Patients.php";

class PatientRegistrationController extends Controller {
    
    public function registerPatient() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $DOB = $_POST['DOB'];
            $description = $_POST['description'];
            $zipCode = $_POST['zipCode'];
            $gender = $_POST['gender'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $createdAt = date('Y-m-d H:i:s');
            $updatedAt = date('Y-m-d H:i:s');

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email address.";
                return;
            }
            

            $dobDate = new DateTime($DOB);
            $today = new DateTime();
            if ($dobDate > $today) {
                echo "Date of birth cannot be in the future.";
                return;
            }
            $age = $today->diff($dobDate)->y;
            if ($age < 18) {
                echo "You must be at least 18 years old.";
                return;
            }

             $success = Patients::register([
                'email' => $email,
                'password' => $password,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'zipCode' => $zipCode,
                'gender' => $gender,
                'description' => $description,
                'createdAt' => $createdAt,
                'updatedAt' => $updatedAt,
                'DOB' => $DOB
            ]);

            if ($success) {
                header("Location: ../PatientLogin/patientLogin.php");
                exit();
            } else {
                echo "There was an error while registering your account. Please try again later.";
            }
        }
    }
}

?>