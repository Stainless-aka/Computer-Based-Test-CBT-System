<?php
// Homepage - choose admin or student login
include 'config/db.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>CBT Portal - GOVERNMENT DAY SENIOR SECONDARY SCHOOL GASHUA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f8;
      font-family: "Poppins", sans-serif;
    }
    .topbar {
      background-color: #003366;
      color: #fff;
      padding: 1rem 0;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .topbar h1 {
      font-size: 1.6rem;
      margin: 0;
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    .card.center {
      max-width: 450px;
      margin: 5rem auto;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
      background: #ffffff;
    }
    h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #003366;
      font-weight: 600;
    }
    .choices {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 1rem;
    }
    .choice {
      flex: 1 1 45%;
      text-align: center;
      background-color: #003366;
      color: #fff;
      text-decoration: none;
      padding: 0.75rem 1rem;
      border-radius: 0.5rem;
      transition: all 0.3s ease;
      font-weight: 500;
    }
    .choice:hover {
      background-color: #0055aa;
      transform: translateY(-2px);
    }
    footer {
      text-align: center;
      padding: 1rem;
      color: #666;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <header class="topbar">
    <div class="container">
      <h1>GOVERNMENT DAY SENIOR SECONDARY SCHOOL GASHUA</h1>
    </div>
  </header>

  <main class="container">
    <div class="card center">
      <h2>Choose Portal</h2>
      <div class="choices">
        <a class="choice" href="admin_login.php">Admin Portal</a>
        <a class="choice" href="student_login.php">Student Portal</a>
      </div>
    </div>
  </main>

  <footer>
    &copy; <?php echo date("Y"); ?> GOVERNMENT DAY SENIOR SECONDARY SCHOOL GASHUA
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
