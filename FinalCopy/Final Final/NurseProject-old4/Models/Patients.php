<?php
include_once "Models/Model.php";
include_once "Models/Users.php";

class Patients extends Model {

    public static function getNurses() {
        $conn = Model::connect();
        $result = $conn->query("SELECT * FROM nurses");
        $nurses = [];
        while ($row = $result->fetch_object()) {
            $nurses[] = $row;
        }
        return $nurses;
    }

    public static function getServices() {
        $conn = Model::connect();
        $result = $conn->query("SELECT * FROM services");
        $services = [];
        while ($row = $result->fetch_object()) {
            $services[] = $row;
        }
        return $services;
    }

    public static function getUserDetails($id) {
        $conn = Model::connect();
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object();
    }

    public static function register($data) {
        $conn = Model::connect();

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
            return false;
        }

        $user_id = $conn->insert_id;
        $problemText = $data['description']; 
        $stmt2 = $conn->prepare("
            INSERT INTO patients (patientID, paymentHistory, chats, serviceHistory, problem)
            VALUES (?, '', '', '', ?)
            ");
        $stmt2->bind_param("is", $user_id, $problemText);

        return $stmt2->execute();
    }

    public static function authenticate($email, $password) {
        $conn = Model::connect();

        $stmt = $conn->prepare("
            SELECT u.* 
            FROM users u
            JOIN patients p ON u.id = p.patientID
            WHERE LOWER(u.email) = LOWER(?) AND u.password = ?
            LIMIT 1
            ");

        $hashedPassword = sha1($password);
        $stmt->bind_param("ss", $email, $hashedPassword);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_object()) {
            return new Users($row);
        }

        return null;
    }

    // public static function getProfileDetails($id) {
    //     $conn = Model::connect();
    //     $stmt = $conn->prepare("
    //         SELECT u.firstName, u.lastName, u.email, u.zipCode, u.gender, n.years_experience, n.specialitiesGoodAt 
    //         FROM users u
    //         LEFT JOIN nurse n ON u.id = n.NurseID
    //         WHERE u.id = ?
    //     ");
    //     $stmt->bind_param("i", $id);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     return $result->fetch_object() ?: null;
    // }

