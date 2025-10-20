<?php
session_start();
include 'config/db.php';
$err = '';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $sid = trim($_POST['student_id']);
    $pw = trim($_POST['password']);
    $stmt = $conn->prepare('SELECT id, student_id, first_name, last_name FROM students WHERE student_id=? AND password=? LIMIT 1');
    $stmt->bind_param('ss', $sid, $pw);
    $stmt->execute();
    $res = $stmt->get_result();
    if($res && $res->num_rows){
        $_SESSION['student'] = $res->fetch_assoc();
        header('Location: student/dashboard.php'); exit;
    } else { 
        $err = 'Invalid student credentials.'; 
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Student Login - CBT Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #e9f0f7, #f7fbff);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: "Poppins", sans-serif;
    }

    .login-card {
      background: #fff;
      border-radius: 1rem;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
      padding: 2.5rem;
      width: 100%;
      max-width: 420px;
      animation: fadeIn 0.8s ease;
    }

    .login-card h2 {
      text-align: center;
      color: #003366;
      font-weight: 600;
      margin-bottom: 1.5rem;
    }

    .form-control {
      border-radius: 0.5rem;
      padding: 0.75rem 1rem;
      border: 1px solid #ccc;
      transition: border-color 0.3s ease;
    }

    .form-control:focus {
      border-color: #0055aa;
      box-shadow: 0 0 5px rgba(0, 85, 170, 0.2);
    }

    .btn-primary {
      background-color: #003366;
      border-color: #003366;
      border-radius: 0.5rem;
      padding: 0.75rem;
      width: 100%;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #0055aa;
    }

    .error-msg {
      color: #dc3545;
      text-align: center;
      font-weight: 500;
      margin-bottom: 1rem;
    }

    a.back-link {
      display: block;
      text-align: center;
      margin-top: 1rem;
      text-decoration: none;
      color: #003366;
      font-weight: 500;
    }

    a.back-link:hover {
      color: #0055aa;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>
  <div class="login-card">
    <h2>Student Login</h2>
    <?php if($err): ?>
      <div class="alert alert-danger text-center py-2" role="alert">
        <?= htmlspecialchars($err); ?>
      </div>
    <?php endif; ?>

    <form method="post" novalidate>
      <div class="mb-3">
        <label for="student_id" class="form-label">Student ID</label>
        <input type="text" class="form-control" id="student_id" name="student_id" placeholder="e.g., STU001" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
      </div>

      <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <a href="index.php" class="back-link">← Back to Home</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
