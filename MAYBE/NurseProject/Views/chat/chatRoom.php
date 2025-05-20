<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Chat Room</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            padding: 20px;
        }
        .chat-container {
            background-color: white;
            padding: 20px;
            max-width: 700px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            border-radius: 10px;
        }
        .back-arrow {
            margin-bottom: 10px;
            cursor: pointer;
            font-size: 20px;
            color: #007bff;
        }
        .message-list {
            border: 1px solid #ccc;
            padding: 10px;
            height: 400px;
            overflow-y: auto;
            margin-bottom: 15px;
        }
        .message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 6px;
        }
        .from-me {
            background-color: #d1f0ff;
            text-align: right;
        }
        .from-them {
            background-color: #f1f1f1;
            text-align: left;
        }
        .timestamp {
            font-size: 10px;
            color: #666;
        }
        form {
            display: flex;
            gap: 10px;
        }
        input[type="text"] {
            flex: 1;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 20px;
            border-radius: 6px;
            background-color: #007bff;
            color: white;
            border: none;
        }
    </style>
</head>
<body>

<div class="chat-container">

    <!-- 🔙 Back Arrow -->
    <div class="back-arrow" onclick="window.location.href='/NurseProject/<?= $_SESSION['user_type'] ?>/mainpage'">
        ← Back to Main Page
    </div>

    <h2>Chat with 
        <?php
        if ($_SESSION['user_type'] === 'nurse') {
            echo htmlspecialchars($chatRoom->clientFirstName . ' ' . $chatRoom->clientLastName);
        } else {
            echo htmlspecialchars($chatRoom->nurseFirstName . ' ' . $chatRoom->nurseLastName);
        }
        ?>
    </h2>

    <div class="message-list">
        <?php foreach ($chatRoom->messagesArray as $msg): ?>
            <div class="message <?= $msg['sender_id'] == $userId ? 'from-me' : 'from-them' ?>">
                <?= htmlspecialchars($msg['message']) ?>
                <div class="timestamp"><?= $msg['timestamp'] ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <form action="index.php?controller=chat&action=sendMessage" method="POST">
        <input type="hidden" name="chatRoomId" value="<?= $chatRoom->chatRoomId ?>">
        <input type="text" name="message" placeholder="Type a message..." required>
        <button type="submit">Send</button>
    </form>
</div>

</body>
</html>
