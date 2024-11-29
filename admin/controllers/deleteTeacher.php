<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$teacher = new Teacher($conn);

$id = $_POST['id'];

$response = $teacher->deleteTeacher($id);

if ($response) {
    echo json_encode([
        'success' => true,
        'message' => 'Teacher deleted successfully'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to delete teacher'
    ]);
}