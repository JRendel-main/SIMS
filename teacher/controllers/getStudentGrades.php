<?php
include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$grades = new Grades($conn);

$student_id = $_POST['student_id'];
$academic_year = $_POST['academic_id'];

$studentGrades = $grades->getStudentFinals($student_id, $academic_year);

// Initialize an empty array to store the organized data
$data = [];

foreach ($studentGrades as $grade) {
    $subject_name = $grade['subject_name'];
    $final_grade = $grade['final_grade'];

    // Check if the subject exists in the data array, if not, initialize it
    if (!isset($data[$subject_name])) {
        $data[$subject_name] = [
            'subject_name' => $subject_name,
            'grades' => [], // Initialize an empty array to store individual grades
            'final_grade' => null,
            'remarks' => null
        ];
    }

    // Store each grade separately
    $data[$subject_name]['grades'][] = [
        'quarter' => $grade['Quarter'],
        'final_grade' => $final_grade
    ];
}

// Iterate over the subjects to calculate the final grade and remarks
foreach ($data as &$subject) {
    $total_grades = 0;
    foreach ($subject['grades'] as $grade) {
        $total_grades += $grade['final_grade'];
    }
    $subject['final_grade'] = round($total_grades / count($subject['grades']), 2); // Calculate average final grade
    $subject['remarks'] = ($subject['final_grade'] >= 75) ? 'Passed' : 'Failed';
}

echo json_encode(array_values($data)); // Convert associative array to indexed array and encode as JSON