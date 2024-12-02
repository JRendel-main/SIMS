<?php
include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$grades = new Grades($conn);

$student_id = $_POST['student_id'];
$academic_id = $_POST['academic_id'];
$semester = $_POST['semester'];

// Fetching the student grades
$studentGrades = $grades->getStudentFinalsGrades($student_id, $academic_id, $semester);


$data = [];

if($studentGrades) {

    foreach($studentGrades as $grades) {

        $grades_id = $grades['grades_id'];

        $subject_name = $grades['subject_name'];

        $professor_name = $grades['last_name'] .', ' . $grades['first_name'];

        $final_grades = $grades['final_grade'];

        $grade_id = $grades['grades_id'];

        $remarks = $grades['remarks'];


        $data[] = array(

            'grades_id' => $grades_id,

            'subject_name' => $subject_name,

            'professor_name' => $professor_name,

            'final_grades' => $final_grades,

            'remarks' => $remarks
        ); 

    }

}

// Output the result as JSON
echo json_encode(array_values($data)); 
