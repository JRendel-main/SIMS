<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$grade_id = $_POST['grade_id'];
$highest_grade = $_POST['highest_grade'];
$initial_grade = $_POST['initial_grade'];

$grade = new Grades($conn);
if ($highest_grade == 0) {
    $updateInitial = $grade->updateInitialGrade($grade_id, $initial_grade);
    if ($updateInitial) {
        echo json_encode(['status' => 'success', 'message' => 'Grade updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update grade']);
    }
} else {
    $updateHighest = $grade->updateHighestGrade($grade_id, $highest_grade);
    if ($updateHighest) {
        echo json_encode(['status' => 'success', 'message' => 'Grade updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update grade']);
    }
}