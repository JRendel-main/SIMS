<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$grade_id = $_POST['grade_id'];

$grade = new Grades($conn);
$deleteGrade = $grade->deleteGrade($grade_id);

if ($deleteGrade) {
    echo json_encode(['status' => 'success', 'message' => 'Grade deleted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete grade']);
}

?>