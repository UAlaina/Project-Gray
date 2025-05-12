<?php

    include_once "Models/Model.php";

    class Feedback {
        public $feedbackId;
        public $clientId;
        public $nurseId;
        public $rating;
        public $description;
        public $createdAt;


        function __construct($param = null) {
            if (is_object($param)){
                $this->setProperties($param);
            }
    
            elseif (is_int($param)) {
                $conn = Model::connect();
    
                $sql = "SELECT * FROM `feedback`";
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
                $this->feedbackId = $param->feedbackId;
                $this->clientId = $param->clientId;
                $this->nurseId = $param->nurseId;
                $this->rating = $param->rating;
                $this->description = $param->description;
                $this->createdAt = $param->createdAt;
            } elseif (is_array($param)) {
                $this->feedbackId = $param['feedbackId'];
                $this->clientId = $param['clientId'];
                $this->nurseId = $param['nurseId'];
                $this->rating = $param['rating'];
                $this->description = $param['description'];
                $this->createdAt = $param['createdAt'];
            }
        }

        public static function list(){
            $list = [];
            $sql = "SELECT * FROM `feedback`";
    
            $connection = Model::connect();
            $result = $connection->query($sql);
    
            while($row = $result->fetch_object()){
                $feedback = new Feedback($row);
                array_push($list, $feedback);
            }
    
            return $list;
        }
    }
?>