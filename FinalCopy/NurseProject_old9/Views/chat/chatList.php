<?php include_once "NurseProject/Views/chat/header.php"; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>My Conversations</h3>
                    <a href="index.php?controller=chat&action=create" class="btn btn-primary">Start New Chat</a>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (empty($chats)): ?>
                        <div class="alert alert-info">
                            You don't have any conversations yet. Start a new chat to begin.
                        </div>
                    <?php else: ?>
                        <div class="list-group">
                            <?php foreach ($chats as $chat): ?>
                                <?php 
                                    if ($userType === 'nurse') {
                                        $chatWith = $chat->clientFirstName . ' ' . $chat->clientLastName;
                                        $description = 'Problem: ' . ($chat->clientProblem ?? 'N/A');
                                    } else {
                                        $chatWith = $chat->nurseFirstName . ' ' . $chat->nurseLastName;
                                        $description = 'Specialities: ' . ($chat->nurseSpecialities ?? 'General Care');
                                    }
                                ?>
                                <a href="index.php?controller=chat&action=view&chatRoomId=<?php echo $chat->chatRoomId; ?>" 
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1"><?php echo htmlspecialchars($chatWith); ?></h5>
                                        <p class="mb-1"><?php echo htmlspecialchars($description); ?></p>
                                        <small>Last activity: <?php echo date('M d, Y H:i', strtotime($chat->lastMessageTime)); ?></small>
                                    </div>
                                    <?php if ($chat->unreadCount > 0): ?>
                                        <span class="badge bg-primary rounded-pill"><?php echo $chat->unreadCount; ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "NurseProject/Views/chat/footer.php"; ?>