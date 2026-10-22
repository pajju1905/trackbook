<?php include 'header.php'; include 'db.php';
if(empty($_SESSION['teacher_id'])){ header("Location: teacher_login.php"); exit; }
$filter = $_GET['year'] ?? '';
$q = trim($_GET['q'] ?? '');
$sql = "SELECT id,name,student_id,course_year,attendance,grade FROM students WHERE 1";
$params=[]; $types="";
if($filter!==""){
  $sql.=" AND course_year=?"; $types.="s"; $params[]=$filter;
}
if($q!==""){
  $sql.=" AND (student_id LIKE CONCAT('%',?,'%') OR name LIKE CONCAT('%',?,'%'))";
  $types.="ss"; $params[]=$q; $params[]=$q;
}
$sql.=" ORDER BY name ASC";
$stmt = $conn->prepare($sql);
if($types){ $stmt->bind_param($types, ...$params); }
$stmt->execute();
$res = $stmt->get_result();
?>
<div class="card">
  <h2>Teacher Dashboard</h2>
  <!--<a class="btn" href="logout.php" style="margin-left: 90%;">Logout</a>-->
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
    <tr><th>Name</th><th>Student ID</th><th>Year</th><th>Attendance</th><th>Grade</th><th>Action</th></tr>
    <?php while($row=$res->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($row['name']);?></td>
        <td><?php echo htmlspecialchars($row['student_id']);?></td>
        <td><?php echo htmlspecialchars($row['course_year']);?></td>
        <td>
          <form id="form-<?php echo $row['id'];?>" method="post" action="teacher_send.php" class="actions">
            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($row['student_id']);?>">
            <input name="attendance" placeholder="e.g. 85%" value="">
        </td>
        <td><input name="grade" placeholder="e.g. A+" value=""></td>
        <td>
            <button class="btn" type="submit">Send to Admin</button>
          </form>
        </td>
      </tr>
    <?php endwhile; $stmt->close(); ?>
  </table>
</div>
<?php include 'footer.php'; ?>
