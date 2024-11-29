<?php

include '../../controllers/autoloader.php';
$db = new Database();
$conn = $db->connect();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $semester_id = $_POST['semester_id'];
    $component_id = $_POST['component_id'];
    $highest_grade = $_POST['highest_grade'];
    $initial_grade = $_POST['initial_grade'];
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $academic_year = $_POST['academic_year'];

    $grade = new Grades($conn);
    $grade->addGrade($semester_id, $component_id, $highest_grade, $initial_grade, $student_id, $subject_id, $academic_year);

    if ($grade) {
        echo json_encode(['status' => 'success', 'message' => 'Grade added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add grade']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}