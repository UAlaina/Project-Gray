<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Chat - HomeCare Service</title>
  <link rel="stylesheet" href="/NurseProject/Views/styles/chat.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
</head>
<body>
  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
          <?php 
            $currentUser = new Users($_SESSION['user_id']);
          ?>
          <img src="/NurseProject/Views/images/profile/default.png" alt="">
          <div class="details">
            <span><?php echo $currentUser->firstName . " " . $currentUser->lastName; ?></span>
            <p>Active now</p>
          </div>
        </div>
        <a href="/NurseProject/index.php?controller=login&action=logout" class="logout">Logout</a>
      </header>
      <div class="search">
        <span class="text">Select a user to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
        <?php if(count($users) > 0): ?>
          <?php foreach($users as $user): ?>
            <a href="/NurseProject/index.php?controller=chat&action=chatRoom&id=<?php echo $user->id; ?>">
              <div class="content">
                <img src="/NurseProject/Views/images/profile/default.png" alt="">
                <div class="details">
                  <span><?php echo $user->firstName . " " . $user->lastName; ?></span>
                  <p>Click to start chatting</p>
                </div>
              </div>
              <div class="status-dot">
                <i class="fas fa-circle"></i>
              </div>
            </a>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="no-users">No users available to chat</div>
        <?php endif; ?>
      </div>
    </section>
  </div>

  <script src="/NurseProject/Views/javascript/users.js"></script>
</body>
</html>