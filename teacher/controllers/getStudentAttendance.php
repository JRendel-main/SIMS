<?php

include '../../controllers/autoloader.php';

$student_id = $_POST['student_id'];
$academic_id = $_POST['academic_id'];

$db = new Database();
$conn = $db->connect();

$attendance = new Attendance($conn);
$studentAttendance = $attendance->getStudentAttendance($student_id, $academic_id);

$data = [];

// Create an array with all the months
$months = [
    '8' => 'August',
    '9' => 'September',
    '10' => 'October',
    '11' => 'November',
    '12' => 'December',
    '1' => 'January',
    '2' => 'February',
    '3' => 'March',
    '4' => 'April',
    '5' => 'May',
    '6' => 'June',
    '7' => 'July'
];

// Loop through all the months
foreach ($months as $monthNumber => $monthName) {
    $found = false;

    // Check if the month exists in the data
    foreach ($studentAttendance as $attendance) {
        if ($attendance['month'] == $monthNumber) {
            $found = true;
            $data[] = [
                'month' => $monthName,
                'school_days' => $attendance['school_days'],
                'present_days' => $attendance['present_days']
            ];
            break;
        }
    }

    // If the month doesn't exist, add it with 0 school days and present days
    if (!$found) {
        $data[] = [
            'month' => $monthName,
            'school_days' => null,
            'present_days' => null
        ];
    }
}

echo json_encode($data);