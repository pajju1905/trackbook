<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$current = basename($_SERVER['PHP_SELF']);
?>

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
        <img src="logo.png" class="logo" alt="TrackBook Logo">
        <span>TrackBook</span>
    </a>

    <ul class="nav-links">
        <?php
        if (!empty($_SESSION['student_id'])) {
            echo '<li><a href="student_dashboard.php">Student Dashboard</a></li>';
            echo '<li><a href="about.php">About Us</a></li>';
            echo '<li><a href="logout.php">Logout</a></li>';

        } elseif (!empty($_SESSION['teacher_id'])) {
            echo '<li><a href="teacher_dashboard.php">Teacher Dashboard</a></li>';
            echo '<li><a href="about.php">About Us</a></li>';
            echo '<li><a href="logout.php">Logout</a></li>';

        } elseif (!empty($_SESSION['admin'])) {
            echo '<li><a href="admin_dashboard.php">Admin Dashboard</a></li>';
            echo '<li><a href="about.php">About Us</a></li>';
            echo '<li><a href="logout.php">Logout</a></li>';

        } else {
            if ($current === "student_login.php") {
                echo '<li><a href="student_login.php">Student Login</a></li>';
                echo '<li><a href="about.php">About Us</a></li>';

            } elseif ($current === "teacher_login.php") {
                echo '<li><a href="teacher_login.php">Teacher Login</a></li>';
                echo '<li><a href="about.php">About Us</a></li>';

            } elseif ($current === "admin_login.php") {
                echo '<li><a href="admin_login.php">Admin Login</a></li>';
                echo '<li><a href="about.php">About Us</a></li>';

            } else {
                echo '<li><a href="register.php">Register</a></li>';
                echo '<li><a href="about.php">About Us</a></li>';
                echo '<li><a href="student_login.php">Student Login</a></li>';
                echo '<li><a href="teacher_login.php">Teacher Login</a></li>';
                echo '<li><a href="admin_login.php">Admin Login</a></li>';
            }
        }
        ?>
    </ul>
</nav>
</header>

<main class="container main-area">
