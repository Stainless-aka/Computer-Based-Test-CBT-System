<?php
session_start();
if(empty($_SESSION['student'])){ header('Location: ../student_login.php'); exit; }
include '../config/db.php';
$student = $_SESSION['student'];
$subs = $conn->query('SELECT s.id, s.subject_name, e.duration_minutes FROM subjects s LEFT JOIN exams e ON e.subject_id=s.id ORDER BY s.subject_name');
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Student Dashboard</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
  background: #f8f9fa;
  min-height: 100vh;
  font-family: "Poppins", sans-serif;
}
.topbar {
  background-color: #003366;
  color: #fff;
  padding: 1rem 0;
}
.topbar h1 {
  margin: 0;
  font-size: 1.5rem;
  text-align: center;
}
.dashboard-card {
  background: #fff;
  border-radius: 1rem;
  box-shadow: 0 8px 20px rgba(0,0,0,0.05);
  padding: 2rem;
  margin-top: 2rem;
}
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.5rem;
  margin-top: 1rem;
}
.sub-card {
  border-radius: 0.75rem;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  padding: 1.5rem;
  background: #fff;
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.sub-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}
.sub-card h3 {
  margin-bottom: 0.5rem;
}
.btn-start {
  background-color: #003366;
  color: #fff;
  border-radius: 0.5rem;
  transition: background 0.3s ease;
}
.btn-start:hover {
  background-color: #0055aa;
}
.logout-btn {
  background-color: #dc3545;
  color: #fff;
  border-radius: 0.5rem;
  transition: background 0.3s ease;
}
.logout-btn:hover {
  background-color: #b02a37;
}
</style>
</head>
<body>

<header class="topbar">
  <div class="container">
    <h1>Student Portal</h1>
  </div>
</header>

<main class="container">
  <div class="dashboard-card">
    <h2 class="mb-2">Welcome, <?= htmlspecialchars($student['first_name'].' '.$student['last_name']); ?></h2>
    <p>Select a subject to start the exam:</p>

    <div class="grid">
      <?php while($r=$subs->fetch_assoc()): ?>
        <div class="sub-card">
          <h3><?= htmlspecialchars($r['subject_name']); ?></h3>
          <p><i class="bi bi-clock"></i> Duration: <?= (int)$r['duration_minutes']; ?> minutes</p>
          <form method="post" action="start_exam.php">
            <input type="hidden" name="subject_id" value="<?= (int)$r['id']; ?>">
            <button class="btn btn-start mt-2" type="submit">Start Exam</button>
          </form>
        </div>
      <?php endwhile; ?>
    </div>

    <div class="text-center mt-4">
      <a href="../student_logout.php" class="btn logout-btn">Logout</a>
    </div>
  </div>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
