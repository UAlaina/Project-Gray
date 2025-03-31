<?php
include_once "Models/Model.php";

class StripePayment {
    public $stripeID;
    public $transactionID;
    public $paymentID;
    public $apiKey;
    public $status;

    function __construct($param = null) {
        if (is_object($param)){
            $this->setProperties($param);
        }
  
        elseif (is_int($param)) {
            $conn = Model::connect();
  
            $sql = "SELECT * FROM `stripepayment";
            $stmt = $conn->prepare($sql);
  
            $stmt->bind_param("i",$param);
            $stmt->execute();
  
            $result = $stmt->get_result();
            $row = $result->fetch_object();
  
            $this->setProperties($row);
        }
       
    }
  
    private function setProperties($param) {
        $this->stripeID = $param->stripeID;
        $this->transactionID = $param->transactionID;
        $this->paymentID = $param->paymentID;
        $this->apiKey = $param->apiKey;
        $this->status = $param->status; 
    }
  
    public static function list(){
        $list = [];
        $sql = "SELECT * FROM `stripepayment`";
  
        $connection = Model::connect();
        $result = $connection->query($sql);
  
        while($row = $result->fetch_object()){
            $stripePayment = new StripePayment($row);
            array_push($list, $stripePayment);
        }
  
        return $list;
    }
}
?>