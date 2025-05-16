<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room</title>
    <link rel="stylesheet" type="text/css" href="/NurseProject/Views/styles/chat.css">
</head>
<body>
<div class="chat-container">
    <header class="chat-header">
        <h2>Chat with 
            <?php
            if ($_SESSION['user_type'] === 'nurse') {
                echo htmlspecialchars($chatRoom->clientFirstName . ' ' . $chatRoom->clientLastName);
            } else {
                echo htmlspecialchars($chatRoom->nurseFirstName . ' ' . $chatRoom->nurseLastName);
            }
            ?>
        </h2>
    </header>

    <div class="message-list">
        <?php foreach ($chatRoom->messagesArray as $msg): ?>
            <div class="message <?= $msg['sender_id'] == $userId ? 'from-me' : 'from-them' ?>">
                <p><?= htmlspecialchars($msg['message']) ?></p>
                <div class="timestamp"><?= $msg['timestamp'] ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <form action="index.php?controller=chat&action=sendMessage" method="POST" class="chat-form">
        <input type="hidden" name="chatRoomId" value="<?= $chatRoom->chatRoomId ?>">
        <input type="text" name="message" placeholder="Type a message..." required>
        <button type="submit">Send</button>
    </form>
</div>
</body>
</html>