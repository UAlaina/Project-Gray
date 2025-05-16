<h2>Your Conversations</h2>

<div class="chat-list" style="max-width: 700px; margin: auto;">
    <?php if (!empty($chats)): ?>
        <ul>
            <?php foreach ($chats as $chat): ?>
                <li style="margin-bottom: 10px;">
                    <a href="index.php?controller=chat&action=view&chatRoomId=<?= $chat->chatRoomId ?>">
                        <?php if ($userType === 'nurse'): ?>
                            <strong><?= htmlspecialchars($chat->clientFirstName . ' ' . $chat->clientLastName) ?></strong>
                        <?php else: ?>
                            <strong><?= htmlspecialchars($chat->nurseFirstName . ' ' . $chat->nurseLastName) ?></strong>
                        <?php endif; ?>
                        <br>
                        Last message: <?= isset($chat->lastMessageTime) ? $chat->lastMessageTime : $chat->createAt ?>
                        <?php if ($chat->unreadCount > 0): ?>
                            <strong>(<?= $chat->unreadCount ?> new)</strong>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>You have no active chats.</p>
    <?php endif; ?>
</div>
