<?php
    include_once "Models/Model.php";

    class PaymentProcessors {
        public $processorID;
        public $processorName;
        public $apiKey;
        public $patientID;

        function __construct($param = null) {
            if (is_object($param)){
                $this->setProperties($param);
            }
    
            elseif (is_int($param)) {
                $conn = Model::connect();
    
                $sql = "SELECT * FROM `payment_processor";
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
                $this->processorID = $param->processorID;
                $this->processorName = $param->processorName;
                $this->apiKey = $param->apiKey;
                $this->patientID = $param->patientID; 
            } elseif(is_array($param)) {
                $this->processorID = $param['processorID'];
                $this->processorName = $param['processorName'];
                $this->apiKey = $param['apiKey'];
                $this->patientID = $param['patientID']; 
            }
            
        }
    
        public static function list(){
            $list = [];
            $sql = "SELECT * FROM `payment_processor`";
    
            $connection = Model::connect();
            $result = $connection->query($sql);
    
            while($row = $result->fetch_object()){
                $paymentProcessor = new PaymentProcessors($row);
                array_push($list, $paymentProcessor);
            }
    
            return $list;
        }
    }

    
?>