<?php

include '../../controllers/autoloader.php';

$first_name = $_POST['first_name'];
$middle_name = $_POST['middle_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$dob = $_POST['dob'];
$barangay = $_POST['barangay'];
$city = $_POST['city'];
$province = $_POST['province'];
$nationality = $_POST['nationality'];
$religion = $_POST['religion'];
$gender = $_POST['gender'];
$remarks = $_POST['remarks'];
$teacher_id = $_POST['teacher_id'];

$db = new Database();
$conn = $db->connect();

$section = new Academic($conn);
$section_id = $section->getSection($teacher_id);

$student = new Student($conn);
$addStudent = $student->addStudent($first_name, $middle_name, $last_name, $email, $dob, $barangay, $city, $province, $nationality, $religion, $gender, $remarks, $section_id['section_id']);

if ($addStudent) {
    echo json_encode(array('success' => true, 'message' => 'Student added successfully'));
} else {
    echo json_encode(array('success' => false, 'message' => 'Failed to add student'));
}