<?php
// manage_questions.php (Advanced Bootstrap)
if($_SERVER['REQUEST_METHOD']=='POST'){
  if(isset($_POST['add_question'])){
    $sid = (int)$_POST['subject_id'];
    $q = $conn->real_escape_string($_POST['question']);
    $a = $conn->real_escape_string($_POST['option_a']);
    $b = $conn->real_escape_string($_POST['option_b']);
    $c = $conn->real_escape_string($_POST['option_c']);
    $d = $conn->real_escape_string($_POST['option_d']);
    $corr = strtoupper(substr($_POST['correct'],0,1));
    $stmt = $conn->prepare('INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (?,?,?,?,?,?,?)');
    $stmt->bind_param('issssss',$sid,$q,$a,$b,$c,$d,$corr);
    $stmt->execute();
    echo '<div class="alert alert-success mt-3">✅ Question added successfully.</div>';
  }

  if(isset($_POST['delete_q'])){
    $qid = (int)$_POST['qid'];
    $conn->query('DELETE FROM questions WHERE id='.$qid);
    echo '<div class="alert alert-danger mt-3">🗑️ Question deleted.</div>';
  }

  if(isset($_POST['edit_q'])){
    $qid = (int)$_POST['qid'];
    $q = $conn->real_escape_string($_POST['question']);
    $a = $conn->real_escape_string($_POST['option_a']);
    $b = $conn->real_escape_string($_POST['option_b']);
    $c = $conn->real_escape_string($_POST['option_c']);
    $d = $conn->real_escape_string($_POST['option_d']);
    $corr = strtoupper(substr($_POST['correct'],0,1));
    $stmt = $conn->prepare('UPDATE questions SET question=?, option_a=?, option_b=?, option_c=?, option_d=?, correct=? WHERE id=?');
    $stmt->bind_param('ssssssi',$q,$a,$b,$c,$d,$corr,$qid);
    $stmt->execute();
    echo '<div class="alert alert-info mt-3">✏️ Question updated.</div>';
  }
}

$subjects = $conn->query('SELECT * FROM subjects ORDER BY subject_name');
$filter_sub = isset($_GET['sub']) ? (int)$_GET['sub'] : 0;
$qs_sql = $filter_sub ? 'WHERE subject_id='.$filter_sub : '';
$questions = $conn->query('SELECT q.*, s.subject_name FROM questions q JOIN subjects s ON s.id=q.subject_id '.$qs_sql.' ORDER BY q.id DESC LIMIT 500');
?>

<!-- Include Bootstrap 5 + Icons + DataTables -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<div class="container mt-4">
  <h2 class="text-primary mb-4"><i class="bi bi-question-circle"></i> Manage Questions</h2>

  <!-- Filter Section -->
  <form method="get" class="row g-2 mb-4">
    <div class="col-md-6">
      <select name="sub" class="form-select">
        <option value="0">-- All Subjects --</option>
        <?php while($s=$subjects->fetch_assoc()): ?>
          <option value="<?= (int)$s['id']; ?>" <?= $filter_sub==(int)$s['id'] ? 'selected' : ''; ?>>
            <?= htmlspecialchars($s['subject_name']); ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary w-100" type="submit"><i class="bi bi-funnel"></i> Filter</button>
    </div>
  </form>

  <!-- Add Question Form -->
  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white">
      <i class="bi bi-plus-circle"></i> Add New Question
    </div>
    <div class="card-body">
      <form method="post" class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Subject</label>
          <select name="subject_id" class="form-select" required>
            <?php 
            $subs2 = $conn->query('SELECT * FROM subjects ORDER BY subject_name'); 
            while($ss=$subs2->fetch_assoc()): ?>
              <option value="<?= (int)$ss['id']; ?>"><?= htmlspecialchars($ss['subject_name']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="col-12">
          <label class="form-label">Question Text</label>
          <textarea class="form-control" name="question" rows="3" required></textarea>
        </div>

        <div class="col-md-6"><input class="form-control" name="option_a" placeholder="Option A" required></div>
        <div class="col-md-6"><input class="form-control" name="option_b" placeholder="Option B" required></div>
        <div class="col-md-6"><input class="form-control" name="option_c" placeholder="Option C" required></div>
        <div class="col-md-6"><input class="form-control" name="option_d" placeholder="Option D" required></div>
        <div class="col-md-4">
          <input class="form-control" name="correct" placeholder="Correct (A/B/C/D)" required>
        </div>
        <div class="col-md-4">
          <button class="btn btn-success w-100" name="add_question" type="submit">
            <i class="bi bi-plus-lg"></i> Add Question
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Existing Questions -->
  <div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
      <i class="bi bi-list-task"></i> Existing Questions
    </div>
    <div class="card-body table-responsive">
      <table id="questionsTable" class="table table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Subject</th>
            <th>Question</th>
            <th>Correct</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while($q=$questions->fetch_assoc()): ?>
          <tr>
            <td><?= (int)$q['id']; ?></td>
            <td><?= htmlspecialchars($q['subject_name']); ?></td>
            <td><?= htmlspecialchars(substr($q['question'],0,120)); ?></td>
            <td><span class="badge bg-info text-dark"><?= htmlspecialchars($q['correct']); ?></span></td>
            <td>
              <a class="btn btn-sm btn-outline-primary" href="edit_question.php?qid=<?= (int)$q['id']; ?>">
                <i class="bi bi-pencil"></i>
              </a>
              <form method="post" style="display:inline">
                <input type="hidden" name="qid" value="<?= (int)$q['id']; ?>">
                <button class="btn btn-sm btn-outline-danger" name="delete_q" type="submit" onclick="return confirm('Delete this question?')">
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
  $('#questionsTable').DataTable({
    pageLength: 10,
    order: [[0, 'desc']]
  });
});
</script>
