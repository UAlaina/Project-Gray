<?php
$PATH = $_SERVER['SCRIPT_NAME'];
$basePath = '/NurseProject';

$tagline = isset($featuredContent['tagline']) ? $featuredContent['tagline'] : 'Healing Hands, Familiar Spaces';
$mainContent = isset($featuredContent['mainContent']) ? $featuredContent['mainContent'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HomeCare Service - <?php echo htmlspecialchars($tagline); ?></title>
  <link rel="stylesheet" href="/NurseProject/Views/styles/defaultstyle.css">
</head>
<body>
  <div class="pattern"></div>
  <div class="container">
    <header>
      <div class="logo-placeholder"></div>
      <div class="top-nav">
        <a href="<?php echo $basePath; ?>/nurse/register">Career</a>
        <button class="login-btn" onclick="window.location.href='<?php echo $basePath; ?>/patient/login'">Login</button>
      </div>
    </header>
    
    <main>
      <section class="hero">
        <div class="logo">
          <img src="/NurseProject/Views/images/logo.png" alt="HomeCare Service Logo" />
        </div>
        <h1><?php echo htmlspecialchars($tagline); ?></h1>
        <?php if (!empty($mainContent)): ?>
          <p class="main-content"><?php echo htmlspecialchars($mainContent); ?></p>
        <?php endif; ?>
        <button class="get-started-btn" onclick="window.location.href='<?php echo $basePath; ?>/patient/login'">Get Started</button>
      </section>
  </div>
</body>
</html>
