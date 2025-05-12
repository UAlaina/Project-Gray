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

        $required = ['email', 'password', 'firstName', 'lastName', 'zipCode', 'gender', 'description', 'DOB', 'licenseNumber', 'schedule', 'yearsExperience'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                error_log("Missing field: $field");
                return false;
            }
        }

        $stmt = $conn->prepare("
            INSERT INTO users (email, password, firstName, lastName, zipCode, gender, createdAt, updatedAt, DOB)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW(), ?)
        ");
        $hashedPassword = sha1($data['password']);
        $stmt->bind_param(
            "sssssss",
            $data['email'],
            $hashedPassword,
            $data['firstName'],
            $data['lastName'],
            $data['zipCode'],
            $data['gender'],
            $data['DOB']
        );

        if (!$stmt->execute()) {
            error_log("User insert failed: " . $stmt->error);
            return false;
        }

        $user_id = $conn->insert_id;
        $infoText = $data['description'];

        $stmt2 = $conn->prepare("
            INSERT INTO nurse (NurseID, licenseNumber, registrationFee, schedule, specialitiesGoodAt, clientHistory, feedbackReceived, rating, years_experience, info)
            VALUES (?, ?, 0, ?, 'General Care', '', '', 0, ?, ?)
        ");
        $stmt2->bind_param("issis", $user_id, $data['licenseNumber'], $data['schedule'], $data['yearsExperience'], $infoText);

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

    public static function getPatientByName($name) {
        $conn = Model::connect();
        $nameParts = explode(' ', $name);
        
        if (count($nameParts) < 2) {
            return false;
        }
        
        $firstName = $nameParts[0];
        $lastName = $nameParts[1];
        
        $stmt = $conn->prepare("
            SELECT u.id, u.firstName, u.lastName, u.gender, u.zipCode, p.problem
            FROM users u
            LEFT JOIN patients p ON u.id = p.patientID
            WHERE LOWER(u.firstName) = LOWER(?) AND LOWER(u.lastName) = LOWER(?)
        ");
        $stmt->bind_param("ss", $firstName, $lastName);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
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
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Helper function to format profile data
    public static function formatProfileData($profile) {
        if (is_object($profile)) {
            $profileData = [];
            foreach ($profile as $key => $value) {
                $profileData[$key] = $value;
            }
            return $profileData;
        }
        return $profile;
    }

    public static function getNurseDataByUserId($userId) {
        $conn = Model::connect();
        
        $sql = "SELECT u.Id, u.firstName, u.lastName, u.email, u.gender, u.zipCode, u.DOB,
                       n.NurseID, n.licenseNumber, n.schedule, n.years_experience, n.info 
                 FROM users u 
                 JOIN nurse n ON u.Id = n.NurseID 
                 WHERE u.Id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            //error_log("Retrieved nurse data: " . print_r($row, true));
            
            return $row;
        }
        
        return null;
    }

    public static function updateProfile($data) {
        $conn = Model::connect();
        $userId = $data['user_id'];
        
        // error_log("Updating nurse profile for user ID: " . $userId);
        // error_log("Update data: " . print_r($data, true));
        
        $conn->begin_transaction();
        
        try {
            $userSql = "UPDATE users SET 
                        firstName = ?, 
                        lastName = ?, 
                        email = ?";
            
            $userParams = [
                $data['firstName'],
                $data['lastName'],
                $data['email']
            ];
            
            if (isset($data['gender']) && $data['gender'] !== '') {
                $userSql .= ", gender = ?";
                $userParams[] = $data['gender'];
            }
            
            if (isset($data['zipCode']) && $data['zipCode'] !== '') {
                $userSql .= ", zipCode = ?";
                $userParams[] = $data['zipCode'];
            }
            
            if (isset($data['DOB']) && $data['DOB'] !== '') {
                $userSql .= ", DOB = ?";
                $userParams[] = $data['DOB'];
            }
            
            if (!empty($data['password'])) {
                $hashedPassword = sha1($data['password']);
                $userSql .= ", password = ?";
                $userParams[] = $hashedPassword;
            }
            
            $userSql .= " WHERE Id = ?";
            $userParams[] = $userId;
            
            //error_log("User SQL: " . $userSql);
            //error_log("User Params: " . print_r($userParams, true));
            
            $userStmt = $conn->prepare($userSql);
            $userTypes = str_repeat("s", count($userParams) - 1) . "i";
            $userStmt->bind_param($userTypes, ...$userParams);
            $userResult = $userStmt->execute();
            
            if (!$userResult) {
                //error_log("Error updating user: " . $userStmt->error);
                throw new Exception("Error updating user: " . $userStmt->error);
            }
            
            $nurseSql = "UPDATE nurse SET ";
            $nurseParams = [];
            $updateFields = [];
            
            if (isset($data['years_experience']) && $data['years_experience'] !== '') {
                $updateFields[] = "years_experience = ?";
                $nurseParams[] = $data['years_experience'];
            }
            
            if (isset($data['info'])) {
                $updateFields[] = "info = ?";
                $nurseParams[] = $data['info'];
            }
            
            if (isset($data['schedule']) && $data['schedule'] !== '') {
                $updateFields[] = "schedule = ?";
                $nurseParams[] = $data['schedule'];
            }
            
            if (!empty($updateFields)) {
                $nurseSql .= implode(", ", $updateFields);
                $nurseSql .= " WHERE NurseID = ?";
                $nurseParams[] = $userId;
                
                //error_log("Nurse SQL: " . $nurseSql);
                //error_log("Nurse Params: " . print_r($nurseParams, true));
                
                $nurseStmt = $conn->prepare($nurseSql);
                $nurseTypes = str_repeat("s", count($nurseParams) - 1) . "i";
                $nurseStmt->bind_param($nurseTypes, ...$nurseParams);
                $nurseResult = $nurseStmt->execute();
                
                if (!$nurseResult) {
                    //error_log("Error updating nurse: " . $nurseStmt->error);
                    throw new Exception("Error updating nurse: " . $nurseStmt->error);
                }
            }
            
            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollback();
            //error_log("Error updating nurse profile: " . $e->getMessage());
            return false;
        }
    }

public static function deleteProfile($userId) {
    $conn = Model::connect();
    
    //error_log("Attempting to delete nurse profile for user ID: " . $userId);
    
    $conn->begin_transaction();
    
    try {
        $tables = [];
        
        $checkFeedback = $conn->query("SHOW TABLES LIKE 'feedback'");
        if ($checkFeedback->num_rows > 0) {
            $checkNurseInFeedback = $conn->prepare("SELECT COUNT(*) FROM feedback WHERE nurseId = ?");
            $checkNurseInFeedback->bind_param("i", $userId);
            $checkNurseInFeedback->execute();
            $checkNurseInFeedback->bind_result($count);
            $checkNurseInFeedback->fetch();
            $checkNurseInFeedback->close();
            
            if ($count > 0) {
                $tables[] = "DELETE FROM feedback WHERE nurseId = ?";
            }
        }
        
        $checkChatMessages = $conn->query("SHOW TABLES LIKE 'chat_messages'");
        if ($checkChatMessages->num_rows > 0) {
            $checkNurseInChatMessages = $conn->prepare("SELECT COUNT(*) FROM chat_messages WHERE sender_id = ? AND sender_type = 'nurse'");
            $checkNurseInChatMessages->bind_param("i", $userId);
            $checkNurseInChatMessages->execute();
            $checkNurseInChatMessages->bind_result($count);
            $checkNurseInChatMessages->fetch();
            $checkNurseInChatMessages->close();
            
            if ($count > 0) {
                $tables[] = "DELETE FROM chat_messages WHERE sender_id = ? AND sender_type = 'nurse'";
            }
        }
        
        $checkChat = $conn->query("SHOW TABLES LIKE 'chat'");
        if ($checkChat->num_rows > 0) {
            $checkNurseInChat = $conn->prepare("SELECT COUNT(*) FROM chat WHERE nurse_id = ?");
            $checkNurseInChat->bind_param("i", $userId);
            $checkNurseInChat->execute();
            $checkNurseInChat->bind_result($count);
            $checkNurseInChat->fetch();
            $checkNurseInChat->close();
            
            if ($count > 0) {
                $tables[] = "DELETE FROM chat WHERE nurse_id = ?";
            }
        }
        
        $tables[] = "DELETE FROM nurse WHERE NurseID = ?";
        $tables[] = "DELETE FROM users WHERE Id = ?";
        
        foreach ($tables as $sql) {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $userId);
            $result = $stmt->execute();
            
            // Debug: Log the SQL and result
            //error_log("Executed SQL: " . $sql . " with user ID: " . $userId . ", Result: " . ($result ? "Success" : "Failed: " . $stmt->error));
            
            if (!$result) {
                throw new Exception("Error executing SQL: " . $stmt->error);
            }
        }
        
        $conn->commit();
        error_log("Successfully deleted nurse profile for user ID: " . $userId);
        return true;
    } catch (Exception $e) {
        $conn->rollback();
        error_log("Error deleting nurse profile: " . $e->getMessage());
        return false;
    }
}
}
?>
