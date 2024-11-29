<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$student_id = $_POST['student_id'];
$subject_id = $_POST['subject_id'];
$semester_id = $_POST['semester_id'];

$grades = new Grades($conn);
$grades = $grades->getGradesForStudentAndSubject($student_id, $subject_id, $semester_id);

echo json_encode($grades);