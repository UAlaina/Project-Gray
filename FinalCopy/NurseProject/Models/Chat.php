<?php
include_once "Models/Model.php";
include_once "Models/Users.php";

class Chat extends Model{
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
    
    public static function getChatRooms($user_id) {
        $conn = self::connect();
        $stmt = $conn->prepare("
            SELECT c.* 
            FROM chat c 
            WHERE c.clientId = ? OR c.nurseId = ?
        ");
        $stmt->bind_param("ii", $user_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $chat_rooms = [];
        while ($row = $result->fetch_object()) {
            $chat_rooms[] = $row;
        }
        return $chat_rooms;
    }

    public static function searchUsers($user_id, $searchTerm) {
        $conn = self::connect();
        $searchTerm = "%$searchTerm%";
        $stmt = $conn->prepare("
            SELECT * FROM users 
            WHERE Id != ? AND (firstName LIKE ? OR lastName LIKE ?)
        ");
        $stmt->bind_param("iss", $user_id, $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        $users = [];
        while ($row = $result->fetch_object()) {
            $users[] = new Users($row);
        }
        return $users;
    }

    public static function getChatRoom($chatRoomId) {
        $conn = self::connect();
        $stmt = $conn->prepare("SELECT * FROM chat WHERE chatRoomId = ?");
        $stmt->bind_param("i", $chatRoomId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object();
    }

    public static function getOtherUser($chatRoomId, $user_id) {
        $conn = self::connect();
        $stmt = $conn->prepare("
            SELECT u.* FROM chat c JOIN users u 
            ON (c.nurseId = u.Id AND c.clientId = ?) OR (c.clientId = u.Id AND c.nurseId = ?)
            WHERE c.chatRoomId = ?
        ");
        $stmt->bind_param("iii", $user_id, $user_id, $chatRoomId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_object();
        return $row ? new Users($row) : null;
    }

    public static function insertMessage($chatRoomId, $sender_id, $message) {
        $conn = self::connect();
        $chat = self::getChatRoom($chatRoomId);
        $messages = json_decode($chat->messages, true) ?: [];
        $new_message = [
            'sender_id' => $sender_id,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        $messages[] = $new_message;
        $messages_json = json_encode($messages);
        $stmt = $conn->prepare("UPDATE chat SET messages = ? WHERE chatRoomId = ?");
        $stmt->bind_param("si", $messages_json, $chatRoomId);
        return $stmt->execute();
    }
}
?>
