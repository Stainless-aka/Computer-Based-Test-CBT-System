<?php
session_start();
if (empty($_SESSION['admin'])) { 
  header('Location: ../admin_login.php'); 
  exit; 
}
include '../config/db.php';
$admin = $_SESSION['admin'];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard - GDSS Gashua</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: "Poppins", sans-serif;
    }
    .navbar-brand {
      font-weight: 700;
      color: #003366 !important;
    }
    .card {
      border-radius: 1rem;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      border: none;
    }
    .nav-tabs .nav-link.active {
      background-color: #003366;
      color: #fff !important;
      border: none;
    }
    .nav-tabs .nav-link {
      color: #003366;
      font-weight: 500;
    }
    .nav-tabs .nav-link:hover {
      background-color: #0055aa;
      color: #fff;
    }
    .tab-content {
      background: #fff;
      padding: 2rem;
      border-radius: 0 0 1rem 1rem;
    }
    .logout-btn {
      background-color: #dc3545;
      color: #fff;
      border: none;
    }
    .logout-btn:hover {
      background-color: #b02a37;
    }
    footer {
      text-align: center;
      padding: 1rem;
      color: #6c757d;
      margin-top: 2rem;
    }
  </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
  <div class="container">
    <a class="navbar-brand" href="#">
      <i class="bi bi-mortarboard"></i> Admin Dashboard - GDSS Gashua
    </a>
    <div class="d-flex">
      <span class="me-3 fw-semibold text-secondary">
        <i class="bi bi-person-circle"></i> 
        <?= htmlspecialchars($admin['username'] ?? 'Administrator') ?>
      </span>
      <a href="../admin_logout.php" class="btn logout-btn">
        <i class="bi bi-box-arrow-right"></i> Logout
      </a>
    </div>
  </div>
</nav>

<!-- Main -->
<main class="container my-4">
  <div class="card">
    <ul class="nav nav-tabs nav-fill p-2" id="dashboardTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="exams-tab" data-bs-toggle="tab" data-bs-target="#exams" type="button" role="tab">
          <i class="bi bi-journal-text"></i> Exams
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="subjects-tab" data-bs-toggle="tab" data-bs-target="#subjects" type="button" role="tab">
          <i class="bi bi-book"></i> Subjects
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="questions-tab" data-bs-toggle="tab" data-bs-target="#questions" type="button" role="tab">
          <i class="bi bi-question-circle"></i> Questions
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="students-tab" data-bs-toggle="tab" data-bs-target="#students" type="button" role="tab">
          <i class="bi bi-people"></i> Students
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="reports-tab" data-bs-toggle="tab" data-bs-target="#reports" type="button" role="tab">
          <i class="bi bi-bar-chart"></i> Reports
        </button>
      </li>
    </ul>

    <div class="tab-content" id="dashboardTabsContent">
      <div class="tab-pane fade show active" id="exams" role="tabpanel" aria-labelledby="exams-tab">
        <?php include 'manage_exams.php'; ?>
      </div>
      <div class="tab-pane fade" id="subjects" role="tabpanel" aria-labelledby="subjects-tab">
        <?php include 'manage_subjects.php'; ?>
      </div>
      <div class="tab-pane fade" id="questions" role="tabpanel" aria-labelledby="questions-tab">
        <?php include 'manage_questions.php'; ?>
      </div>
      <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="students-tab">
        <?php include 'manage_students.php'; ?>
      </div>
      <div class="tab-pane fade" id="reports" role="tabpanel" aria-labelledby="reports-tab">
        <?php include 'reports.php'; ?>
      </div>
    </div>
  </div>
</main>

<footer>
  <small>© <?= date('Y'); ?> Government Day Senior Secondary School Gashua | Admin Panel</small>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
