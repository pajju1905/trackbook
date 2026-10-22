<?php include 'header.php'; include 'db.php';
if(empty($_SESSION['student_id'])){ header("Location: student_login.php"); exit; }
$name = $_SESSION['student_name'] ?? 'Student';
?>
<div class="card center">
  <h2>Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
  <div class="helper" style="justify-content:center;margin-top:10px">
    <a class="btn" href="view_profile.php">View Profile</a>
    <a class="btn" href="feedback.php">Feedback</a>
    <a class="btn" href="logout.php">Logout</a>
  </div>
</div>
<?php include 'footer.php'; ?>
