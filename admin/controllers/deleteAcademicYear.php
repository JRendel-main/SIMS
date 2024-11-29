<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$academic = new Academic($conn);

$schoolYear = $_POST['id'];

$academic->deleteAcademicYear($schoolYear);

if ($academic) {
    echo json_encode(['status' => 'success', 'message' => 'School Year added successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add School Year']);
}