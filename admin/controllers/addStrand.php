<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$strand_name = $_POST['strandName'];

$strand = new Academic($conn);
$strand->addStrand($strand_name);

echo json_encode(['message' => 'Strand added successfully!', 'success' => true]);