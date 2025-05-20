<?php
include_once "Controllers/Controller.php";
include_once "Models/Chat.php";
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
        $userId = $_SESSION['user_id'];        
        $userType = $_SESSION['user_type'];

        switch ($action) {
            case "list":
            $userId = $_SESSION['user_id'];
            $userType = $_SESSION['user_type'];
            $chats = Chat::getChatsByUserId($userId, $userType);
            $this->render("Chat", "chatList", ["chats" => $chats, "userType" => $userType]);
            break;

            case "view":
               /* echo "<pre>";
    echo "chatRoomId: " . $chatRoomId . "\n";
    echo "userId: " . $userId . "\n";
    var_dump($_GET);
    exit();*/
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

            // case "create":
            //     if ($_SESSION['user_type'] === 'patient') {
            //         $nurses = Nurse::list();
            //         $this->render("Chat", "createChat", ["nurses" => $nurses]);
            //     } elseif ($_SESSION['user_type'] === 'nurse') {
            //         $patients = Nurse::getPatients(true);
            //         $this->render("Chat", "createChat", ["patients" => $patients]);
            //     } else {
            //         $_SESSION['error'] = "Unauthorized access.";
            //         header("Location: http://localhost/NurseProject/index.php");
            //         exit();
            //     }
            //     break;

            case "startChat":
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $clientId = isset($_POST['clientId']) ? intval($_POST['clientId']) : 0;
                $nurseId = isset($_POST['nurseId']) ? intval($_POST['nurseId']) : 0;
                $serviceCode = isset($_POST['serviceCode']) ? $_POST['serviceCode'] : "";

                $userId = $_SESSION['user_id'];
                $userType = $_SESSION['user_type'];

        // Override based on who is logged in
                if ($userType === 'patient') {
                    $clientId = $userId;
                } elseif ($userType === 'nurse') {
                    $nurseId = $userId;
                }

        // DEBUGGING OUTPUT
                echo "<pre>";
                echo "clientId: $clientId\n";
                echo "nurseId: $nurseId\n";
                echo "userType: $userType\n";
                echo "userId: $userId\n";
                echo "serviceCode: $serviceCode\n";

                $chatRoomId = Chat::createChatRoom($clientId, $nurseId, $serviceCode);
                echo "chatRoomId: $chatRoomId\n";
                echo "</pre>";

                if ($chatRoomId) {
                    echo "✅ Redirecting to chat room...";
                    header("Location: /NurseProject/chat/" . $chatRoomId);                    
                    exit();
                } else {
                    echo "❌ Failed to create chat room.";
                    exit();
                }
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

                header("Location: /NurseProject/chat/" . $chatRoomId);
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