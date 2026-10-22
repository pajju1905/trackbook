<?php include 'header.php'; include 'db.php';
if(empty($_SESSION['student_id'])){ header("Location: student_login.php"); exit; }
$msg="";
if($_SERVER['REQUEST_METHOD']==='POST'){
  $message = trim($_POST['message']??'');
  if($message){
    $stmt = $conn->prepare("INSERT INTO feedback (student_id, message) VALUES (?,?)");
    $stmt->bind_param("ss", $_SESSION['student_id'], $message);
    if($stmt->execute()){ echo '<script>alert("Feedback Sent")</script>'; } else { $msg="<p class='error'>Error sending.</p>"; }
    $stmt->close();
  } else {$msg="<p class='warning'>Type a message.</p>";}
}
?>
<div class="card">
  <h2>Send Feedback to Admin</h2>
  <?php echo $msg; ?>
  <form method="post">
    <textarea name="message" rows="5" placeholder="Write corrections or any issue..."></textarea>
    <div class="helper" style="margin-top:10px">
      <button class="btn" type="submit">Send</button>
      <a class="btn" href="student_dashboard.php">Back</a>
    </div>
</form>
</div>
<?php include 'footer.php'; ?>
