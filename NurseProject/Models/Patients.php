<?php
include_once "Models/Model.php";

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
            INSERT INTO users (email, password, firstName, lastName, zipCode, gender, description, createdAt, updatedAt, DOB)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?)
            ");
        $hashedPassword = sha1($data['password']); // SHA1 hash

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
            return false;
        }

        $user_id = $conn->insert_id;

        $stmt2 = $conn->prepare("
            INSERT INTO patients (patientID, paymentHistory, chats, serviceHistory, problem)
            VALUES (?, '', '', '', '')
            ");
        $stmt2->bind_param("i", $user_id);
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

    $user = $result->fetch_object();
    return $user ?: null;
}


    public static function getAllNurses() {
        $conn = Model::connect();
        $sql = "SELECT u.firstName, u.lastName, n.gender, u.zipCode, n.years_experience 
        FROM nurse n
        JOIN users u ON n.NurseID = u.Id";
        $result = $conn->query($sql);

        $nurses = [];
        while ($row = $result->fetch_object()) {
            $nurses[] = $row;
        }
        return $nurses;
    }
}
?>
