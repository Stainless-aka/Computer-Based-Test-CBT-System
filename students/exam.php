<?php
session_start();
if(empty($_SESSION['student'])){ header('Location: ../student_login.php'); exit; }
if(empty($_SESSION['exam'])){ header('Location: dashboard.php'); exit; }
include '../config/db.php';
$student = $_SESSION['student'];
$exam = $_SESSION['exam'];
$subject_id = (int)$exam['subject_id'];
$questions_ids = $exam['questions'];
$duration = (int)$exam['duration'];

// fetch questions details
$ids = implode(',', $questions_ids);
$res = $conn->query('SELECT id, question, option_a, option_b, option_c, option_d FROM questions WHERE id IN ('.$ids.')');
$qs = [];
while($r=$res->fetch_assoc()) $qs[$r['id']] = $r;
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Exam - Student Portal</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
  background: #f8f9fa;
  font-family: "Poppins", sans-serif;
  min-height: 100vh;
}
.topbar {
  background-color: #003366;
  color: #fff;
  padding: 1rem 0;
}
.topbar h1 {
  margin: 0;
  text-align: center;
}
.exam-card {
  background: #fff;
  border-radius: 1rem;
  box-shadow: 0 8px 20px rgba(0,0,0,0.05);
  padding: 2rem;
  margin-top: 2rem;
}
.qcard {
  border: 1px solid #dee2e6;
  border-radius: 0.75rem;
  padding: 1rem;
  margin-bottom: 1rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.qcard:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}
.timer {
  font-weight: 600;
  font-size: 1.1rem;
  color: #dc3545;
}
.btn-submit {
  background-color: #003366;
  color: #fff;
  border-radius: 0.5rem;
  padding: 0.75rem 1.5rem;
  transition: background 0.3s ease;
}
.btn-submit:hover {
  background-color: #0055aa;
}
</style>
</head>
<body>

<header class="topbar">
  <div class="container">
    <h1>Exam - <?= htmlspecialchars($exam['subject_name'] ?? ''); ?></h1>
  </div>
</header>

<main class="container">
  <div class="exam-card">
    <div class="d-flex justify-content-between mb-3">
      <div><strong>Student:</strong> <?= htmlspecialchars($student['first_name'].' '.$student['last_name']); ?></div>
      <div>Time left: <span id="timer" class="timer"></span></div>
    </div>

    <form id="examForm" method="post" action="submit_exam.php">
      <input type="hidden" name="subject_id" value="<?= $subject_id ?>">

      <?php
      $i = 0;
      foreach($questions_ids as $qid){
        $i++;
        $q = $qs[$qid];
      ?>
        <div class="qcard">
          <p><strong>Q<?= $i ?>.</strong> <?= htmlspecialchars($q['question']); ?></p>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="ans_<?= (int)$q['id'] ?>" value="A" id="q<?= $q['id'] ?>a" required>
            <label class="form-check-label" for="q<?= $q['id'] ?>a">A. <?= htmlspecialchars($q['option_a']) ?></label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="ans_<?= (int)$q['id'] ?>" value="B" id="q<?= $q['id'] ?>b">
            <label class="form-check-label" for="q<?= $q['id'] ?>b">B. <?= htmlspecialchars($q['option_b']) ?></label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="ans_<?= (int)$q['id'] ?>" value="C" id="q<?= $q['id'] ?>c">
            <label class="form-check-label" for="q<?= $q['id'] ?>c">C. <?= htmlspecialchars($q['option_c']) ?></label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="ans_<?= (int)$q['id'] ?>" value="D" id="q<?= $q['id'] ?>d">
            <label class="form-check-label" for="q<?= $q['id'] ?>d">D. <?= htmlspecialchars($q['option_d']) ?></label>
          </div>
        </div>
      <?php } ?>

      <button type="submit" class="btn btn-submit mt-3">Submit Exam</button>
    </form>
  </div>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Countdown timer
(function(){
  var duration = <?= $duration*60 ?>;
  var display = document.getElementById('timer');
  var t = setInterval(function(){
    var m = Math.floor(duration/60), s = duration%60;
    display.textContent = m + ':' + (s<10?'0':'') + s;
    if(--duration < 0){
      clearInterval(t);
      document.getElementById('examForm').submit();
    }
  }, 1000);
})();

// Warn student if they try to close or refresh the page
window.onbeforeunload = function(e) {
  return "Leaving the page will mark you as FAILED. Are you sure you want to leave?";
};
</script>

</body>
</html>
