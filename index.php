<?php if(session_status()===PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TrackBook</title>
<link rel="stylesheet" href="style.css">
<script defer src="script.js"></script>
</head>
<body>
<header class="site-nav">
  <nav class="container nav-flex">
    <a href="index.php" class="brand brand-with-logo">
      <img src="logo.png" alt="TrackBook Logo" class="logo">
      <span>TrackBook</span>
    </a>
    <ul class="nav-links">
      <li><a href="register.php">Register</a></li>
      <li><a href="about.php">About Us</a></li>
      <li><a href="student_login.php">Student Login</a></li>
      <li><a href="teacher_login.php">Teacher Login</a></li>
      <li><a href="admin_login.php">Admin Login</a></li>
    </ul>
  </nav>
</header>
<main class="container main-area">

<section class="hero">
  <div>
    <h1>TrackBook</h1>

</section>



<?php include 'footer.php'; ?>

