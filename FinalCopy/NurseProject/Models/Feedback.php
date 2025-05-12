<?php

include_once "Models/Model.php";

class Feedback extends Model {
    public $feedbackId;
    public $clientId;
    public $nurseId;
    public $rating;
    public $description;
    public $createdAt;
    public $clientName;

    function __construct($param = null) {
        if (is_object($param)) {
            $this->setProperties($param);
        } elseif (is_int($param)) {
            $conn = Model::connect();
            $sql = "SELECT * FROM feedback WHERE feedbackId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $param);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_object();
            $this->setProperties($row);
        }
    }

    private function setProperties($param) {
        if (is_object($param)) {
            $this->feedbackId = $param->feedbackId ?? null;
            $this->clientId = $param->clientId ?? null;
            $this->nurseId = $param->nurseId ?? null;
            $this->rating = $param->rating ?? null;
            $this->description = $param->description ?? null;
            $this->createdAt = $param->createdAt ?? null;
            $this->clientName = $param->clientName ?? null;
        } elseif (is_array($param)) {
            $this->feedbackId = $param['feedbackId'] ?? null;
            $this->clientId = $param['clientId'] ?? null;
            $this->nurseId = $param['nurseId'] ?? null;
            $this->rating = $param['rating'] ?? null;
            $this->description = $param['description'] ?? null;
            $this->createdAt = $param['createdAt'] ?? null;
            $this->clientName = $param['clientName'] ?? null;
        }
    }

    public static function saveFeedback($data) {
        $conn = Model::connect();
        $clientId = $data['clientId'] ?? null;
        $nurseId = $data['nurseId'] ?? null;
        $rating = $data['rating'] ?? null;
        $description = $data['description'] ?? '';

        if (!$clientId || !$rating || $rating < 1 || $rating > 5) {
            return false;
        }

        $checkSql = "SELECT * FROM feedback WHERE clientId = ? AND nurseId = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("ii", $clientId, $nurseId);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            $sql = "UPDATE feedback SET rating = ?, description = ?, createdAt = NOW() WHERE clientId = ? AND nurseId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isii", $rating, $description, $clientId, $nurseId);
        } else {
            $sql = "INSERT INTO feedback (clientId, nurseId, rating, description, createdAt) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiis", $clientId, $nurseId, $rating, $description);
        }

        $success = $stmt->execute();

        if ($success && self::isNurse($clientId)) {
            self::updateNurseRating($clientId);
        }

        return $success;
    }

    public static function getFeedbackByNurseId($nurseId) {
        $list = [];
        $conn = Model::connect();

        $sql = "SELECT f.*, CONCAT(u.firstName, ' ', u.lastName) as clientName 
        FROM feedback f 
        JOIN users u ON f.clientId = u.id 
        WHERE f.nurseId = ? 
        ORDER BY f.createdAt DESC";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $nurseId);
        $stmt->execute();

        $result = $stmt->get_result();

        while ($row = $result->fetch_object()) {
            $feedback = new Feedback($row);
            array_push($list, $feedback);
        }

        return $list;
    }

    public static function getAverageRatingByNurseId($nurseId) {
        $conn = Model::connect();
        $sql = "SELECT AVG(rating) as avgRating FROM feedback WHERE nurseId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $nurseId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['avgRating'] ? round($row['avgRating'], 1) : 0;
    }

    
    public static function getAllFeedbackByPatientId($patientId) {
        $list = [];
        $conn = Model::connect();
        $sql = "SELECT f.*, CONCAT(n.firstName, ' ', n.lastName) as nurseName FROM feedback f JOIN users n ON f.nurseId = n.id WHERE f.clientId = ? ORDER BY f.createdAt DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $patientId);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_object()) {
            $feedback = new Feedback($row);
            $feedback->nurseName = $row->nurseName;
            array_push($list, $feedback);
        }

        return $list;
    }

    public static function getAverageRatingByPatientId($patientId) {
        $conn = Model::connect();
        $sql = "SELECT AVG(rating) as avgRating FROM feedback WHERE clientId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $patientId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['avgRating'] ? round($row['avgRating'], 1) : 0;
    }

    public static function updateNurseRating($nurseId) {
        $conn = Model::connect();
        $avgRating = self::getAverageRatingByNurseId($nurseId);
        $sql = "UPDATE nurse SET rating = ? WHERE NurseID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $avgRating, $nurseId);
        return $stmt->execute();
    }

    public static function updateAllNurseRatings() {
        $conn = Model::connect();
        $sql = "SELECT DISTINCT nurseId FROM feedback";
        $result = $conn->query($sql);
        $count = 0;

        while ($row = $result->fetch_assoc()) {
            if (Model::updateNurseRating($row['nurseId'])) {
                $count++;
            }
        }

        return $count;
    }

    public static function isNurse($userId) {
        $conn = Model::connect();
        $sql = "SELECT 1 FROM nurse WHERE NurseID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}
?>