<?php
include_once "Models/Model.php";

class Nurse extends Model{
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
            $sql = "SELECT * FROM `nurse` WHERE NurseID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $param);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_object();
            if ($row) {
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
        $this->specialitiesGoodAt = $data['specialitiesGoodAt'] ?? null;
        $this->clientHistory = $data['clientHistory'] ?? '';
        $this->feedbackReceived = $data['feedbackReceived'] ?? '';
        $this->rating = $data['rating'] ?? 0;
        $this->years_experience = $data['years_experience'] ?? 0;
    }

    public static function list() {
        $list = [];
        $sql = "SELECT NurseID, gender, licenseNumber, registrationFee, schedule, specialitiesGoodAt, clientHistory, feedbackReceived, rating, years_experience FROM `nurse`";
        $connection = Model::connect();
        $result = $connection->query($sql);
        while ($row = $result->fetch_object()) {
            $list[] = new Nurse($row);
        }
        return $list;
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
        $stmt = $conn->prepare("SELECT Id, email, firstName, lastName, zipCode, gender, description, DOB FROM users WHERE Id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object() ?: null;
    }

    public static function register($data) {
        // Validate inputs
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) ||
            empty($data['firstName']) ||
            empty($data['lastName']) ||
            empty($data['licenseNumber']) ||
            !preg_match("/^\d{4}-\d{2}-\d{2}$/", $data['DOB'])) {
            return false;
        }

        $conn = Model::connect();
        $conn->begin_transaction();

        try {
            // Insert user data
            $stmt = $conn->prepare("
                INSERT INTO users (email, password, firstName, lastName, zipCode, gender, description, createdAt, updatedAt, DOB)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?)
            ");
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
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
                throw new Exception("User insertion failed: " . $stmt->error);
            }

            $user_id = $conn->insert_id;

            // Insert nurse data
            $stmt2 = $conn->prepare("
                INSERT INTO nurse (NurseID, licenseNumber, registrationFee, schedule, specialitiesGoodAt, clientHistory, feedbackReceived, rating, years_experience)
                VALUES (?, ?, ?, ?, ?, '', '', 0, ?)
            ");
            $regFee = $data['registrationFee'] ?? 0;
            $yearsExperience = $data['yearsExperience'] ?? 0;
            $specialities = $data['specialitiesGoodAt'] ?? 'General Care';
            $stmt2->bind_param(
                "isdssi",
                $user_id,
                $data['licenseNumber'],
                $regFee,
                $data['schedule'],
                $specialities,
                $yearsExperience
            );
            if (!$stmt2->execute()) {
                throw new Exception("Nurse insertion failed: " . $stmt2->error);
            }

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollback();
            error_log("Registration error: " . $e->getMessage());
            return false;
        }
    }

    public static function authenticate($email, $password) {
        $conn = Model::connect();
        $stmt = $conn->prepare("
            SELECT u.* 
            FROM users u
            JOIN nurse n ON u.Id = n.NurseID
            WHERE LOWER(u.email) = LOWER(?)
            LIMIT 1
        ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_object();
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return null;
    }
}
?>