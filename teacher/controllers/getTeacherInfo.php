<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$user = new User($conn);
$userId = $user->getId($_SESSION['email']);

$teacher = new Teacher($conn);
$teacherInfo = $teacher->getTeacherInfo($userId);

echo json_encode($teacherInfo);