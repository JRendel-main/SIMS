<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$student_id = $_POST['student_id'];
$student_email = $_POST['email']; // Renamed variable to avoid conflict

$grades_link = "http://localhost/Student-Management-System/viewgrades.php?student_id=$student_id";

$email = new Email();
$email->sendStudentGrade($student_email, $grades_link); // Updated variable name here

echo json_encode(['status' => 'success', 'message' => 'Email sent successfully']);