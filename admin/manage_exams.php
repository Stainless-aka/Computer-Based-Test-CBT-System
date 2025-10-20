<?php
// manage_exams.php - included in admin/index.php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_duration'])) {
  $sid = (int)$_POST['subject_id'];
  $dur = (int)$_POST['duration'];

  // Ensure valid duration
  if ($dur > 0) {
    $stmt = $conn->prepare('UPDATE exams SET duration_minutes=? WHERE subject_id=?');
    $stmt->bind_param('ii', $dur, $sid);
    $stmt->execute();

    echo '<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            ✅ Duration for subject updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  } else {
    echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            ❌ Please enter a valid duration greater than zero.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  }
}

$res = $conn->query('SELECT s.id, s.subject_name, e.duration_minutes 
                     FROM subjects s 
                     LEFT JOIN exams e ON e.subject_id = s.id 
                     ORDER BY s.subject_name');
?>

<div class="container mt-5">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white text-center py-3">
      <h3 class="mb-0"><i class="bi bi-hourglass-split"></i> Manage Exams (Set Duration)</h3>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
          <thead class="table-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Subject</th>
              <th scope="col">Duration (Minutes)</th>
              <th scope="col" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $counter = 1;
            while($r = $res->fetch_assoc()): ?>
              <tr>
                <td><?php echo $counter++; ?></td>
                <td class="fw-semibold"><?php echo htmlspecialchars($r['subject_name']); ?></td>
                <td style="max-width: 180px;">
                  <form method="post" class="d-flex align-items-center justify-content-between">
                    <input type="number" name="duration" 
                           class="form-control me-2" 
                           min="1" max="300" 
                           value="<?php echo (int)$r['duration_minutes']; ?>" required>
                    <input type="hidden" name="subject_id" value="<?php echo (int)$r['id']; ?>">
                    <button type="submit" name="update_duration" class="btn btn-success btn-sm">
                      <i class="bi bi-save2"></i> Save
                    </button>
                  </form>
                </td>
                <td></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
