<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
  if(isset($_POST['add_student'])){
    $sid = $conn->real_escape_string($_POST['student_id']);
    $username = $conn->real_escape_string($_POST['username']);
    $pw = $conn->real_escape_string($_POST['password']);
    $fn = $conn->real_escape_string($_POST['first_name']);
    $ln = $conn->real_escape_string($_POST['last_name']);
    $conn->query("INSERT INTO students (student_id, username, password, first_name, last_name) VALUES ('$sid','$username','$pw','$fn','$ln')");
    echo '<div class="alert alert-success mt-3">✅ Student added successfully.</div>';
  }

  if(isset($_POST['delete_student'])){
    $id = (int)$_POST['id'];
    $conn->query('DELETE FROM students WHERE id='.$id);
    echo '<div class="alert alert-danger mt-3">🗑️ Student deleted.</div>';
  }
}

$students = $conn->query('SELECT * FROM students ORDER BY id DESC');
?>

<!-- Include Bootstrap 5 + DataTables + Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<div class="container mt-4">
  <h2 class="text-primary mb-4"><i class="bi bi-people"></i> Manage Students</h2>

  <!-- Add Student Form -->
  <div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
      <i class="bi bi-person-plus"></i> Add New Student
    </div>
    <div class="card-body">
      <form method="post" class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Student ID</label>
          <input type="text" name="student_id" class="form-control" placeholder="e.g., STU010" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" placeholder="Username">
        </div>
        <div class="col-md-4">
          <label class="form-label">Password</label>
          <input type="text" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">First Name</label>
          <input type="text" name="first_name" class="form-control" placeholder="First name">
        </div>
        <div class="col-md-6">
          <label class="form-label">Last Name</label>
          <input type="text" name="last_name" class="form-control" placeholder="Last name">
        </div>
        <div class="col-12">
          <button class="btn btn-success" name="add_student" type="submit">
            <i class="bi bi-person-plus-fill"></i> Add Student
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Student Table -->
  <div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
      <i class="bi bi-list-ul"></i> Registered Students
    </div>
    <div class="card-body table-responsive">
      <table id="studentsTable" class="table table-striped table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Student ID</th>
            <th>Username</th>
            <th>Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while($s = $students->fetch_assoc()): ?>
          <tr>
            <td><?= (int)$s['id']; ?></td>
            <td><?= htmlspecialchars($s['student_id']); ?></td>
            <td><?= htmlspecialchars($s['username']); ?></td>
            <td><?= htmlspecialchars($s['first_name'].' '.$s['last_name']); ?></td>
            <td>
              <form method="post" style="display:inline">
                <input type="hidden" name="id" value="<?= (int)$s['id']; ?>">
                <button class="btn btn-sm btn-outline-danger" name="delete_student" type="submit" onclick="return confirm('Delete this student?')">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function(){
  $('#studentsTable').DataTable({
    pageLength: 10,
    order: [[0, 'desc']]
  });
});
</script>
