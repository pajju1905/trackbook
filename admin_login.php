<?php include 'header.php'; include 'db.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $u = $_POST['username']??'';
  $p = $_POST['password']??'';
  $stmt = $conn->prepare("SELECT id FROM admins WHERE username=? AND password=?");
  $stmt->bind_param("ss",$u,$p);
  $stmt->execute();
  $stmt->bind_result($id);
  if($stmt->fetch()){ $_SESSION['admin']= $u; echo "<script>window.location='admin_dashboard.php?msg=".urlencode('Welcome admin')."';</script>";exit; }
  else { $err="Invalid admin credentials."; }
  $stmt->close();
}
?>
<div class="card" style="justify-items: center;">
  <h2>Admin Login</h2>
  <?php if(!empty($err)) echo "<p class='error'>$err</p>"; ?>
  <form method="post" class="grid two">
    <div style="margin-top: 15px;"><label>Username</label><input name="username" required>
    <div style="margin-top: 15px;"><label>Password</label><input type="password" name="password" required></div>
    <button class="btn" type="submit">Login</button>
  <a class='btn' href='javascript:history.back()' style="margin-top: 15px;">Back</a></div>
</form>
</div>
<?php include 'footer.php'; ?>
