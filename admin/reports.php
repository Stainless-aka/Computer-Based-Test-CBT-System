<?php
// reports.php - View student results (no export)
$res = $conn->query('SELECT r.id, s.student_id, CONCAT(s.first_name," ",s.last_name) AS name, sub.subject_name, r.score, r.total, r.created_at 
FROM results r 
JOIN students s ON s.id = r.student_id 
JOIN subjects sub ON sub.id = r.subject_id 
ORDER BY r.created_at DESC');
?>

<div class="container mt-3">
  <h3 class="text-primary mb-4"><i class="bi bi-bar-chart"></i> Student Results</h3>

  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
      <thead class="table-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Student</th>
          <th scope="col">Subject</th>
          <th scope="col">Score</th>
          <th scope="col">Total</th>
          <th scope="col">Percentage</th>
          <th scope="col">Remarks</th>
          <th scope="col">Date</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $count = 1;
        while($r = $res->fetch_assoc()): 
          $percentage = round(($r['score'] / max(1, $r['total'])) * 100, 2);
          $remarks = ($percentage >= 50) ? '<span class="badge bg-success">Passed</span>' : '<span class="badge bg-danger">Failed</span>';
        ?>
        <tr>
          <td><?= $count++; ?></td>
          <td><?= htmlspecialchars($r['student_id'].' - '.$r['name']); ?></td>
          <td><?= htmlspecialchars($r['subject_name']); ?></td>
          <td><?= (int)$r['score']; ?></td>
          <td><?= (int)$r['total']; ?></td>
          <td><?= $percentage; ?>%</td>
          <td><?= $remarks; ?></td>
          <td><?= date('d M Y, h:i A', strtotime($r['created_at'])); ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
