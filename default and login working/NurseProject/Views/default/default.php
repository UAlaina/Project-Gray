<?php
$PATH = $_SERVER['SCRIPT_NAME'];
$basePath = dirname($PATH);

$tagline = isset($featuredContent['tagline']) ? $featuredContent['tagline'] : 'Healing Hands, Familiar Spaces';
$mainContent = isset($featuredContent['mainContent']) ? $featuredContent['mainContent'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HomeCare Service - <?php echo htmlspecialchars($tagline); ?></title>
  <link rel="stylesheet" href="<?php echo $basePath; ?>/Views/styles/defaultstyle.css">
</head>
<body>
  <div class="pattern"></div>
  <div class="container">
    <header>
      <div class="logo-placeholder"></div>
      <div class="top-nav">
        <!-- <a href="<?php echo $basePath; ?>/Views/NurseRegistration/nurseRegistration.php">Career</a> -->
        <a href="<?php echo $basePath; ?>/Views/NurseRegistration/nurseRegistration.php">Career</a>
        <button class="login-btn" onclick="window.location.href='<?php echo $basePath; ?>/Views/PatientLogin/patientlogin.php'">Login</button>
      </div>
    </header>
    
    <main>
      <section class="hero">
        <div class="logo">
          <img src="<?php echo $basePath; ?>/Views/images/logo.png" alt="HomeCare Service Logo" />
        </div>
        <h1><?php echo htmlspecialchars($tagline); ?></h1>
        <?php if (!empty($mainContent)): ?>
          <p class="main-content"><?php echo htmlspecialchars($mainContent); ?></p>
        <?php endif; ?>
        <!-- <button class="get-started-btn" onclick="window.location.href='<?php echo $basePath; ?>/Views/PatientLogin/patientlogin.php'">Get Started</button> -->
        <a href="<?php echo dirname($path);?>/Views/PatientLogin/patientLogin,php"><input type="button" name="" value="Login"/></a>
      </section>
      
      <!-- <?php if (!empty($services)): ?>
      <section class="services">
        <h2>Our Services</h2>
        <div class="services-grid">
          <?php foreach ($services as $service): ?>
            <div class="service-card">
              <h3><?php echo htmlspecialchars($service['name']); ?></h3>
              <p><?php echo htmlspecialchars($service['description']); ?></p>
              <a href="<?php echo $basePath; ?>/default/services" class="learn-more">Learn More</a>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
      <?php endif; ?>
    </main> -->
    
    <footer>
      <div class="footer-content">
        <div class="footer-logo">
          <!-- <img src="<?php echo $basePath; ?>/Views/images/logo.png" alt="HomeCare Service Logo" /> -->
        </div>
        <div class="footer-links">
          <h3>Quick Links</h3>
          <ul>
            <li><a href="<?php echo $basePath; ?>/default">Home</a></li>
            <li><a href="<?php echo $basePath; ?>/default/services">Services</a></li>
            <li><a href="<?php echo $basePath; ?>/default/nurses">Our Nurses</a></li>
            <li><a href="<?php echo $basePath; ?>/Views/php/nurseRegistration.php">Join Our Team</a></li>
          </ul>
        </div>
        <div class="footer-contact">
          <h3>Contact Us</h3>
          <p>Email: contact@homecare.com</p>
          <p>Phone: (123) 456-7890</p>
        </div>
      </div>
      <div class="copyright">
        <p>&copy; <?php echo date('Y'); ?> HomeCare Service. All rights reserved.</p>
      </div>
    </footer>
  </div>
</body>
</html>
