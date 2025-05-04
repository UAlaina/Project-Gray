<?php
include_once "Models/Model.php";

class Chat {
    public $chatRoomId;
    public $clientId;
    public $nurseId;
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

            $stmt->bind_param("i", $param);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_object();

            if ($row) {
                $this->setProperties($row);
            }
        }
    }

    private function setProperties($param) {
        if (is_object($param)) {
            $this->chatRoomId = $param->chatRoomId;
            $this->clientId = $param->clientId;
            $this->nurseId = $param->nurseId;
            $this->createAt = $param->createAt;
            $this->messages = $param->messages;
            $this->serviceCode = $param->serviceCode;
        } elseif(is_array($param)) {
            $this->chatRoomId = $param['chatRoomId'];
            $this->clientId = $param['clientId'];
            $this->nurseId = $param['nurseId'];
            $this->createAt = $param['createAt'];
            $this->messages = $param['messages'];
            $this->serviceCode = $param['serviceCode'];
        }
    }

    public static function list() {
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
    
    public static function getMessages($incoming_id, $outgoing_id) {
        $conn = Model::connect();
        
        $chatRoom = self::getChatRoomByUsers($incoming_id, $outgoing_id);
        if (!$chatRoom) {
            self::createChatRoom($incoming_id, $outgoing_id);
        }
        
        $sql = "SELECT c.*, u.img 
                FROM `chat` c
                JOIN `users` u ON u.Id = c.clientId
                WHERE (c.clientId = ? AND c.nurseId = ?) 
                OR (c.clientId = ? AND c.nurseId = ?)
                LIMIT 1";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $incoming_id, $outgoing_id, $outgoing_id, $incoming_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $messages = json_decode($row['messages'], true);
            
            if (empty($messages)) {
                return [];
            }
            
            foreach ($messages as &$message) {
                $message['img'] = $row['img'];
            }
            
            return $messages;
        }
        
        return [];
    }
    
    public static function insertMessage($incoming_id, $outgoing_id, $message) {
        $conn = Model::connect();
        
        $chatRoom = self::getChatRoomByUsers($incoming_id, $outgoing_id);
        if (!$chatRoom) {
            $chatRoomId = self::createChatRoom($incoming_id, $outgoing_id);
        } else {
            $chatRoomId = $chatRoom->chatRoomId;
        }
        
        $sql = "SELECT messages FROM `chat` WHERE chatRoomId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $chatRoomId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        $messages = json_decode($row['messages'], true);
        if (!is_array($messages)) {
            $messages = [];
        }
        
        $messages[] = [
            'incoming_msg_id' => $incoming_id,
            'outgoing_msg_id' => $outgoing_id,
            'msg' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        $messagesJson = json_encode($messages);
        
        $sql = "UPDATE `chat` SET messages = ? WHERE chatRoomId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $messagesJson, $chatRoomId);
        
        return $stmt->execute();
    }
    
    public static function getChatRoomByUsers($clientId, $nurseId) {
        $conn = Model::connect();
        
        $sql = "SELECT * FROM `chat` 
                WHERE (clientId = ? AND nurseId = ?) 
                OR (clientId = ? AND nurseId = ?)
                LIMIT 1";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $clientId, $nurseId, $nurseId, $clientId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return new Chat($result->fetch_object());
        }
        
        return null;
    }
    
    public static function createChatRoom($clientId, $nurseId, $serviceCode = '') {
        $conn = Model::connect();
        $createAt = date('Y-m-d H:i:s');
        $emptyMessages = json_encode([]);
        
        $sql = "INSERT INTO `chat` (clientId, nurseId, createAt, messages, serviceCode) 
                VALUES (?, ?, ?, ?, ?)";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisss", $clientId, $nurseId, $createAt, $emptyMessages, $serviceCode);
        
        if ($stmt->execute()) {
            return $conn->insert_id;
        }
        
        return false;
    }
    
    public static function getLastMessage($outgoing_id, $user_id) {
        $conn = Model::connect();
        
        $chatRoom = self::getChatRoomByUsers($outgoing_id, $user_id);
        
        if (!$chatRoom) {
            return null;
        }
        
        $messages = json_decode($chatRoom->messages, true);
        
        if (empty($messages)) {
            return null;
        }
        
        return end($messages);
    }
}
?>
