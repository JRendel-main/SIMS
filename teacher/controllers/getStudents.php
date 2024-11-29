<?php

include '../../controllers/autoloader.php';

$section_id = $_POST['section_id'];
$subject_id = $_POST['subject_id'];

$db = new Database();
$conn = $db->connect();

$student = new Student($conn);
$studentLists = $student->getStudentsBySection($section_id);

foreach ($studentLists as $student) {
    $student_id = $student['student_id'];
    $student_name = $student['last_name'] . ', ' . $student['first_name'] . ' ' . $student['middle_name'];
    $gender = $student['gender'];

    if ($gender == 'Male') {
        $gender = '<span class="badge badge-outline-info badge-pill" style="font-size: 12px;">' . $gender . '</span>';
    } else {
        $gender = '<span class="badge badge-outline-danger badge-pill" style="font-size: 12px;">' . $gender . '</span>';
    }

    $data[] = array(
        'student_id' => $student_id,
        'student_name' => $student_name,
        'gender' => $gender,
    );
}

echo json_encode($data);