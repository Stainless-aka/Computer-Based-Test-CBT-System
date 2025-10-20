<?php
session_start();
if(empty($_SESSION['admin'])){ header('Location: ../admin_login.php'); exit; }
include '../config/db.php';
$qid = isset($_GET['qid']) ? (int)$_GET['qid'] : 0;
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['save_edit'])){
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
  header('Location: index.php?tab=questions');
}
$r = $conn->query('SELECT * FROM questions WHERE id='.$qid);
if(!$r || $r->num_rows==0){ echo 'Question not found'; exit; }
$Q = $r->fetch_assoc();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Edit Question</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body><main class="container"><div class="card"><h2>Edit Question</h2>
<form method="post">
  <input type="hidden" name="qid" value="<?php echo (int)$Q['id']; ?>">
  <textarea class="input" name="question" required><?php echo htmlspecialchars($Q['question']); ?></textarea>
  <input class="input" name="option_a" value="<?php echo htmlspecialchars($Q['option_a']); ?>" required>
  <input class="input" name="option_b" value="<?php echo htmlspecialchars($Q['option_b']); ?>" required>
  <input class="input" name="option_c" value="<?php echo htmlspecialchars($Q['option_c']); ?>" required>
  <input class="input" name="option_d" value="<?php echo htmlspecialchars($Q['option_d']); ?>" required>
  <input class="input" name="correct" value="<?php echo htmlspecialchars($Q['correct']); ?>" required>
  <button class="btn" name="save_edit" type="submit">Save</button>
  <a class="btn" href="index.php">Back</a>
</form>
</div></main></body></html>
