<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$teacher_id = $_POST['teacher_id'];
$grades = new Grades($conn);
$studentLists = $grades->getAllStudentFinals($teacher_id);

$data = [];
if ($studentLists) {
    foreach ($studentLists as $student) {
        $studentId = $student['student_id'];
        $learnername = $student['last_name'] . ', ' . $student['first_name'] . ' ' . $student['middle_name'];

        $data[] = [
            'student_id' => $studentId,
            'learner_name' => $learnername
        ];
    }
    echo json_encode($data);
} else {
    echo json_encode([]);
}

?>