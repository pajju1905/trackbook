<?php include 'db.php'; session_start();
if(empty($_SESSION['teacher_id'])){ header("Location: teacher_login.php"); exit; }
$student_id = $_POST['student_id']??'';
$attendance = trim($_POST['attendance']??'');
$grade = trim($_POST['grade']??'');
if($student_id && ($attendance!=='' || $grade!=='')){
  $stmt = $conn->prepare("INSERT INTO pending_updates (student_id, teacher_id, attendance, grade) VALUES (?,?,?,?)");
  $stmt->bind_param("ssss", $student_id, $_SESSION['teacher_id'], $attendance, $grade);
  $stmt->execute();
  $stmt->close();
}
header("Location: teacher_dashboard.php");
