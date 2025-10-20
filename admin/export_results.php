<?php
session_start();
if (empty($_SESSION['admin'])) {
    header('Location: ../admin_login.php');
    exit;
}
include '../config/db.php';

// Set CSV headers
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=student_results_' . date('Y-m-d') . '.csv');

// Open output stream
$output = fopen('php://output', 'w');

// Write CSV column headers
fputcsv($output, ['Student ID', 'Full Name', 'Subject', 'Score', 'Total Questions', 'Percentage', 'Date Taken']);

// Fetch data from the database
$query = "
    SELECT 
        st.id AS student_id,
        CONCAT(st.first_name, ' ', st.last_name) AS full_name,
        sb.subject_name,
        r.score,
        r.total_questions,
        ROUND((r.score / r.total_questions) * 100, 2) AS percentage,
        r.date_taken
    FROM results r
    JOIN students st ON r.student_id = st.id
    JOIN subjects sb ON r.subject_id = sb.id
    ORDER BY r.date_taken DESC
";
$result = $conn->query($query);

// Write rows
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['student_id'],
            $row['full_name'],
            $row['subject_name'],
            $row['score'],
            $row['total_questions'],
            $row['percentage'] . '%',
            $row['date_taken']
        ]);
    }
} else {
    fputcsv($output, ['No records found']);
}

fclose($output);
exit;
?>
