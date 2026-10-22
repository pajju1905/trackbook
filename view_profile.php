<?php include 'header.php'; include 'db.php';
if (empty($_SESSION['student_id'])) { header("Location: student_login.php"); exit; }

$student_id = $_SESSION['student_id'];

$stmt = $conn->prepare("SELECT name, student_id, course_year, dob, mobile, email, gender, address, attendance, grade FROM students WHERE student_id=?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$stmt->bind_result($name, $sid, $year, $dob, $mobile, $email, $gender, $address, $attendance, $grade);
$stmt->fetch();
$stmt->close();
?>
<button class="btn back-btn" onclick="history.back()">Back</button>
<div class="card">
  <div class="helper">
    <div class="avatar" style="justify-items: left;"></div>
    <div>
      <h2><?php echo htmlspecialchars($name); ?></h2>
      <div class="small">Student ID: <?php echo htmlspecialchars($sid); ?> · Year <?php echo htmlspecialchars($year); ?></div>
    </div>
  </div>
  <table class="table" style="margin-top:10px">
    <tr><th>DOB</th><td><?php echo htmlspecialchars($dob); ?></td></tr>
    <tr><th>Mobile</th><td><?php echo htmlspecialchars($mobile); ?></td></tr>
    <tr><th>Email</th><td><?php echo htmlspecialchars($email); ?></td></tr>
    <tr><th>Gender</th><td><?php echo htmlspecialchars($gender); ?></td></tr>
    <tr><th>Address</th><td><?php echo nl2br(htmlspecialchars($address)); ?></td></tr>
    <tr><th>Attendance</th><td><?php echo htmlspecialchars($attendance ?? '-'); ?></td></tr>
    <tr><th>Grade</th><td><?php echo htmlspecialchars($grade ?? '-'); ?></td></tr>
  </table>
</div>
<?php include 'footer.php'; ?>
