<?php
include '../config/db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if(!$id){ echo 'Invalid ID'; exit; }

$stmt = $conn->prepare('SELECT r.*, s.first_name, s.last_name, s.student_id AS studcode, sub.subject_name 
                        FROM results r 
                        JOIN students s ON s.id=r.student_id 
                        JOIN subjects sub ON sub.id=r.subject_id 
                        WHERE r.id=? LIMIT 1');
$stmt->bind_param('i',$id); 
$stmt->execute(); 
$data = $stmt->get_result()->fetch_assoc();

if(!$data){ echo 'Result not found'; exit; }

$student_name = htmlspecialchars($data['first_name'].' '.$data['last_name']);
$student_code = htmlspecialchars($data['studcode']);
$subject = htmlspecialchars($data['subject_name']);
$score = (int)$data['score']; 
$total = (int)$data['total'];
$percentage = round(($score / max(1,$total)) * 100,2);
$passed = $percentage >= 50;
$remarks = $passed ? 'Passed' : 'Failed';
$date = date('d M Y H:i', strtotime($data['created_at']));
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Result Slip - Student Portal</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
  background: #f8f9fa;
  font-family: "Poppins", sans-serif;
}
.print-wrap {
  background: #fff;
  border-radius: 1rem;
  padding: 2rem;
  margin: 2rem auto;
  box-shadow: 0 8px 20px rgba(0,0,0,0.05);
  max-width: 700px;
}
.header {
  text-align: center;
  margin-bottom: 1.5rem;
}
.header img {
  width: 80px;
  height: 80px;
  margin-bottom: 0.5rem;
}
.header h2 {
  font-weight: 700;
  color: #003366;
  margin-bottom: 0.25rem;
}
.header p {
  font-weight: 500;
  color: #555;
}
.meta {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  margin-bottom: 1.5rem;
  font-size: 0.95rem;
}
.score-box {
  text-align: center;
  padding: 1.5rem;
  border-radius: 0.75rem;
  background: #e9f0f7;
  margin-bottom: 2rem;
}
.score-box h1 {
  font-size: 3rem;
  margin-bottom: 0.5rem;
  color: #003366;
}
.score-box p {
  margin: 0.25rem 0;
  font-weight: 500;
}
.badge-pass {
  background-color: #198754;
  font-size: 1rem;
}
.badge-fail {
  background-color: #dc3545;
  font-size: 1rem;
}
.footer-sign {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  margin-top: 2rem;
  text-align: center;
}
.footer-sign div {
  width: 45%;
  min-width: 150px;
}
.footer-sign span {
  display: block;
  margin-top: 0.5rem;
  font-weight: 500;
}
.btn-print, .btn-back {
  border-radius: 0.5rem;
  padding: 0.5rem 1.25rem;
  font-weight: 500;
}
.btn-print {
  background-color: #003366;
  color: #fff;
  margin-right: 0.5rem;
}
.btn-print:hover { background-color: #0055aa; }
.btn-back {
  background-color: #6c757d;
  color: #fff;
}
.btn-back:hover { background-color: #495057; }
.no-print { display: inline-block; }
@media print {
  .no-print { display: none; }
  body { background: #fff; }
  .print-wrap { box-shadow: none; margin: 0; }
}
</style>
</head>
<body>

<main class="container">
  <div class="print-wrap">
    <div class="header">     
      <h2>GOVERNMENT DAY SENIOR SECONDARY SCHOOL GASHUA</h2>
      <p>Computer Based Test - Result Slip</p>
    </div>

    <div class="meta">
      <div><strong>Student:</strong> <?= $student_name ?> (<?= $student_code ?>)</div>
      <div><strong>Date:</strong> <?= $date ?></div>
    </div>

    <div class="score-box">
      <h1><?= $score ?> / <?= $total ?></h1>
      <p><strong>Subject:</strong> <?= $subject ?></p>
      <p><strong>Percentage:</strong> <?= $percentage ?>%</p>
      <span class="badge <?= $passed ? 'badge-pass' : 'badge-fail' ?>"><?= $remarks ?></span>
    </div>

    <div class="footer-sign">
      <div>
        ___________________________<br>
        <span>Exam Coordinator</span>
      </div>
      <div>
        ___________________________<br>
        <span>Principal</span>
      </div>
    </div>

    <div class="mt-4 text-center no-print">
      <button class="btn btn-print" onclick="window.print()">🖨 Print Result Slip</button>
      <a class="btn btn-back" href="../student/dashboard.php">← Back to Dashboard</a>
    </div>
  </div>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
