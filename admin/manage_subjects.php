<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
  if(isset($_POST['add_subject'])){
    $name = $conn->real_escape_string($_POST['subject_name']);
    if($name){ 
      $conn->query("INSERT INTO subjects (subject_name) VALUES ('".$name."')");
      $sid = $conn->insert_id; 
      $conn->query("INSERT INTO exams (subject_id, duration_minutes, active) VALUES (".$sid.",30,1)");
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              ✅ Subject added successfully.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
  }

  if(isset($_POST['delete_subject'])){
    $sid = (int)$_POST['subject_id'];
    $conn->query('DELETE FROM subjects WHERE id='.$sid);
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            ⚠️ Subject deleted successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  }
}

$subs = $conn->query('SELECT * FROM subjects ORDER BY subject_name');
?>

<div class="container mt-5">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white text-center py-3">
      <h3 class="mb-0"><i class="bi bi-journal-text"></i> Manage Subjects</h3>
    </div>
    <div class="card-body">
      <!-- Add Subject Form -->
      <form method="post" class="row g-3 align-items-center mb-4">
        <div class="col-md-8">
          <input type="text" class="form-control form-control-lg" name="subject_name" placeholder="Enter new subject name" required>
        </div>
        <div class="col-md-4 text-end">
          <button class="btn btn-success btn-lg w-100" type="submit" name="add_subject">
            <i class="bi bi-plus-circle"></i> Add Subject
          </button>
        </div>
      </form>

      <hr class="my-4">

      <!-- Subject Table -->
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
          <thead class="table-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Subject Name</th>
              <th scope="col" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while($s = $subs->fetch_assoc()): ?>
              <tr>
                <td><?php echo (int)$s['id']; ?></td>
                <td><?php echo htmlspecialchars($s['subject_name']); ?></td>
                <td class="text-center">
                  <form method="post" class="d-inline">
                    <input type="hidden" name="subject_id" value="<?php echo (int)$s['id']; ?>">
                    <button class="btn btn-outline-danger btn-sm" name="delete_subject" type="submit" onclick="return confirm('Are you sure you want to delete this subject and its related questions?')">
                      <i class="bi bi-trash3"></i> Delete
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
</div>
