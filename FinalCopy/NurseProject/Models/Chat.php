<?php
    include_once "Models/Model.php";

class Chat {
    public $chatRoomId;
    public $clientId;
    public $createAt;
    public $messages;
    public $serviceCode;

    function __construct($param = null) {
        if (is_object($param)){
            $this->setProperties($param);
        }

        elseif (is_int($param)) {
            $conn = Model::connect();

            $sql = "SELECT * FROM `chat` WHERE `chatRoomId` = ?";
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
            $this->chatRoomId = $param->chatRoomId;
            $this->clientId = $param->clientId;
            $this->createAt = $param->createAt;
            $this->messages = $param->messages;
            $this->serviceCode = $param->serviceCode;
        } elseif(is_array($param)) {
            $this->chatRoomId = $param['chatRoomId'];
            $this->clientId = $param['clientId'];
            $this->createAt = $param['createAt'];
            $this->messages = $param['messages'];
            $this->serviceCode = $param['serviceCode'];
        }
    }

    public static function list(){
        $list = [];
        $sql = "SELECT * FROM `chat`";

        $connection = Model::connect();
        $result = $connection->query($sql);

        while($row = $result->fetch_object()){
            $chat = new Chat($row);
            array_push($list, $chat);
        }

        return $list;
    }
    
}
?>