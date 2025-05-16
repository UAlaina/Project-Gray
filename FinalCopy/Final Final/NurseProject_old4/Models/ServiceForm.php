<?php
include_once "Model.php";

class ServiceForm extends Model {
    public $id;
    public $nurseId;
    public $appointmentTime;
    public $appointmentDate;
    public $serviceCode;
    public $status;
    public $address;

    function __construct($param = null) {
        if (is_object($param)) {
            $this->setProperties($param);
        } elseif (is_int($param)) {
            $conn = Model::connect();
            $sql = "SELECT * FROM `serviceform` WHERE id = ?";
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
            $this->id = $param->id;
            $this->nurseId = $param->nurseId;
            $this->appointmentTime = $param->appointmentTime;
            $this->appointmentDate = $param->appointmentDate;
            $this->serviceCode = $param->serviceCode;
            $this->status = $param->status;
            $this->address = $param->address;
        } elseif (is_array($param)) {
            $this->id = $param['id'];
            $this->nurseId = $param['nurseId'];
            $this->appointmentTime = $param['appointmentTime'];
            $this->appointmentDate = $param['appointmentDate'];
            $this->serviceCode = $param['serviceCode'];
            $this->status = $param['status'];
            $this->address = $param['address'];
        }
    }

    public static function list() {
        $list = [];
        $sql = "SELECT * FROM `serviceform`";
        $connection = Model::connect();
        $result = $connection->query($sql);

        while ($row = $result->fetch_object()) {
            $serviceForm = new ServiceForm($row);
            array_push($list, $serviceForm);
        }

        return $list;
    }

    public static function submitForm($data) {

        $conn = Model::connect();

        $nurseId = $_SESSION['user_id'] ?? null;
        if (!$nurseId) {
            return ['success' => false, 'error' => 'Nurse not logged in.'];
        }

        // Generating 5-character service code with letters only
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $serviceCode = '';
        for ($i = 0; $i < 5; $i++) {
            $serviceCode .= $characters[rand(0, strlen($characters) - 1)];
        }

        $stmt = $conn->prepare("
            INSERT INTO serviceform (nurseId, appointmentTime, appointmentDate, serviceCode, address, status)
            VALUES (?, ?, ?, ?, ?, 'pending')
        ");

        if (!$stmt) {
            return ['success' => false, 'error' => $conn->error];
        }

        $stmt->bind_param(
            "issss",
            $nurseId,
            $data['time'],
            $data['date'],
            $serviceCode,
            $data['address']
        );

        if ($stmt->execute()) {
            return [
                'success' => true,
                'email' => $data['email'],
                'serviceCode' => $serviceCode
            ];
        } else {
            return [
                'success' => false,
                'error' => $stmt->error
            ];
        }
    }
}
?>
