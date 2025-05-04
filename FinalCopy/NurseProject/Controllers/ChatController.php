<?php
include_once "Models/Users.php";
include_once "Models/Chat.php";
include_once "Controllers/Controller.php";

class ChatController extends Controller {
    
    public function route() {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])){
            header("location: index.php?controller=login&action=login");
            exit;
        }
        
        $action = isset($_GET['action']) ? $_GET['action'] : "list";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;
        
        switch($action) {
            case "list":
                $this->list();
                break;
                
            case "chatRoom":
                if($id > 0) {
                    $this->chatRoom($id);
                } else {
                    header("location: index.php?controller=chat");
                    exit;
                }
                break;
                
            case "getChat":
                $this->getChat();
                break;
                
            case "insertChat":
                $this->insertChat();
                break;
                
            case "search":
                $this->search();
                break;
                
            case "getUsers":
                $this->getUsers();
                break;
                
            case "serviceForm":
                if($id > 0) {
                    $this->serviceForm($id);
                } else {
                    header("location: index.php?controller=chat");
                    exit;
                }
                break;
                
            default:
                $this->list();
                break;
        }
    }
    
    public function list() {
        // Get all users except the current user
        $currentUserId = $_SESSION['user_id'];
        $users = $this->getAvailableUsers($currentUserId);
        
        // Load the users view
        include "Views/chat/users.php";
    }
    
    public function chatRoom($id) {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])){
            header("location: index.php?controller=default");
            exit;
        }
        
        // Get the user to chat with
        $chatUser = new Users($id);
        
        // Make sure the user exists
        if(!$chatUser || !$chatUser->id) {
            header("location: index.php?controller=chat");
            exit;
        }
        
        // Load the chat view
        include "Views/chat/chat.php";
    }
    
    public function getAvailableUsers($currentUserId) {
        // Get all users except the current user
        $allUsers = Users::getAllExcept($currentUserId);
        return $allUsers;
    }
    
    public function search() {
        if(!isset($_SESSION['user_id'])){
            echo "Unauthorized";
            exit;
        }
        
        $outgoing_id = $_SESSION['user_id'];
        $searchTerm = $_POST['searchTerm'];
        
        $users = Users::search($searchTerm, $outgoing_id);
        
        $output = "";
        if(count($users) > 0) {
            foreach($users as $user) {
                // Format each user for display
                $output .= $this->formatUserForList($user, $outgoing_id);
            }
        } else {
            $output .= "No users found related to your search term";
        }
        echo $output;
    }
    
    public function getChat() {
        if(!isset($_SESSION['user_id'])){
            echo "Unauthorized";
            exit;
        }
        
        $outgoing_id = $_SESSION['user_id'];
        $incoming_id = $_POST['incoming_id'];
        
        $messages = Chat::getMessages($incoming_id, $outgoing_id);
        
        $output = "";
        
        if(empty($messages)) {
            $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
        } else {
            foreach($messages as $message) {
                if($message['outgoing_msg_id'] == $outgoing_id) {
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $message['msg'] .'</p>
                                </div>
                                </div>';
                } else {
                    $output .= '<div class="chat incoming">
                                <img src="/NurseProject/Views/images/profile/default.png" alt="">
                                <div class="details">
                                    <p>'. $message['msg'] .'</p>
                                </div>
                                </div>';
                }
            }
        }
        
        echo $output;
    }
    
    public function insertChat() {
        if(!isset($_SESSION['user_id'])){
            echo "Unauthorized";
            exit;
        }
        
        $outgoing_id = $_SESSION['user_id'];
        $incoming_id = $_POST['incoming_id'];
        $message = $_POST['message'];
        
        if(!empty($message)) {
            $result = Chat::insertMessage($incoming_id, $outgoing_id, $message);
            if($result) {
                echo "success";
            } else {
                echo "Failed to insert message";
            }
        }
    }
    
    public function getUsers() {
        if(!isset($_SESSION['user_id'])){
            echo "Unauthorized";
            exit;
        }
        
        $currentUserId = $_SESSION['user_id'];
        $users = $this->getAvailableUsers($currentUserId);
        
        $output = "";
        if(count($users) > 0) {
            foreach($users as $user) {
                $output .= $this->formatUserForList($user, $currentUserId);
            }
        } else {
            $output .= "No users are available to chat";
        }
        echo $output;
    }
    
    private function formatUserForList($user, $currentUserId) {
        $lastMessage = "Click to start chatting";
        
        $offline = ($user->status == "Offline now") ? "offline" : "";
        
        return '<a href="/NurseProject/index.php?controller=chat&action=chatRoom&id='. $user->id .'">
                <div class="content">
                    <img src="/NurseProject/Views/images/profile/default.png" alt="">
                    <div class="details">
                        <span>'. $user->firstName .' '. $user->lastName .'</span>
                        <p>'. $lastMessage .'</p>
                    </div>
                </div>
                <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                </a>';
    }
    
    public function serviceForm($id) {
        if(!isset($_SESSION['user_id'])){
            header("location: index.php?controller=login&action=login");
            exit;
        }
        
        $userId = $_SESSION['user_id'];
        $nurseId = $id;
        
        include "/NurseProject/Views/ServiceForm/serviceform.php";
    }
}
