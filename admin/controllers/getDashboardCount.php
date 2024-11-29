<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$academic = new Academic($conn);

$teacherCount = $academic->getTeacherCount();
$studentCount = $academic->getStudentCount();
$subjectCount = $academic->getSubjectCount();
$sectionCount = $academic->getSectionCount();

echo json_encode([
    'teacherCount' => $teacherCount['total_teachers'],
    'studentCount' => $studentCount['total_students'],
    'subjectCount' => $subjectCount['total_subjects'],
    'sectionCount' => $sectionCount['total_sections']
]);