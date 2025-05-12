<?php
include_once "Models/Model.php";

class Nurse extends Model {
    public $NurseID;
    public $gender;
    public $licenseNumber;
    public $registrationFee;
    public $schedule;
    public $specialitiesGoodAt;
    public $clientHistory;
    public $feedbackReceived;
    public $rating;
    public $years_experience;

    public function __construct($param = null) {
        if (is_object($param) || is_array($param)) {
            $this->setProperties($param);
        } elseif (is_int($param)) {
            $conn = Model::connect();
            $sql = "SELECT * FROM nurse WHERE NurseID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $param);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_object()) {
                $this->setProperties($row);
            }
        }
    }

    private function setProperties($param) {
        $data = (array) $param;
        $this->NurseID = $data['NurseID'] ?? null;
        $this->gender = $data['gender'] ?? null;
        $this->licenseNumber = $data['licenseNumber'] ?? null;
        $this->registrationFee = $data['registrationFee'] ?? 0;
        $this->schedule = $data['schedule'] ?? null;
        $this->specialitiesGoodAt = $data['specialitiesGoodAt'] ?? 'General Care';
        $this->clientHistory = $data['clientHistory'] ?? '';
        $this->feedbackReceived = $data['feedbackReceived'] ?? '';
        $this->rating = $data['rating'] ?? 0;
        $this->years_experience = $data['years_experience'] ?? 0;
    }

    public static function getPatients($includeUserDetails = false) {
        $conn = Model::connect();
        if ($includeUserDetails) {
            $sql = "SELECT u.firstName, u.lastName, u.zipCode, p.problem 
                    FROM patients p
                    JOIN users u ON p.patientID = u.Id";
        } else {
            $sql = "SELECT patientID, problem FROM patients";
        }

        $result = $conn->query($sql);
        $patients = [];
        while ($row = $result->fetch_object()) {
            $patients[] = $row;
        }
        return $patients;
    }

    public static function getUserDetails($id) {
        $conn = Model::connect();
        $stmt = $conn->prepare("SELECT * FROM users WHERE Id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object() ?: null;
    }

    public static function register($data) {
        $conn = Model::connect();

        $required = ['email', 'password', 'firstName', 'lastName', 'zipCode', 'gender', 'description', 'DOB', 'licenseNumber', 'schedule', 'yearsExperience'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                error_log("Missing field: $field");
                return false;
            }
        }

        $stmt = $conn->prepare("
            INSERT INTO users (email, password, firstName, lastName, zipCode, gender, description, createdAt, updatedAt, DOB)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?)
        ");
        $hashedPassword = sha1($data['password']);
        $stmt->bind_param(
            "ssssssss",
            $data['email'],
            $hashedPassword,
            $data['firstName'],
            $data['lastName'],
            $data['zipCode'],
            $data['gender'],
            $data['description'],
            $data['DOB']
        );

        if (!$stmt->execute()) {
            error_log("User insert failed: " . $stmt->error);
            return false;
        }

        $user_id = $conn->insert_id;

        $stmt2 = $conn->prepare("
            INSERT INTO nurse (NurseID, licenseNumber, registrationFee, schedule, specialitiesGoodAt, clientHistory, feedbackReceived, rating, years_experience)
            VALUES (?, ?, 0, ?, 'General Care', '', '', 0, ?)
        ");
        $stmt2->bind_param("issi", $user_id, $data['licenseNumber'], $data['schedule'], $data['yearsExperience']);

        if (!$stmt2->execute()) {
            error_log("Nurse insert failed: " . $stmt2->error);
            return false;
        }

        return true;
    }

    public static function authenticate($email, $password) {
        $conn = Model::connect();
        $stmt = $conn->prepare("
            SELECT u.* 
            FROM users u
            JOIN nurse n ON u.Id = n.NurseID
            WHERE LOWER(u.email) = LOWER(?) AND u.password = ?
            LIMIT 1
        ");
        $hashedPassword = sha1($password);
        $stmt->bind_param("ss", $email, $hashedPassword);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object() ?: null;
    }
}
?>