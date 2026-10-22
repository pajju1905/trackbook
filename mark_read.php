<?php include 'db.php'; session_start();
if(empty($_SESSION['admin'])){ header("Location: admin_login.php"); exit; }
$id = intval($_POST['id']??0);
if($id){ $conn->query("UPDATE feedback SET status='read' WHERE id=".$id); }
header("Location: admin_dashboard.php");
