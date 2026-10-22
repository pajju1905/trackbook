<?php include 'header.php'; include 'db.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $tid = $_POST['teacher_id']??'';
  $pw = $_POST['password']??'';
  $stmt = $conn->prepare("SELECT name FROM teachers WHERE teacher_id=? AND password=?");
  $stmt->bind_param("ss",$tid,$pw);
  $stmt->execute();
  $stmt->bind_result($name);
  if($stmt->fetch()){
    $_SESSION['teacher_id']=$tid;
    $_SESSION['teacher_name']=$name;
    echo "<script>window.location='teacher_dashboard.php?msg=".urlencode('Welcome '.$name)."';</script>";exit;
  } else {echo '<script>alert("Invalid credentials.")</script>';}
  $stmt->close();
}
?>
<div class="card" style="justify-items: center;">
  <h2>Teacher Login</h2>
  <?php if(!empty($err)) echo "<p class='error'>$err</p>"; ?>
  <form method="post" class="grid two">
    <div style="margin-top: 15px;"><label>Teacher ID</label><input name="teacher_id" required>
    <div style="margin-top: 15px;"><label>Password</label><input type="password" name="password" required ></div>
    <button class="btn" type="submit">Login</button>
  <a class='btn' href='javascript:history.back()' style="margin-top: 15px;">Back</a></div>
</form>
</div>
<?php include 'footer.php'; ?>