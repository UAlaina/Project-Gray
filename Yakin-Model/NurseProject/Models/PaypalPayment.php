<?php
 include_once "Models/Model.php";

 class PaypalPayment{
    public $paypalID;
    public $paymentID;
    public $processorID;
    public $transactionID;
    public $patientID;
    public $status;

    function __construct($param = null) {
      if (is_object($param)){
          $this->setProperties($param);
      }

      elseif (is_int($param)) {
          $conn = Model::connect();

          $sql = "SELECT * FROM `paypalpayment";
          $stmt = $conn->prepare($sql);

          $stmt->bind_param("i",$param);
          $stmt->execute();

          $result = $stmt->get_result();
          $row = $result->fetch_object();

          $this->setProperties($row);
      }
     
  }

  private function setProperties($param) {
    if (is_object($param)){
      $this->paypalID = $param->paypalID;
      $this->paymentID = $param->paymentID;
      $this->processorID = $param->processorID;
      $this->transactionID = $param->transactionID;
      $this->patientID = $param->patientID;
      $this->status = $param->status;  
  } elseif(is_array($param)) {
    $this->paypalID = $param->['paypalID'];
    $this->paymentID = $param->['paymentID'];
    $this->processorID = $param->['processorID'];
    $this->transactionID = $param->['transactionID'];
    $this->patientID = $param->['patientID'];
    $this->status = $param->['status'];  
  }
}

  public static function list(){
      $list = [];
      $sql = "SELECT * FROM `paypalpayment`";

      $connection = Model::connect();
      $result = $connection->query($sql);

      while($row = $result->fetch_object()){
          $paypalPayment = new PaypalPayment($row);
          array_push($list, $paypalPayment);
      }

      return $list;
  }
 }
?>