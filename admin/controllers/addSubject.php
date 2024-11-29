<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$academic = new Academic($conn);

$academic_year = $_POST['academic-year'];
$strand = $_POST['strand'];
$semester = $_POST['semester'];
$subject_name = $_POST['subjectName'];
$subjectCode = $_POST['subjectCode'];
$subjectTeacher = $_POST['subjectTeacher'];

$subject = new Subject($conn);
$subject->addSubject($subjectTeacher, $academic_year, $strand, $semester, $subject_name, $subjectCode);

if ($subject) {
    echo json_encode(['success' => true, 'message' => 'Subject added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add subject']);
}