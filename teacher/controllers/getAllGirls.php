<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$teacher_id = $_POST['teacher_id'];

$academic = new Academic($conn);
$section = $academic->getSection($teacher_id);

$section_id = $section['section_id'];
$boys = new Student($conn);
$girlsLists = $boys->getAllGirls($section_id);

$data = [];

foreach ($girlsLists as $boy) {
    $data[] = [
        'student_id' => $boy['student_id'],
        'name' => $boy['last_name'] . ', ' . $boy['first_name'] . ' ' . $boy['middle_name'],
    ];
}

echo json_encode($data);