<?php include_once "NurseProject/Views/chat/header.php"; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <?php if ($userType === 'nurse'): ?>
                        <h3>Chat with <?php echo htmlspecialchars($chatRoom->clientFirstName . ' ' . $chatRoom->clientLastName); ?></h3>
                        <span class="badge bg-info"><?php echo htmlspecialchars($chatRoom->problem ?? 'No problem specified'); ?></span>
                    <?php else: ?>
                        <h3>Chat with Nurse <?php echo htmlspecialchars($chatRoom->nurseFirstName . ' ' . $chatRoom->nurseLastName); ?></h3>
                        <span class="badge bg-info"><?php echo htmlspecialchars($chatRoom->specialitiesGoodAt ?? 'General Care'); ?></span>
                    <?php endif; ?>
                    <a href="index.php?controller=chat&action=list" class="btn btn-secondary">Back to Chats</a>
                </div>
                <div class="card-body">
                    <div class="chat-container" id="chat-container" style="height: 400px; overflow-y: auto; margin-bottom: 20px; border: 1px solid #ccc; padding: 15px;">
                        <?php if (empty($chatRoom->messagesArray)): ?>
                            <div class="text-center text-muted">
                                <p>No messages yet. Start the conversation!</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($chatRoom->messagesArray as $msg): ?>
                                <div class="message-wrapper <?php echo ($msg['sender_id'] == $userId) ? 'text-end' : 'text-start'; ?> mb-2">
                                    <div class="message <?php echo ($msg['sender_id'] == $userId) ? 'sent' : 'received'; ?>"
                                         style="display: inline-block; max-width: 70%; padding: 10px; border-radius: 10px; 
                                                background-color: <?php echo ($msg['sender_id'] == $userId) ? '#dcf8c6' : '#f1f0f0'; ?>">
                                        <div class="message-content">
                                            <?php echo htmlspecialchars($msg['message']); ?>
                                        </div>
                                        <div class="message-timestamp" style="font-size: 0.7rem; color: #999; text-align: right;">
                                            <?php echo date('H:i', strtotime($msg['timestamp'])); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <form id="message-form" class="d-flex">
                        <input type="hidden" id="chatRoomId" value="<?php echo $chatRoom->chatRoomId; ?>">
                        <input type="hidden" id="userId" value="<?php echo $userId; ?>">
                        <input type="hidden" id="lastMessageId" value="<?php echo !empty($chatRoom->messagesArray) ? end($chatRoom->messagesArray)['msg_id'] : 0; ?>">
                        <input type="text" id="message-input" class="form-control me-2" placeholder="Type your message..." required>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="NurseProject/Views/javascript/chat.js"></script>
<?php include_once "NurseProject/Views/chat/footer.php"; ?>