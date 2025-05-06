<?php
include_once "Controller.php";
include_once "Models/Chat.php";
include_once "Models/Users.php";

class ChatController extends Controller {
    public function route() {
        global $controller;
        $controller = "Chat";
        $action = isset($_GET['action']) ? $_GET['action'] : "index";
        $user_id = isset($_SESSION['user_id']);
        //? (int)$_SESSION['user_id'] : 2;

        switch ($action) {
            case "index":
                $chat_rooms = Chat::getChatRooms($user_id);
                // var_dump($user_id, $chat_rooms);
                // die();
                $selected_chat_id = isset($_GET['chat_id']) ? (int)$_GET['chat_id'] : -1;
                $selected_chat = $selected_chat_id > 0 ? Chat::getChatRoom($selected_chat_id) : null;
                $other_user = $selected_chat ? Chat::getOtherUser($selected_chat_id, $user_id) : null;
                $this->render($controller, "chat", [
                    'chat_rooms' => $chat_rooms,
                    'selected_chat' => $selected_chat,
                    'other_user' => $other_user,
                    'user_id' => $user_id
                ]);
                break;

            case "getChat":
                $chatRoomId = isset($_POST['chat_room_id']) ? (int)$_POST['chat_room_id'] : -1;
                if ($chatRoomId > 0) {
                    $chat = Chat::getChatRoom($chatRoomId);
                    $messages = json_decode($chat->messages, true) ?: [];
                    $other_user = Chat::getOtherUser($chatRoomId, $user_id);
                    $output = "";
                    if ($messages) {
                        foreach ($messages as $msg) {
                            if ($msg['sender_id'] == $user_id) {
                                $output .= '<div class="chat outgoing">
                                    <div class="details">
                                        <p>' . htmlspecialchars($msg['message']) . '</p>
                                    </div>
                                </div>';
                            } else {
                                $output .= '<div class="chat incoming">
                                    <img src="' . VIEWS_PATH . '/images/default.jpg" alt="">
                                    <div class="details">
                                        <p>' . htmlspecialchars($msg['message']) . '</p>
                                    </div>
                                </div>';
                            }
                        }
                    } else {
                        $output .= '<div class="text">No messages are available. Start the conversation!</div>';
                    }
                    echo $output;
                }
                exit;

            case "startChat":
                $other_user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : -1;
                if ($other_user_id > 0) {
                    $conn = Model::connect();
                    $stmt = $conn->prepare("INSERT INTO chat (clientId, nurseId, createAt, messages, serviceCode) VALUES (?, ?, NOW(), '[]', 'DEFAULT')");
                    $stmt->bind_param("ii", $user_id, $other_user_id);
                    $stmt->execute();
                    $new_chat_id = $conn->insert_id;
                    header("Location: index.php?controller=Chat&action=index&chat_id=$new_chat_id");
                }
                exit;

            case "insertChat":
                $chatRoomId = isset($_POST['chat_room_id']) ? (int)$_POST['chat_room_id'] : -1;
                $message = isset($_POST['message']) ? trim($_POST['message']) : '';
                if ($chatRoomId > 0 && $message) {
                    Chat::insertMessage($chatRoomId, $user_id, $message);
                }
                exit;

            case "search":
                $searchTerm = isset($_POST['searchTerm']) ? trim($_POST['searchTerm']) : '';
                $users = Chat::searchUsers($user_id, $searchTerm);
                $output = "";
                foreach ($users as $user) {
                    $output .= '<a href="?controller=Chat&action=startChat&user_id=' . $user->Id . '">
                        <div class="content">
                            <img src="' . VIEWS_PATH . '/images/default.jpg" alt="">
                            <div class="details">
                                <span>' . htmlspecialchars($user->firstName . " " . $user->lastName) . '</span>
                                <p>No messages yet</p>
                            </div>
                        </div>
                        <div class="status-dot"><i class="fas fa-circle"></i></div>
                    </a>';
                }
                echo $output ?: "No users found";
                exit;

            case "getChatRooms":
            case "getUsers":
                $chat_rooms = Chat::getChatRooms($user_id);
                $output = "";
                foreach ($chat_rooms as $chat) {
                    $messages = json_decode($chat->messages, true) ?: [];
                    $last_msg = end($messages);
                    $msg = $last_msg ? $last_msg['message'] : "No messages yet";
                    $msg = strlen($msg) > 28 ? substr($msg, 0, 28) . '...' : $msg;
                    $you = $last_msg && $last_msg['sender_id'] == $user_id ? "You: " : "";
                    $other_user = Chat::getOtherUser($chat->chatRoomId, $user_id);
                    $output .= '<a href="?controller=Chat&action=index&chat_id=' . $chat->chatRoomId . '">
                        <div class="content">
                            <img src="' . VIEWS_PATH . '/images/default.jpg" alt="">
                            <div class="details">
                                <span>' . htmlspecialchars($other_user ? ($other_user->firstName . " " . $other_user->lastName) : 'Unknown User') . '</span>
                                <p>' . $you . htmlspecialchars($msg) . '</p>
                            </div>
                        </div>
                        <div class="status-dot"><i class="fas fa-circle"></i></div>
                    </a>';
                }
                echo $output ?: "No chat rooms available";
                exit;

            default:
                header("Location: index.php?controller=Chat&action=index");
                exit;
        }
    }
}
?>