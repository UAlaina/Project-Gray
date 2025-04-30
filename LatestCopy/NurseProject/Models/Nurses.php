<?php
include_once  "Models/Model.php";

class Nurse {
    public $NurseID;
    public $DOB;
    public $gender;
    public $licenseNumber;
    public $registrationFee;
    public $schedule;
    public $specialitiesGoodAt;
    public $clientHistory;
    public $feedbackReceived;
    public $rating;

    function __construct($param = null) {
        if (is_object($param)){
            $this->setProperties($param);
        }

        elseif (is_int($param)) {
            $conn = Model::connect();

            $sql = "SELECT * FROM `nurse";
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
            $this->NurseID = $param->NurseID;
            $this->DOB = $param->DOB;
            $this->gender = $param->gender;
            $this->licenseNumber = $param->licenseNumber;
            $this->registrationFee = $param->registrationFee;
            $this->schedule = $param->schedule;
            $this->specialitiesGoodAt = $param->specialitiesGoodAt;
            $this->clientHistory = $param->clientHistory;
            $this->feedbackReceived = $param->feedbackReceived;
            $this->rating = $param->rating;
        }
        elseif (is_array($param)) {
            $this->NurseID = $param['NurseID'];
            $this->DOB = $param['DOB'];
            $this->gender = $param['gender'];
            $this->licenseNumber = $param['licenseNumber'];
            $this->registrationFee = $param['registrationFee'];
            $this->schedule = $param['schedule'];
            $this->specialitiesGoodAt = $param['specialitiesGoodAt'];
            $this->clientHistory = $param['clientHistory'];
            $this->feedbackReceived = $param['feedbackReceived'];
            $this->rating = $param['rating'];
        }
        
    }

    public static function list(){
        $list = [];
        $sql = "SELECT * FROM `nurse`";

        $connection = Model::connect();
        $result = $connection->query($sql);

        while($row = $result->fetch_object()){
            $nurse = new Nurse($row);
            array_push($list, $nurse);
        }

        return $list;
    }

    
}

?>