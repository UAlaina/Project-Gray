<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Chat with <?php echo $chatUser->firstName; ?> - HomeCare Service</title>
  <link rel="stylesheet" href="/NurseProject/Views/styles/chat.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
</head>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <a href="/NurseProject/index.php?controller=chat" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="/NurseProject/Views/images/profile/default.png" alt="">
        <div class="details">
          <span><?php echo $chatUser->firstName . " " . $chatUser->lastName; ?></span>
          <p>Active now</p>
        </div>
        <a href="/NurseProject/Views/ServiceForm/serviceform.php?user_id=<?= $chatUser->id ?>" class="service-form-btn">
          Service Form
        </a>
      </header>
      <div class="chat-box">
      </div>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $chatUser->id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="/NurseProject/Views/javascript/chat.js"></script>
</body>
</html>

