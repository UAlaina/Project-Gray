<?php
include_once "Controllers/Controller.php";
include_once "  Models/Chat.php";
include_once "Models/Users.php";
include_once "Models/Nurses.php";

class ChatController extends Controller {
    
    public function route() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: http://localhost/NurseProject/index.php?controller=nurse&action=login");
            exit();
        }

        $action = isset($_GET['action']) ? $_GET['action'] : "list";
        $chatRoomId = isset($_GET['chatRoomId']) ? intval($_GET['chatRoomId']) : -1;
        $userId = isset($_GET['userId']) ? intval($_GET['userId']) : -1;

        switch ($action) {
            case "list":
                $userId = $_SESSION['user_id'];
                $userType = $_SESSION['user_type'];
                $chats = Chat::getChatsByUserId($userId, $userType);
                $this->render("Chat", "chatList", ["chats" => $chats, "userType" => $userType]);
                break;

            case "view":
                if ($chatRoomId > 0) {
                    $userId = $_SESSION['user_id'];
                    $userType = $_SESSION['user_type'];
                    $chatData = Chat::getChatRoom($chatRoomId, $userId);
                    
                    if (!$chatData) {
                        $_SESSION['error'] = "Chat room not found or you don't have access to it.";
                        header("Location: http://localhost/NurseProject/index.php?controller=chat&action=list");
                        exit();
                    }
                    
                    $this->render("Chat", "chatRoom", [
                        "chatRoom" => $chatData, 
                        "userId" => $userId,
                        "userType" => $userType
                    ]);
                } else {
                    header("Location: http://localhost/NurseProject/index.php?controller=chat&action=list");
                    exit();
                }
                break;

            case "create":
                if ($_SESSION['user_type'] === 'patient') {
                    $nurses = Nurse::list();
                    $this->render("Chat", "createChat", ["nurses" => $nurses]);
                } elseif ($_SESSION['user_type'] === 'nurse') {
                    $patients = Nurse::getPatients(true);
                    $this->render("Chat", "createChat", ["patients" => $patients]);
                } else {
                    $_SESSION['error'] = "Unauthorized access.";
                    header("Location: http://localhost/NurseProject/index.php");
                    exit();
                }
                break;

            case "startChat":
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $clientId = isset($_POST['clientId']) ? intval($_POST['clientId']) : 0;
                    $nurseId = isset($_POST['nurseId']) ? intval($_POST['nurseId']) : 0;
                    $serviceCode = isset($_POST['serviceCode']) ? $_POST['serviceCode'] : "";
                    
                    $userId = $_SESSION['user_id'];
                    $userType = $_SESSION['user_type'];
                    
                    if ($userType === 'patient') {
                        $clientId = $userId;
                    } elseif ($userType === 'nurse') {
                        $nurseId = $userId;
                    }
                    
                    if ($clientId > 0 && $nurseId > 0) {
                        $chatRoomId = Chat::createChatRoom($clientId, $nurseId, $serviceCode);
                        if ($chatRoomId) {
                            header("Location: http://localhost/NurseProject/index.php?controller=chat&action=view&chatRoomId=" . $chatRoomId);
                            exit();
                        } else {
                            $_SESSION['error'] = "Failed to create chat room.";
                        }
                    } else {
                        $_SESSION['error'] = "Invalid user selection.";
                    }
                    
                    header("Location: http://localhost/NurseProject/index.php?controller=chat&action=create");
                    exit();
                }
                break;

            case "sendMessage":
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chatRoomId'])) {
                    $response = ['success' => false];
                    
                    $chatRoomId = intval($_POST['chatRoomId']);
                    $senderId = intval($_SESSION['user_id']);
                    $message = isset($_POST['message']) ? trim($_POST['message']) : "";
                    
                    if (!empty($message) && $chatRoomId > 0) {
                        $result = Chat::addMessage($chatRoomId, $senderId, $message);
                        if ($result) {
                            $response['success'] = true;
                        }
                    }
                    
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit();
                }
                break;

            case "getMessages":
                if (isset($_GET['chatRoomId'])) {
                    $chatRoomId = intval($_GET['chatRoomId']);
                    $lastId = isset($_GET['lastId']) ? intval($_GET['lastId']) : 0;
                    
                    $messages = Chat::getMessages($chatRoomId, $lastId);
                    
                    header('Content-Type: application/json');
                    echo json_encode($messages);
                    exit();
                }
                break;

            default:
                header("Location: http://localhost/NurseProject/index.php?controller=chat&action=list");
                exit();
                break;
        }
    }
}
?>