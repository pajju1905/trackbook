<?php include 'header.php'; include 'db.php';
if(empty($_SESSION['admin'])){ header("Location: admin_login.php"); exit; }
$id = intval($_GET['id']??0);
$stmt = $conn->prepare("SELECT id, name, student_id, course_year, dob, mobile, email, gender, address, attendance, grade FROM students WHERE id=?");
$stmt->bind_param("i",$id); $stmt->execute(); $r=$stmt->get_result()->fetch_assoc(); $stmt->close();
if(!$r){ echo "<div class='card'>Student not found.</div>"; include 'footer.php'; exit; }

$msg="";
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=$_POST['name']; $sid=$_POST['student_id']; $year=$_POST['course_year']; $dob=$_POST['dob'];
  $mobile=$_POST['mobile']; $email=$_POST['email']; $gender=$_POST['gender']; $address=$_POST['address'];
  $attendance=$_POST['attendance']; $grade=$_POST['grade'];
  $stmt=$conn->prepare("UPDATE students SET name=?, student_id=?, course_year=?, dob=?, mobile=?, email=?, gender=?, address=?, attendance=?, grade=? WHERE id=?");
  $stmt->bind_param("ssssssssssi",$name,$sid,$year,$dob,$mobile,$email,$gender,$address,$attendance,$grade,$id);
  if($stmt->execute()) echo '<script>alert("Updated")</script>'; else $msg="<p class='error'>".$conn->error."</p>";
  $stmt->close();
  $stmt = $conn->prepare("SELECT id, name, student_id, course_year, dob, mobile, email, gender, address, attendance, grade FROM students WHERE id=?");
  $stmt->bind_param("i",$id); $stmt->execute(); $r=$stmt->get_result()->fetch_assoc(); $stmt->close();
}
?>
<div class="card">
  <h2>Edit Student</h2>
  <?php echo $msg; ?>
  <form method="post" class="grid two">
    <div><label>Name</label><input name="name" value="<?php echo htmlspecialchars($r['name']);?>"></div>
    <div><label>Student ID</label><input name="student_id" value="<?php echo htmlspecialchars($r['student_id']);?>"></div>
    <div><label>Course Year</label>
      <select name="course_year">
        <option value="1" <?php if($r['course_year']=='1') echo 'selected';?>>1</option>
        <option value="2" <?php if($r['course_year']=='2') echo 'selected';?>>2</option>
        <option value="3" <?php if($r['course_year']=='3') echo 'selected';?>>3</option>
      </select>
    </div>
    <div><label>DOB</label><input type="date" name="dob" value="<?php echo htmlspecialchars($r['dob']);?>"></div>
    <div><label>Mobile</label><input name="mobile" value="<?php echo htmlspecialchars($r['mobile']);?>"></div>
    <div><label>Email</label><input name="email" value="<?php echo htmlspecialchars($r['email']);?>"></div>
    <div style="margin-top:8px; margin-right: 100px">
  <label>Gender:</label><br>
  <label>
    <input type="radio" name="gender" value="Male" <?php if($r['gender']=='Male') echo 'checked'; ?>> Male
  </label>
  <label>
    <input type="radio" name="gender" value="Female" <?php if($r['gender']=='Female') echo 'checked'; ?>> Female
  </label>
</div>

    <div><label>Address</label><textarea name="address"><?php echo htmlspecialchars($r['address']);?></textarea></div>
    <div><label>Attendance</label><input name="attendance" value="<?php echo htmlspecialchars($r['attendance']);?>"></div>
    <div><label>Grade</label><input name="grade" value="<?php echo htmlspecialchars($r['grade']);?>"></div>
    <button class="btn" type="submit">Save</button>
    <a class="btn" href="admin_dashboard.php">Back</a>
  </form>
</div>
<?php include 'footer.php'; ?>
