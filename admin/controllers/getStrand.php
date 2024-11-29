<?php
include '../../controllers/autoloader.php';
$db = new Database();
$conn = $db->connect();

$academic = new Academic($conn);
$strand = $academic->getAllStrand();

$strandList = [];

foreach ($strand as $str) {
    $strandList[] = [
        'strand_id' => $str['strand_id'],
        'strand_name' => $str['strand_name']
    ];
}

echo json_encode($strandList);