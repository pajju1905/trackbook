<?php include 'header.php'; include 'db.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $student_id = $_POST['student_id']??'';
  $dob = $_POST['dob']??'';
  if($student_id && $dob){
    $stmt = $conn->prepare("SELECT name FROM students WHERE student_id=? AND dob=?");
    $stmt->bind_param("ss",$student_id,$dob);
    $stmt->execute();
    $stmt->bind_result($name);
    if($stmt->fetch()){
      $_SESSION['student_id']=$student_id;
      $_SESSION['student_name']=$name;
      echo "<script>window.location='student_dashboard.php?msg=".urlencode('Welcome '.$name)."';</script>";exit;
    } else {
     echo '<script>alert("Invalid Student ID or DOB.")</script>';
    }
    $stmt->close();
  } else {$err="Please fill both fields.";}
}
?>
<div class="card" style="justify-items: center;">
  <h2>Student Login</h2>
  <?php if(!empty($err)) echo "<p class='error'>$err</p>"; ?>
  <form method="post" class="grid two">
    <div style="margin-top: 15px;"><label>Student ID</label><input name="student_id" required>
    <div style="margin-top: 15px;"><label>Password</label><input type="date" name="dob" required></div>
    <button class="btn" type="submit">Login</button>
  <a class='btn' href='javascript:history.back()' style="margin-top: 15px;">Back</a></div>
</form>
</div>
<?php include 'footer.php'; ?>
