<?php
session_start();
if(empty($_SESSION['student'])){ header('Location: ../student_login.php'); exit; }
include '../config/db.php';
if($_SERVER['REQUEST_METHOD']!='POST' || !isset($_POST['subject_id'])){ header('Location: dashboard.php'); exit; }
$student = $_SESSION['student'];
$subject_id = (int)$_POST['subject_id'];
// get duration
$stmt = $conn->prepare('SELECT duration_minutes FROM exams WHERE subject_id=? LIMIT 1');
$stmt->bind_param('i',$subject_id); $stmt->execute(); $res = $stmt->get_result()->fetch_assoc();
$duration = $res ? (int)$res['duration_minutes'] : 30;
$limit = 15; // number of questions per attempt
$stmt = $conn->prepare('SELECT id, question, option_a, option_b, option_c, option_d FROM questions WHERE subject_id=? ORDER BY RAND() LIMIT ?');
$stmt->bind_param('ii',$subject_id,$limit); $stmt->execute();
$qres = $stmt->get_result();
$questions = [];
while($r=$qres->fetch_assoc()) $questions[] = $r;
if(empty($questions)){ echo 'No questions for this subject. Contact admin.'; exit; }
// store exam in session: questions ids, start time, duration
$_SESSION['exam'] = ['subject_id'=>$subject_id,'questions'=>array_map(function($q){return (int)$q['id'];}, $questions),'start'=>time(),'duration'=>$duration];
header('Location: exam.php');
exit;
?>