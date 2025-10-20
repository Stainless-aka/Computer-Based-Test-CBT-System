<?php
session_start();
include '../config/db.php';
if(empty($_SESSION['student'])){ header('Location: ../student_login.php'); exit; }
if(empty($_SESSION['exam'])){ header('Location: dashboard.php'); exit; }
$student = $_SESSION['student'];
$exam = $_SESSION['exam'];
$subject_id = (int)$exam['subject_id'];

// collect answers
$answers = [];
foreach($_POST as $k=>$v){
  if(strpos($k,'ans_')===0){
    $qid = (int)substr($k,4);
    $answers[$qid] = strtoupper($v);
  }
}
if(count($answers)==0){ header('Location: dashboard.php'); exit; }
// fetch correct answers
$ids = implode(',', array_map('intval', array_keys($answers)));
$res = $conn->query('SELECT id, correct FROM questions WHERE id IN ('.$ids.')');
$map = [];
while($r=$res->fetch_assoc()) $map[$r['id']] = strtoupper(trim($r['correct']));
$score = 0;
foreach($answers as $qid=>$ans){
  if(isset($map[$qid]) && $map[$qid] == $ans) $score++;
}
$total = count($answers);
$stmt = $conn->prepare('INSERT INTO results (student_id, subject_id, score, total) VALUES (?, ?, ?, ?)');
$stmt->bind_param('iiii', $student['id'], $subject_id, $score, $total);
$stmt->execute();
$rid = $stmt->insert_id;
unset($_SESSION['exam']);
header('Location: result.php?id='.$rid);
exit;
?>