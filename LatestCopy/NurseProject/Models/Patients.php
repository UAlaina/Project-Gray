<?php
include_once "Models/Model.php";

class Patients {
    public $patientID;
    public $paymentHistory;
    public $chats;
    public $serviceHistory;

    function __construct($param = null) {
        if (is_object($param)){
            $this->setProperties($param);
        }

        elseif (is_int($param)) {
            $conn = Model::connect();

            $sql = "SELECT * FROM `patients";
            $stmt = $conn->prepare($sql);

            $stmt->bind_param("i",$param);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_object();

            $this->setProperties($row);
        }
       
    }

    private function setProperties($param) {
        if (is_object($param)) {
            $this->patientID = $param->patientID;
            $this->paymentHistory = $param->paymentHistory;
            $this->chats = $param->chats;
            $this->serviceHistory = $param->serviceHistory;
        } elseif (is_array($param)) {
            $this->patientID = $param['patientID'];
            $this->paymentHistory = $param['paymentHistory'];
            $this->chats = $param['chats'];
            $this->serviceHistory = $param['serviceHistory'];
        }
        
    }

    public static function list(){
        $list = [];
        $sql = "SELECT * FROM `patients`";

        $connection = Model::connect();
        $result = $connection->query($sql);

        while($row = $result->fetch_object()){
            $patient = new Patients($row);
            array_push($list, $patient);
        }

        return $list;
    }

    public static function register($data) {
        $conn = Model::connect();

        $sql = "INSERT INTO users (email, password, firstName, lastName, ZipCode, Gender, description, createdAt, updatedAt, DOB) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssssssss",
            $data['email'],
            $data['password'],
            $data['firstName'],
            $data['lastName'],
            $data['zipCode'],
            $data['gender'],
            $data['description'],
            $data['createdAt'],
            $data['updatedAt'],
            $data['DOB']
        );

        return $stmt->execute();
    }
}
?>