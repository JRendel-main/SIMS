<?php

include '../../controllers/autoloader.php';

$student_id = $_POST['student_id'];
$academic_id = $_POST['academic_id'];
$month = $_POST['month'];
$school_days = $_POST['school_days'];
$present_days = $_POST['present_days'];

$db = new Database();
$conn = $db->connect();

$attendance = new Attendance($conn);

// check month if exist
$checkMonth = $attendance->checkMonth($student_id, $academic_id, $month);

if ($checkMonth) {
    echo json_encode(['status' => 'error', 'message' => 'Attendance for this month already exists']);
    exit;
}

$addAttendance = $attendance->addStudentAttendance($student_id, $academic_id, $month, $school_days, $present_days);

if ($addAttendance) {
    echo json_encode(['status' => 'success', 'message' => 'Attendance added successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add attendance']);
}