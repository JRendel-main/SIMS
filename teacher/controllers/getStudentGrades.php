<?php
include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$grades = new Grades($conn);

$section_id = $_POST['section_id'];
$subject_id = $_POST['subject_id'];

// Fetching the student grades
$studentGrades = $grades->getStudentFinals($section_id, $subject_id);

$data = [];

if($studentGrades) {

    foreach($studentGrades as $grades) {

        $student_id = $grades['student_id'];

        $student_name = $grades['last_name'] .', ' . $grades['first_name'];

        $final_grades = $grades['final_grade'];

        $grade_id = $grades['grades_id'];

        $remarks = $grades['remarks'];

        $semester = $grades['semester'];


        $data[] = array(

            'student_id' => $student_id,

            'student_name' => $student_name,

            'grades_id' => $grade_id,

            'final_grade' => $final_grades,

            'remarks' => $remarks,

            'semester' => $semester
        ); 

    }

}

// Output the result as JSON
echo json_encode(array_values($data)); 
