<?php
include_once "Models/Model.php";

class ServiceForm {
    public $id;
    public $chatRoomId;
    public $clientId;
    public $nurseId;
    public $appointmentTime;
    public $appointmentDate;
    public $serviceCode;
    public $status;

    function __construct($param = null) {
        if (is_object($param)){
            $this->setProperties($param);
        }
  
        elseif (is_int($param)) {
            $conn = Model::connect();
  
            $sql = "SELECT * FROM `serviceform";
            $stmt = $conn->prepare($sql);
  
            $stmt->bind_param("i",$param);
            $stmt->execute();
  
            $result = $stmt->get_result();
            $row = $result->fetch_object();
  
            $this->setProperties($row);
        }
       
    }
  
    private function setProperties($param) {
        if(is_object($param)) {
            $this->id = $param->id;
            $this->chatRoomId = $param->chatRoomId;
            $this->clientId = $param->clientId;
            $this->nurseId = $param->nurseId;
            $this->appointmentTime = $param->appointmentTime;
            $this->appointmentDate = $param->appointmentDate; 
            $this->serviceCode = $param->serviceCode;
            $this->status = $param->status; 
        } elseif(is_array($param)){
            $this->id = $param['id'];
            $this->chatRoomId = $param['chatRoomId'];
            $this->clientId = $param['clientId'];
            $this->nurseId = $param['nurseId'];
            $this->appointmentTime = $param['appointmentTime'];
            $this->appointmentDate = $param['appointmentDate']; 
            $this->serviceCode = $param['serviceCode'];
            $this->status = $param['status'];
        }
    }
  
    public static function list(){
        $list = [];
        $sql = "SELECT * FROM `serviceform`";
  
        $connection = Model::connect();
        $result = $connection->query($sql);
  
        while($row = $result->fetch_object()){
            $serviceForm = new serviceForm($row);
            array_push($list, $serviceForm);
        }
  
        return $list;
    }
}
?>