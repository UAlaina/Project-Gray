<?php
include_once "Models/Model.php";

class Chat extends Model {
    public $chatRoomId;
    public $clientId;
    public $nurseId;
    public $createAt;
    public $messages;
    public $serviceCode;

    public function __construct($param = null) {
        if (is_object($param) || is_array($param)) {
            $this->setProperties($param);
        } elseif (is_int($param)) {
            $conn = Model::connect();
            $sql = "SELECT * FROM `chat` WHERE chatRoomId = ?";
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
        $data = (array) $param;
        $this->chatRoomId = $data['chatRoomId'] ?? null;
        $this->clientId = $data['clientId'] ?? null;
        $this->nurseId = $data['nurseId'] ?? null;
        $this->createAt = $data['createAt'] ?? date('Y-m-d H:i:s');
        $this->messages = isset($data['messages']) ? $data['messages'] : '[]';
        $this->serviceCode = $data['serviceCode'] ?? '';
    }


    public static function getChatsByUserId($userId, $userType) {
        $conn = Model::connect();
        $sql = "";
        
        if ($userType === 'nurse') {
            $sql = "SELECT c.*, 
                    u.firstName as clientFirstName, 
                    u.lastName as clientLastName, 
                    p.problem as clientProblem
                FROM chat c
                JOIN users u ON c.clientId = u.Id
                LEFT JOIN patients p ON c.clientId = p.patientID
                WHERE c.nurseId = ?
                ORDER BY c.createAt DESC";
        } else {
            $sql = "SELECT c.*, 
                    u.firstName as nurseFirstName, 
                    u.lastName as nurseLastName, 
                    n.specialitiesGoodAt as nurseSpecialities
                FROM chat c
                JOIN users u ON c.nurseId = u.Id
                JOIN nurse n ON c.nurseId = n.NurseID
                WHERE c.clientId = ?
                ORDER BY c.createAt DESC";
        }
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $chats = [];
        while ($row = $result->fetch_object()) {
            $messagesArray = json_decode($row->messages, true);
            $lastMessage = !empty($messagesArray) ? end($messagesArray) : null;
            $row->lastMessageTime = $lastMessage ? $lastMessage['timestamp'] : $row->createAt;
            $row->unreadCount = 0;
            
            if (!empty($messagesArray)) {
                foreach ($messagesArray as $msg) {
                    if ($msg['sender_id'] != $userId && !isset($msg['read'])) {
                        $row->unreadCount++;
                    }
                }
            }
            
            $chats[] = $row;
        }
        
        return $chats;
    }

    
    public static function getChatRoom($chatRoomId, $userId) {
        $conn = Model::connect();
        $sql = "SELECT c.*,
                nu.firstName as nurseFirstName, 
                nu.lastName as nurseLastName,
                cu.firstName as clientFirstName, 
                cu.lastName as clientLastName,
                n.specialitiesGoodAt,
                p.problem
                FROM chat c
                JOIN users nu ON c.nurseId = nu.Id
                JOIN users cu ON c.clientId = cu.Id
                LEFT JOIN nurse n ON c.nurseId = n.NurseID
                LEFT JOIN patients p ON c.clientId = p.patientID
                WHERE c.chatRoomId = ? AND (c.nurseId = ? OR c.clientId = ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $chatRoomId, $userId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return null;
        }
        
        $chatRoom = $result->fetch_object();
        
        $messagesArray = json_decode($chatRoom->messages, true);
        $updatedMessages = [];
        $updated = false;
        
        if (!empty($messagesArray)) {
            foreach ($messagesArray as &$msg) {
                if ($msg['sender_id'] != $userId && !isset($msg['read'])) {
                    $msg['read'] = true;
                    $updated = true;
                }
            }
            
            if ($updated) {
                $updatedJson = json_encode($messagesArray);
                $updateSql = "UPDATE chat SET messages = ? WHERE chatRoomId = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("si", $updatedJson, $chatRoomId);
                $updateStmt->execute();
            }
        }
        
        $chatRoom->messagesArray = $messagesArray;
        
        return $chatRoom;
    }

    public static function createChatRoom($clientId, $nurseId, $serviceCode = '') {
        $conn = Model::connect();
        
        $checkSql = "SELECT chatRoomId FROM chat WHERE clientId = ? AND nurseId = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("ii", $clientId, $nurseId);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            return $row->chatRoomId;
        }
        
        $createAt = date('Y-m-d H:i:s');
        $emptyMessages = '[]';
        
        $sql = "INSERT INTO chat (clientId, nurseId, createAt, incoming_msg_id, outgoing_msg_id, messages, serviceCode) 
                VALUES (?, ?, ?, 0, 0, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisss", $clientId, $nurseId, $createAt, $emptyMessages, $serviceCode);
        
        if ($stmt->execute()) {
            return $conn->insert_id;
        }
        
        return false;
    }

    public static function addMessage($chatRoomId, $senderId, $message) {
        $conn = Model::connect();
        
        $sql = "SELECT * FROM chat WHERE chatRoomId = ? AND (clientId = ? OR nurseId = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $chatRoomId, $senderId, $senderId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return false;
        }
        
        $chat = $result->fetch_object();
        $messagesArray = json_decode($chat->messages, true);
        
        $recipientId = ($senderId == $chat->clientId) ? $chat->nurseId : $chat->clientId;
        
        $newMessage = [
            'msg_id' => count($messagesArray) + 1,
            'sender_id' => $senderId,
            'recipient_id' => $recipientId,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        $messagesArray[] = $newMessage;
        $updatedMessages = json_encode($messagesArray);
        
        $updateSql = "UPDATE chat SET messages = ? WHERE chatRoomId = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $updatedMessages, $chatRoomId);
        
        return $updateStmt->execute();
    }

    public static function getMessages($chatRoomId, $lastId = 0) {
        $conn = Model::connect();
        $sql = "SELECT messages FROM chat WHERE chatRoomId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $chatRoomId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return [];
        }
        
        $row = $result->fetch_object();
        $messagesArray = json_decode($row->messages, true);
        
        if ($lastId > 0) {
            $newMessages = array_filter($messagesArray, function($msg) use ($lastId) {
                return $msg['msg_id'] > $lastId;
            });
            return array_values($newMessages);
        }
        
        return $messagesArray;
    }
}
?>