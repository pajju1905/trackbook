<?php include 'db.php'; session_start();
if(empty($_SESSION['admin'])){ header("Location: admin_login.php"); exit; }
$id = intval($_GET['id']??0);
if($id){
  $r = $conn->query("SELECT student_id FROM students WHERE id=".$id)->fetch_assoc();
  if($r){
    $sid = $r['student_id'];
    $conn->query("DELETE FROM pending_updates WHERE student_id='".$conn->real_escape_string($sid)."'");
    $conn->query("DELETE FROM feedback WHERE student_id='".$conn->real_escape_string($sid)."'");
  }
  $conn->query("DELETE FROM students WHERE id=".$id);
}
header("Location: admin_dashboard.php");
