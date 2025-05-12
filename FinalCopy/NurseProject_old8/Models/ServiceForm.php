<?php
include_once "Model.php";

class ServiceForm extends Model{
    public $id;
    public $chatRoomId;
    public $clientId;
    public $nurseId;
    public $appointmentTime;
    public $appointmentDate;
    public $serviceCode;
    public $status;
    public $address;

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
            $this->address = $param->address;
        } elseif(is_array($param)){
            $this->id = $param['id'];
            $this->chatRoomId = $param['chatRoomId'];
            $this->clientId = $param['clientId'];
            $this->nurseId = $param['nurseId'];
            $this->appointmentTime = $param['appointmentTime'];
            $this->appointmentDate = $param['appointmentDate']; 
            $this->serviceCode = $param['serviceCode'];
            $this->status = $param['status'];
            $this->address = $param['address'];
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

    //  public function save() {
    //     $conn = Model::connect();

    //     $sql = "INSERT INTO serviceform (clientId, nurseId, appointmentTime, appointmentDate, serviceCode, address) 
    //             VALUES (?, ?, ?, ?, ?, ?)";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bind_param("iissss", $this->clientId, $this->nurseId, $this->appointmentTime, $this->appointmentDate, $this->serviceCode, $this->address);

    //     return $stmt->execute();
    // }

    public static function submitForm($data) {
        $conn = Model::connect();
        
        //error_log("Submitting form with data: " . print_r($data, true));
        
        $stmt = $conn->prepare("
            INSERT INTO serviceform (clientId, nurseId, appointmentTime, appointmentDate, serviceCode, address, status) 
            VALUES (?, ?, ?, ?, ?, ?, 'pending')
        ");

        $serviceCode = bin2hex(random_bytes(4));

        $stmt->bind_param(
            "iissss", 
            $data['clientId'], 
            $data['nurseId'], 
            $data['time'], 
            $data['date'], 
            $serviceCode, 
            $data['address']
        );

        if ($stmt->execute()) {
            //error_log("Form submitted successfully with service code: " . $serviceCode);
            return [
                'success' => true,
                'email' => $data['email'],
                'serviceCode' => $serviceCode,
            ];
        } else {
            //error_log("Error saving service form: " . $conn->error);
            return [
                'success' => false,
                'error' => "Error saving service form: " . $conn->error,
            ];
        }
    }
}
?>
