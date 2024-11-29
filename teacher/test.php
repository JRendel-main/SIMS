<?php

include '../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$academic = new Academic($conn);
$section = $academic->getSection(11);

$data = [];

$data = $section['section_name'];

echo json_encode($data);