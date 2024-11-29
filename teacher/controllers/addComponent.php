<?php

include '../../controllers/autoloader.php';

$component = $_POST['component'];
$percentage = $_POST['percentage'];
$subjectId = $_POST['subject_id'];

$db = new Database();
$conn = $db->connect();

$grades = new Grades($conn);


$grades->addComponent($subjectId, $component, $percentage);

echo json_encode(array('success' => true, 'message' => 'Component added successfully'));
?>