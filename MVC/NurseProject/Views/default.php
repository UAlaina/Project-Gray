<?php
$PATH = $_SERVER['SCRIPT_NAME'];
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HomeCare Service - Healing Hands, Familiar Spaces</title>
  <link rel="stylesheet" href="Views/styles/defaultstyle.css">
</head>
<body>
  <div class="pattern"></div>
  <div class="container">
    <header>
      <div class="logo-placeholder"></div>
      <div class="top-nav">
        <a href="Views/html/nurseRegistration.html">Career</a>
        <button class="login-btn" onclick="window.location.href='Views/html/patientlogin.html'">Login</button>
      </div>
    </header>
    
    <main>
      <section class="hero">
        <div class="logo">
          <img src="Views/images/logo.png" alt="HomeCare Service Logo" />
        </div>
        <button class="get-started-btn" onclick="window.location.href='Views/html/patientlogin.html'">Get Started</button>
      </section>
    </main>
  </div>
</body>
</html>