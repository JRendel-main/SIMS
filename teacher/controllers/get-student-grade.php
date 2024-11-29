<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

// $student_id = $_POST['student_id'];
$grades = new Grades($conn);
$subject = new Subject($conn);
$section = new Section($conn);

$student_section = $section->getStudentSection(4);
$section_id = $student_section['section_id'];

$allSubjects = $subject->getSubjectsBySection($section_id);

echo json_encode($allSubjects);

?>