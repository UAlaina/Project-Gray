<?php include_once "header.php"; ?>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="search">
                <span class="text">Select a chat to start</span>
                <input type="text" placeholder="Enter name to search...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">
                <?php if (isset($chat_rooms) && !empty($chat_rooms)): ?>
                    <?php foreach ($chat_rooms as $chat): ?>
                        <?php
                        $messages = json_decode($chat->messages, true) ?: [];
                        $last_msg = end($messages);
                        $msg = $last_msg ? $last_msg['message'] : "No messages yet";
                        $msg = strlen($msg) > 28 ? substr($msg, 0, 28) . '...' : $msg;
                        $you = $last_msg && $last_msg['sender_id'] == $user_id ? "You: " : "";
                        $other_user = Chat::getOtherUser($chat->chatRoomId, $user_id);
                        ?>
                        <a href="?controller=Chat&action=index&chat_id=<?php echo $chat->chatRoomId; ?>">
                            <div class="content">
                                <img src="<?php echo VIEWS_PATH; ?>/images/default.jpg" alt="">
                                <div class="details">
                                    <span><?php echo htmlspecialchars($other_user ? ($other_user->firstName . " " . $other_user->lastName) : 'Unknown User'); ?></span>
                                    <p><?php echo $you . htmlspecialchars($msg); ?></p>
                                </div>
                            </div>
                            <div class="status-dot"><i class="fas fa-circle"></i></div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No chat rooms available. Start a new chat!</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="chat-area">
            <?php if ($selected_chat && $other_user): ?>
                <header>
                    <img src="<?php echo VIEWS_PATH; ?>/images/default.jpg" alt="">
                    <div class="details">
                        <span><?php echo htmlspecialchars($other_user->firstName . " " . $other_user->lastName); ?></span>
                        <p>Active</p>
                    </div>
                </header>
                <div class="chat-box">
                </div>
                <form action="#" class="typing-area">
                    <input type="text" class="chat_room_id" name="chat_room_id" value="<?php echo $selected_chat->chatRoomId; ?>" hidden>
                    <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
                    <button><i class="fab fa-telegram-plane"></i></button>
                </form>
            <?php else: ?>
                <div class="text">Select a chat to start messaging</div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        console.log('user_id:', <?php echo json_encode($user_id); ?>);
        console.log('chat_rooms:', <?php echo json_encode($chat_rooms); ?>);
    </script>
    <script>
        const user_id = <?php echo json_encode($user_id); ?>;
    </script>
    <script src="<?php echo JS_PATH; ?>/users.js"></script>
    <script src="<?php echo JS_PATH; ?>/chat.js"></script>
</body>
</html>