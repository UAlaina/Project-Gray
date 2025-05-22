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
    public $info;

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
        $this->NurseID = $param->NurseID ?? null;
        $this->gender = $param->gender ?? null;
        $this->licenseNumber = $param->licenseNumber ?? null;
        $this->registrationFee = $param->registrationFee ?? 0;
        $this->schedule = $param->schedule ?? null;
        $this->specialitiesGoodAt = $param->specialitiesGoodAt ?? 'General Care';
        $this->clientHistory = $param->clientHistory ?? '';
        $this->feedbackReceived = $param->feedbackReceived ?? '';
        $this->rating = $param->rating ?? 0;
        $this->years_experience = $param->years_experience ?? 0;
        $this->info = $param->info ?? '';
    }

    public static function getPatients($includeUserDetails = false) {
        $conn = Model::connect();
        $sql = $includeUserDetails ?
        "SELECT u.firstName, u.lastName, u.zipCode, p.problem 
        FROM patients p
        JOIN users u ON p.patientID = u.Id"
        :
        "SELECT patientID, problem FROM patients";

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

        $required = ['email', 'password', 'firstName', 'lastName', 'zipCode', 'gender', 'description', 'DOB', 'licenseNumber', 'schedule', 'yearsExperience', 'cardName'];
        foreach ($required as $field) {
            if (!isset($data[$field]) || trim((string)$data[$field]) === '') {
                return "The field '$field' is required.";
            }
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return "Invalid email address.";
        }

        if (!preg_match("/^[A-Za-z\s'-]+$/", $data['firstName'])) {
            return "First name must contain only letters.";
        }

        if (!preg_match("/^[A-Za-z\s'-]+$/", $data['lastName'])) {
            return "Last name must contain only letters.";
        }

        if (!preg_match("/^[A-Za-z\s'-]+$/", $data['cardName'])) {
            return "Name on the card must contain only letters.";
        }

        if (!preg_match("/[A-Za-z]+/", $data['description'])) {
            return "Description must contain at least one letter.";
        }

        if (strlen($data['password']) < 8) {
            return "Password must be at least 8 characters.";
        }

        if (!is_numeric($data['yearsExperience']) || $data['yearsExperience'] < 4 || $data['yearsExperience'] > 60) {
            return "Years of experience must be between 4 and 60.";
        }

        $dob = strtotime($data['DOB']);
        if ($dob === false || $dob > time()) {
            return "Invalid date of birth.";
        }
        $age = date('Y') - date('Y', $dob);
        if ($age < 18) {
            return "You must be at least 18 years old to register.";
        }

        if (!preg_match("/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/", $data['zipCode'])) {
            return "Invalid ZIP code. Must be in Canadian format (e.g., A1B 2C3).";
        }

        if (isset($data['cardNumber']) && !preg_match("/^\d{16}$/", preg_replace('/\s+/', '', $data['cardNumber']))) {
            return "Card number must be 16 digits.";
        }

        if (isset($data['cvv']) && !preg_match("/^\d{3}$/", $data['cvv'])) {
            return "CVV must be 3 digits.";
        }

        if (isset($data['expireDate'])) {
            $expDate = $data['expireDate'];
            if (!preg_match("/^(0[1-9]|1[0-2])\/\d{2}$/", $expDate)) {
                return "Expire date must be in MM/YY format.";
            }
            
            list($month, $year) = explode('/', $expDate);
            $expiry = mktime(0, 0, 0, $month + 1, 0, 2000 + intval($year));
            if ($expiry < time()) {
                return "Card has expired.";
            }
        }

        $stmt = $conn->prepare("
            INSERT INTO users (email, password, firstName, lastName, zipCode, gender, createdAt, updatedAt, DOB)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW(), ?)
            ");
        if (!$stmt) return "Database error (users): " . $conn->error;

        $hashedPassword = sha1($data['password']);
        $stmt->bind_param("sssssss",
            $data['email'],
            $hashedPassword,
            $data['firstName'],
            $data['lastName'],
            $data['zipCode'],
            $data['gender'],
            $data['DOB']
        );

        if (!$stmt->execute()) return "Failed to save user: " . $stmt->error;

        $user_id = $conn->insert_id;

        $stmt2 = $conn->prepare("
            INSERT INTO nurse (
                NurseID, licenseNumber, registrationFee, schedule,
                specialitiesGoodAt, clientHistory, feedbackReceived,
                rating, years_experience, info
                ) VALUES (?, ?, 0, ?, 'General Care', '', '', 0, ?, ?)
            ");
        if (!$stmt2) return "Database error (nurse): " . $conn->error;

        $stmt2->bind_param("issis",
            $user_id,
            $data['licenseNumber'],
            $data['schedule'],
            $data['yearsExperience'],
            $data['description']
        );

        if (!$stmt2->execute()) return "Failed to save nurse info: " . $stmt2->error;

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

    public static function getPatientByName($name) {
        $conn = Model::connect();
        $parts = explode(' ', $name);
        if (count($parts) < 2) return false;

        $stmt = $conn->prepare("
            SELECT u.id, u.firstName, u.lastName, u.gender, u.zipCode, p.problem
            FROM users u
            LEFT JOIN patients p ON u.id = p.patientID
            WHERE LOWER(u.firstName) = LOWER(?) AND LOWER(u.lastName) = LOWER(?)
            ");
        $stmt->bind_param("ss", $parts[0], $parts[1]);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function getPatientById($id) {
        $conn = Model::connect();
        $stmt = $conn->prepare("
            SELECT u.id, u.firstName, u.lastName, u.gender, u.zipCode, p.problem
            FROM users u
            LEFT JOIN patients p ON u.id = p.patientID
            WHERE u.id = ?
            ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function formatProfileData($profile) {
        return is_object($profile) ? get_object_vars($profile) : $profile;
    }

    public static function getNurseDataByUserId($userId) {
        $conn = Model::connect();
        $stmt = $conn->prepare("
            SELECT u.Id, u.firstName, u.lastName, u.email, u.gender, u.zipCode, u.DOB,
            n.NurseID, n.licenseNumber, n.schedule, n.years_experience, n.info 
            FROM users u 
            JOIN nurse n ON u.Id = n.NurseID 
            WHERE u.Id = ?
            ");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    public static function updateProfile($data) {
        $conn = Model::connect();
        $conn->begin_transaction();
        try {
            $userSql = "UPDATE users SET firstName=?, lastName=?, email=?";
            $userParams = [$data['firstName'], $data['lastName'], $data['email']];
            if ($data['gender']) { $userSql .= ", gender=?"; $userParams[] = $data['gender']; }
            if ($data['zipCode']) { $userSql .= ", zipCode=?"; $userParams[] = $data['zipCode']; }
            if ($data['DOB']) { $userSql .= ", DOB=?"; $userParams[] = $data['DOB']; }
            if ($data['password']) { $userSql .= ", password=?"; $userParams[] = sha1($data['password']); }
            $userSql .= " WHERE Id=?";
            $userParams[] = $data['user_id'];

            $userStmt = $conn->prepare($userSql);
            $types = str_repeat("s", count($userParams) - 1) . "i";
            $userStmt->bind_param($types, ...$userParams);
            if (!$userStmt->execute()) throw new Exception("User update failed");

            $updateFields = [];
            $nurseParams = [];
            if ($data['years_experience']) { $updateFields[] = "years_experience=?"; $nurseParams[] = $data['years_experience']; }
            if (isset($data['info'])) { $updateFields[] = "info=?"; $nurseParams[] = $data['info']; }
            if ($data['schedule']) { $updateFields[] = "schedule=?"; $nurseParams[] = $data['schedule']; }

            if ($updateFields) {
                $nurseSql = "UPDATE nurse SET " . implode(", ", $updateFields) . " WHERE NurseID=?";
                $nurseParams[] = $data['user_id'];
                $nurseStmt = $conn->prepare($nurseSql);
                $types = str_repeat("s", count($nurseParams) - 1) . "i";
                $nurseStmt->bind_param($types, ...$nurseParams);
                if (!$nurseStmt->execute()) throw new Exception("Nurse update failed");
            }

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollback();
            return false;
        }
    }

    public static function deleteProfile($userId) {
        $conn = Model::connect();
        $stmt = $conn->prepare("UPDATE users SET isActive = 0 WHERE Id = ?");
        $stmt->bind_param("i", $userId);
        return $stmt->execute();
    }
}
