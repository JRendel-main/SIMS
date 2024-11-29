<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$teacher = new Teacher($conn);
$teacherLists = $teacher->getAllTeachers();

echo json_encode($teacherLists);