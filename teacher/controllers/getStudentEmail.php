<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$teacher_id = $_POST['teacher_id'];

$student = new Student($conn);
$studentEmail = $student->getStudentEmail($teacher_id);

echo json_encode($studentEmail);