<?php include 'header.php'; include 'db.php';
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name       = trim($_POST['name'] ?? '');
  $student_id = trim($_POST['student_id'] ?? '');
  $course_year= trim($_POST['course_year'] ?? '');
  $dob        = trim($_POST['dob'] ?? '');
  $mobile     = trim($_POST['mobile'] ?? '');
  $email      = trim($_POST['email'] ?? '');
  $gender     = trim($_POST['gender'] ?? '');
  $address    = trim($_POST['address'] ?? '');

  if ($name && $student_id && $course_year && $dob) {
    // Check for duplicate student ID first
    $check = $conn->prepare("SELECT id FROM students WHERE student_id=? LIMIT 1");
    $check->bind_param("s", $student_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
      echo "<script>alert('Student ID already exists. Please use a different ID.');</script>";
    } else {
      $stmt = $conn->prepare("INSERT INTO students (student_id, name, course_year, dob, mobile, email, gender, address) VALUES (?,?,?,?,?,?,?,?)");
      $stmt->bind_param("ssssssss", $student_id, $name, $course_year, $dob, $mobile, $email, $gender, $address);

      if ($stmt->execute()) {
        echo "<script>alert('Registration successful. Please login.');window.location='student_login.php';</script>";
        exit;
      } else {
        // Handle duplicate error just in case, or show a generic message
        if ($stmt->errno == 1062 || $conn->errno == 1062) {
          echo "<script>alert('Student ID already exists. Please use a different ID.');</script>";
        } else {
          $msg = "<p class='error'>Something went wrong. Please try again later.</p>";
        }
      }
      $stmt->close();
    }
    $check->close();
  } else {
    $msg = "<p class='error'>Please fill all required (*) fields.</p>";
  }
}
?>
<div class="card">
  <h2>Student Registration</h2>
  <?php echo $msg; ?>
  <form method="post" class="grid two">
    <div>
      <label>Name*</label>
      <input name="name" required>
    </div>
    <div>
      <label>Student ID*</label>
      <input name="student_id" required>
    </div>
    <div>
      <label>Course Year*</label>
      <select name="course_year" required>
        <option value="">--select--</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
      </select>
    </div>
    <div>
      <label>Date of Birth (YYYY-MM-DD)*</label>
      <input type="date" name="dob" required>
    </div>
    <div>
      <label>Mobile</label>
      <input name="mobile">
    </div>
    <div>
      <label>Email</label>
      <input type="email" name="email">
    </div>
    <div>
      <label>Gender:</label><br>
      <label><input type="radio" name="gender" value="Male" required> Male</label>
      <label style="margin-left:12px;"><input type="radio" name="gender" value="Female"> Female</label>
    </div>
    <div>
      <label>Address</label>
      <textarea name="address"></textarea>
    </div>
    <div class="helper" style="justify-content: center;">
      <button class="btn" type="submit">Submit</button>
      <button class="btn" type="reset">Reset</button></div>
      <div class="helper" style="justify-content: center;"><a class="btn" href="javascript:history.back()">Back</a></div>
    
  </form>
</div>
<?php include 'footer.php'; ?>
