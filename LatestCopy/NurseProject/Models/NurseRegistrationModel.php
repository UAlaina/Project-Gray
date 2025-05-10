<?php
include_once "Models/Model.php";

class NurseRegistrationModel extends Model {
    private $db;

    public function __construct(){
        $this->db = parent::connect();
    }

    public function registerUser($email, $password, $firstName, $lastName,$zipCode) {
        $stmt = $this->db->prepare("INSERT INTO `users` (`email`, `password`, `firstName`, `lastName`, `zipCode`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss",
                    $email,
                    $password,
                    $firstName,
                    $lastName,
                    $zipCode);
        $stmt->execute();

        return $this->db->insert_id;
    }

    public function registerNurse($userId, $DOB, $gender, $licenseNumber, $registrationFee, $schedule, $specilitiesGoodAt, $clientHistory, $feedbackReceived, $rating) {
        $stmt = $this->db->prepare("INSERT INTO nurse (NurseID, DOB, gender, licenseNumber, registrationFee, schedule, specialitiesGoodAt, clientHistory, feedbackReceived, rating)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssdssssi", 
                                $userId, 
                                $DOB, 
                                $gender, 
                                $licenseNumber, 
                                $registrationFee, 
                                $schedule, 
                                $specialitiesGoodAt, 
                                $clientHistory, 
                                $feedbackReceived, 
                                $rating);
        $stmt->execute();
    }
}
?>