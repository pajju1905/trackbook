<?php include 'db.php'; session_start();
if(empty($_SESSION['admin'])){ header("Location: admin_login.php"); exit; }

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$action = $_POST['action'] ?? '';

if($id && in_array($action, ['approve','reject'], true)){
  $stmt = $conn->prepare("SELECT student_id, attendance, grade FROM pending_updates WHERE id=? AND status='pending'");
  $stmt->bind_param("i",$id);
  $stmt->execute();
  $stmt->bind_result($student_id,$attendance,$grade);
  if($stmt->fetch()){
    $stmt->close();

    if($action === 'approve'){
      $att = ($attendance === '' ? NULL : $attendance);
      $grd = ($grade === '' ? NULL : $grade);

      $stmt2 = $conn->prepare("
        UPDATE students
        SET attendance = COALESCE(?, attendance),
            grade      = COALESCE(?, grade)
        WHERE student_id = ?
      ");
      $stmt2->bind_param("sss", $att, $grd, $student_id);
      $stmt2->execute();
      $stmt2->close();

      $upd = $conn->prepare("UPDATE pending_updates SET status='approved' WHERE id=?");
      $upd->bind_param("i",$id);
      $upd->execute();
      $upd->close();
    } else {
      $upd = $conn->prepare("UPDATE pending_updates SET status='rejected' WHERE id=?");
      $upd->bind_param("i",$id);
      $upd->execute();
      $upd->close();
    }
  } else {
    $stmt->close();
  }
}

header("Location: admin_dashboard.php");
exit;
