<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$attendance = new Attendance($conn);


$attendanceByMonth = $attendance->getAttendanceByMonth();

echo json_encode($attendanceByMonth);