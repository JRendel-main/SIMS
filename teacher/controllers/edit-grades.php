<?php

include '../../controllers/autoloader.php';
$db = new Database();
$conn = $db->connect();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $grade_id = isset($_POST['grades_id']) ? $_POST['grades_id'] : null;
    $final_grade = $_POST['final_grade'];
    $student_id = $_POST['student_id'];
    $semester = $_POST['semester'];
    $subject_id = $_POST['subject_id'];


    $grade = new Grades($conn);

    if($grade_id != "") {

        $grade->editGrade($grade_id, $final_grade);

    } else {

        echo 'add';

        $grade->addGrade($final_grade, $student_id, $semester, $subject_id);

    }

    if ($grade) {
        echo json_encode(['status' => 'success', 'message' => 'Grade added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add grade']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}