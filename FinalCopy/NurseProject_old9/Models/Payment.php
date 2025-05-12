<?php
include_once "Models/Model.php";

class Payment{
    public $paymentID;
    public $userID;
    public $serviceCode;
    public $amount;
    public $timeStamp;
    public $paymentStatus;

    function __construct($param = null) {
        if (is_object($param)){
            $this->setProperties($param);
        }

        elseif (is_int($param)) {
            $conn = Model::connect();

            $sql = "SELECT * FROM `payments";
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
            $this->paymentID = $param->paymentID;
            $this->userID = $param->userID;
            $this->serviceCode = $param->serviceCode;
            $this->amount = $param->amount;
            $this->timeStamp = $param->timeStamp;
            $this->paymentStatus = $param->paymentStatus;
        } elseif(is_array($param)) {
            $this->paymentID = $param['paymentID'];
            $this->userID = $param['userID'];
            $this->serviceCode = $param['serviceCode'];
            $this->amount = $param['amount'];
            $this->timeStamp = $param['timeStamp'];
            $this->paymentStatus = $param['paymentStatus'];
        }
        
    }

    public static function list(){
        $list = [];
        $sql = "SELECT * FROM `payments` WHERE paymentID = ?";

        $connection = Model::connect();
        $result = $connection->query($sql);

        while($row = $result->fetch_object()){
            $payment = new Payment($row);
            array_push($list, $payment);
        }

        return $list;
    }


    public static function createPayment($data) {
    $conn = Model::connect();

    $sql = "INSERT INTO `payments` (patientName, serviceCode, amount, timeStamp, paymentStatus, userId)
        VALUES (?, ?, ?, NOW(), ?,?)";
    
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssdsi", 
                    $data['patientName'],
                    $data['serviceCode'],
                    $data['amount'],
                    $data['paymentStatus'],
                    $data['userId'],
                );
    $stmt->execute();
}



}
?>