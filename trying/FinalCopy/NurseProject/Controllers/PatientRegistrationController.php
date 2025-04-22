<?php
include_once "Models/Model.php";
include_once "Controllers/Controller.php";
include_once "Models/Users.php";

class PatientRegistrationController extends Controller {
    
    public function registerPatient() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect form data
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

            // Validate email
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                // You can display an error here if the email is invalid
                echo "Invalid email address.";
                return;
            }

            // Validate DOB
            $dobDate = new DateTime($DOB);
            $today = new DateTime();
            if ($dobDate > $today) {
                // You can display an error if DOB is in the future
                echo "Date of birth cannot be in the future.";
                return;
            }
            $age = $today->diff($dobDate)->y;
            if ($age < 18) {
                // You can display an error if the user is under 18
                echo "You must be at least 18 years old.";
                return;
            }

            // Save the patient data to the users table
            $conn = Model::connect();
            $sql = "INSERT INTO users (email, password, firstName, lastName, ZipCode, Gender, description, createdAt, updatedAt, DOB) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssss", $email, $password, $firstName, $lastName, $zipCode, $gender, $description, $createdAt, $updatedAt, $DOB);

            if ($stmt->execute()) {
                // Successfully registered, redirect to the login page
                header("Location: ../PatientLogin/patientLogin.php");
                exit();
            } else {
                // Error in registration
                echo "There was an error while registering your account. Please try again later.";
            }
        }
    }
}

?>