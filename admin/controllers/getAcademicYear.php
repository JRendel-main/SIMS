<?php
include '../../controllers/autoloader.php';
$db = new Database();
$conn = $db->connect();

$schoolYear = new Academic($conn);
$data = $schoolYear->getAllAcademicYear();

echo json_encode($data);