    public static function getPatientByName($name) {
        $conn = Model::connect();
        $nameParts = explode(' ', $name);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        $stmt = $conn->prepare("
            SELECT u.firstName, u.lastName, u.gender, u.zipCode, u.DOB, n.rating, n.info
            FROM users u
            LEFT JOIN nurse n ON u.id = n.NurseID
            WHERE LOWER(u.firstName) = LOWER(?) AND LOWER(u.lastName) = LOWER(?)
            ");
        $stmt->bind_param("ss", $firstName, $lastName);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_object();
    }

    public static function getAllNurses() {
        $conn = Model::connect();
        $sql = "
        SELECT u.firstName, u.lastName, u.gender, u.zipCode, u.isActive, n.years_experience, n.info
        FROM nurse n
        JOIN users u ON n.NurseID = u.Id
        WHERE u.isActive = 1
        ";
        $result = $conn->query($sql);

        if (!$result) {
            die("SQL ERROR: " . $conn->error);
        }

        $nurses = [];
        while ($row = $result->fetch_object()) {
            $nurses[] = $row;
        }

        return $nurses;
    }

    public static function getNurseByName($name) {
        $nameParts = explode(' ', $name);
        
        if (count($nameParts) < 2) {
            return false;
        }
        
        $firstName = $nameParts[0];
        $lastName = $nameParts[1];
        
        $conn = Model::connect();
        $stmt = $conn->prepare("
            SELECT u.id, u.firstName, u.lastName, u.gender, u.zipCode, u.DOB, n.rating, n.info, n.years_experience
            FROM users u
            LEFT JOIN nurse n ON u.id = n.NurseID
            WHERE LOWER(u.firstName) = LOWER(?) AND LOWER(u.lastName) = LOWER(?)
            ");
        $stmt->bind_param("ss", $firstName, $lastName);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public static function getNurseById($id) {
        $conn = Model::connect();
        $stmt = $conn->prepare("
            SELECT u.id, u.firstName, u.lastName, u.gender, u.zipCode, u.DOB, n.rating, n.info, n.years_experience
            FROM users u
            LEFT JOIN nurse n ON u.id = n.NurseID
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
    public static function getPatientDataByUserId($userId) {
        $conn = Model::connect();

        $sql = "SELECT u.id, u.firstName, u.lastName, u.email, u.gender, u.zipCode, u.DOB,
        p.patientID, p.problem 
        FROM users u 
        JOIN patients p ON u.id = p.patientID 
        WHERE u.id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            // error_log("Retrieved patient data: " . print_r($row, true));
            // error_log("Problem field: " . ($row['problem'] ?? 'Not found'));

            return $row;
        }
        
        return null;
    }

    public static function updateProfile($data) {
        $conn = Model::connect();
        $userId = $data['user_id'];
        
        $conn->begin_transaction();
        
        try {
            $userSql = "UPDATE users SET 
            firstName = ?, 
            lastName = ?, 
            email = ?, 
            gender = ?,
            zipCode = ?";
            
            $userParams = [
                $data['firstName'],
                $data['lastName'],
                $data['email'],
                $data['gender'],
                $data['zipCode']
            ];
            
            if (!empty($data['DOB'])) {
                $userSql .= ", DOB = ?";
                $userParams[] = $data['DOB'];
            }
            
            if (!empty($data['password'])) {
                $hashedPassword = sha1($data['password']);
                $userSql .= ", password = ?";
                $userParams[] = $hashedPassword;
            }
            
            $userSql .= " WHERE id = ?";
            $userParams[] = $userId;
            
            $userStmt = $conn->prepare($userSql);
            $userTypes = str_repeat("s", count($userParams) - 1) . "i";
            $userStmt->bind_param($userTypes, ...$userParams);
            $userStmt->execute();
            
            $patientSql = "UPDATE patients SET 
            problem = ? 
            WHERE patientID = ?";

            $patientStmt = $conn->prepare($patientSql);
            $patientStmt->bind_param("si", 
                $data['problem'],
                $userId
            );
            
            $patientStmt->execute();
            
            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollback();
            $_SESSION['error_message'] = "❌ Deletion failed: " . $e->getMessage();
            return false;
        }

    }

    public static function deleteProfile($userId) {
        $conn = Model::connect();
        $conn->begin_transaction();

        try {
            $chatRoomIds = [];
            $stmt = $conn->prepare("SELECT chatRoomId FROM chat WHERE clientId = ?");
            if ($stmt) {
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $chatRoomIds[] = $row['chatRoomId'];
                }
            }

            foreach ($chatRoomIds as $chatRoomId) {
                $stmt = $conn->prepare("DELETE FROM chathistory WHERE chatRoomID = ?");
                if ($stmt) {
                    $stmt->bind_param("i", $chatRoomId);
                    $stmt->execute();
                }
            }

            $stmt = $conn->prepare("DELETE FROM feedback WHERE clientId = ?");
            if ($stmt) {
                $stmt->bind_param("i", $userId);
                $stmt->execute();
            }

            $stmt = $conn->prepare("DELETE FROM chat WHERE clientId = ?");
            if ($stmt) {
                $stmt->bind_param("i", $userId);
                $stmt->execute();
            }

            $stmt = $conn->prepare("DELETE FROM payment_processors WHERE patientID = ?");
            if ($stmt) {
                $stmt->bind_param("i", $userId);
                $stmt->execute();
            }

            $stmt = $conn->prepare("DELETE FROM patients WHERE patientID = ?");
            if ($stmt) {
                $stmt->bind_param("i", $userId);
                $stmt->execute();
            }

            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $userId);
                $stmt->execute();
            }

            $conn->commit();
            return true;

        } catch (Exception $e) {
            $conn->rollback();
            return false;
        }
    }
}
