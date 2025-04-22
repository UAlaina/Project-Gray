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
        $this->patientID = $param->patientID;
        $this->paymentHistory = $param->paymentHistory;
        $this->chats = $param->chats;
        $this->serviceHistory = $param->serviceHistory;
        
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
}
?>