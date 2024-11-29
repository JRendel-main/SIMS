<?php

include '../../controllers/autoloader.php';

$teacher_id = $_POST["teacher_id"];
$first_name = $_POST["first_name"];
$middle_name = $_POST["middle_name"];
$last_name = $_POST["last_name"];
$gender = $_POST["gender"];
$dob = $_POST["dob"];
$title = $_POST["title"];
$email = $_POST["email"];
$contact_num = $_POST["contact_num"];

$db = new Database();
$conn = $db->connect();

$teacher = new Teacher($conn);
$teacher->updateTeacher($teacher_id, $first_name, $middle_name, $last_name, $gender, $dob, $title, $email, $contact_num);

echo json_encode(array("message" => "Teacher updated successfully!", "success" => true, "title" => "Success!"));