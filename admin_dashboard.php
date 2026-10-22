
<?php if(session_status()===PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TrackBook</title>
<link rel="stylesheet" href="style.css">
<script defer src="script.js"></script>
</head>
<body>
<header class="site-nav">
  <nav class="container nav-flex">
    <a href="index.php" class="brand brand-with-logo">
      <img src="logo.png" alt="TrackBook Logo" class="logo">
      <span>TrackBook</span>
    </a>
    <ul class="nav-links">
      <li><a>Admin Dashboard</a></li>
     
      
      <?php
    // Show logout only if a user is logged in
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!empty($_SESSION['student_id']) || !empty($_SESSION['teacher_id']) || !empty($_SESSION['admin'])): ?>
      <li><a href="logout.php">Logout</a></li>
    <?php endif; ?>
</ul>
  </nav>
</header>
<main class="container main-area">



















<?php include 'db.php';
if(empty($_SESSION['admin'])){ header("Location: admin_login.php"); exit; }

$tmsg="";
if(isset($_POST['add_teacher'])){
  $tid = $_POST['teacher_id']??'';
  $tname = $_POST['name']??'';
  $tpw = $_POST['password']??'';
  if($tid && $tname && $tpw){
    $stmt=$conn->prepare("INSERT INTO teachers (teacher_id,name,password) VALUES (?,?,?)");
    $stmt->bind_param("sss",$tid,$tname,$tpw);
    if($stmt->execute()){
      echo "<script>alert('Teacher registered successfully');</script>";
    }else{
      if($conn->errno == 1062){
        echo "<script>alert('Teacher ID already exists');</script>";
      }else{
        $tmsg="<span class='error'>".$conn->error."</span>";
      }
    }
    $stmt->close();
  } else { $tmsg="<span class='warning'>Fill all fields.</span>"; }
}

$filter = $_GET['year'] ?? '';
$q = trim($_GET['q'] ?? '');
$sql = "SELECT id,name,student_id,course_year FROM students WHERE 1";
$params=[]; $types="";
if($filter!==""){ $sql.=" AND course_year=?"; $types.="s"; $params[]=$filter; }
if($q!==""){ $sql.=" AND (student_id LIKE CONCAT('%',?,'%') OR name LIKE CONCAT('%',?,'%'))"; $types.="ss"; $params[]=$q; $params[]=$q; }
$sql.=" ORDER BY name ASC";
$stmt = $conn->prepare($sql);
if($types){ $stmt->bind_param($types, ...$params); }
$stmt->execute();
$students = $stmt->get_result();

$pending = $conn->query("SELECT id, student_id, teacher_id, attendance, grade, status, created_at FROM pending_updates WHERE status='pending' ORDER BY created_at DESC");
$feedback = $conn->query("SELECT id, student_id, message, status, created_at FROM feedback ORDER BY created_at DESC");
?>



<div class="card center">
  <h2>Welcome, Amita & Prajwal</h2>
</div>

<!-- <a class="btn" href="logout.php" style="margin-left: 90%;">Logout</a>-->
<div class="grid two">
  <div class="card">
    <h2>Add Teacher</h2>
    <form method="post" class="grid two">
      <input type="hidden" name="add_teacher" value="1">
      <div><label>Teacher ID</label><input name="teacher_id" required></div>
      <div><label>Name</label><input name="name" required></div>
      <div><label>Password</label><input name="password" required></div>
      <button class="btn" type="submit">Add</button>
    </form>
    <div style="margin-top:8px"><?php echo $tmsg; ?></div>
  </div>

  <div class="card">
    <h2>Pending Attendance/Grade</h2>
    <table class="table">
      <tr><th>Student ID</th><th>Teacher</th><th>Attendance</th><th>Grade</th><th>Actions</th></tr>
      <?php while($row=$pending->fetch_assoc()): ?>
        <tr>
          <td><?php echo htmlspecialchars($row['student_id']);?></td>
          <td><?php echo htmlspecialchars($row['teacher_id']);?></td>
          <td><?php echo htmlspecialchars($row['attendance']??'-');?></td>
          <td><?php echo htmlspecialchars($row['grade']??'-');?></td>
          <td class="actions">
            <form method="post" action="approve.php" style="display:inline">
              <input type="hidden" name="id" value="<?php echo $row['id'];?>">
              <button class="btn" name="action" value="approve">Approve</button>
            </form>
            <form method="post" action="approve.php" style="display:inline">
              <input type="hidden" name="id" value="<?php echo $row['id'];?>">
              <button class="btn" name="action" value="reject">Reject</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>
</div>

<div class="card">

  <h2>Students</h2>
  <form class="search-row" method="get">
    <label>Filter Year</label>
    <select name="year">
      <option value="">All</option>
      <option value="1" <?php if($filter==='1') echo 'selected';?>>1</option>
      <option value="2" <?php if($filter==='2') echo 'selected';?>>2</option>
      <option value="3" <?php if($filter==='3') echo 'selected';?>>3</option>
    </select>
    <input name="q" placeholder="Search by Student ID or Name" value="<?php echo htmlspecialchars($q); ?>">
    <button class="btn" type="submit">Apply</button>
    
  </form>
  <table class="table" style="margin-top:10px">
    <tr><th>Name</th><th>Student ID</th><th>Year</th><th>Actions</th></tr>
    <?php while($s=$students->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($s['name']);?></td>
        <td><?php echo htmlspecialchars($s['student_id']);?></td>
        <td><?php echo htmlspecialchars($s['course_year']);?></td>
        <td class="actions">
          <a class="btn" href="edit_student.php?id=<?php echo $s['id'];?>">Edit</a>
          <a class="btn" href="delete_student.php?id=<?php echo $s['id'];?>" onclick="return confirm('Delete student?')">Delete</a>
        </td>
      </tr>
    <?php endwhile; $stmt->close(); ?>
  </table>
</div>

<div class="card">
  <h2>Feedback</h2>
  <table class="table">
    <tr><th>Student ID</th><th>Message</th><th>Status</th><th>Actions</th></tr>
    <?php while($f=$feedback->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($f['student_id']);?></td>
        <td><?php echo nl2br(htmlspecialchars($f['message']));?></td>
        <td><?php echo htmlspecialchars($f['status']);?></td>
        <td class="actions">
          <?php if($f['status']!=='read'): ?>
          <form method="post" action="mark_read.php">
            <input type="hidden" name="id" value="<?php echo $f['id'];?>">
            <button class="btn" type="submit">Mark Read</button>
          </form>
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>
<?php include 'footer.php'; ?>
