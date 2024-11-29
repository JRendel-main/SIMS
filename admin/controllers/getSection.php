<?php
include '../../controllers/autoloader.php';
$db = new Database();
$conn = $db->connect();

$schoolYear = new Academic($conn);
$section = $schoolYear->getAllSection();

$sectionList = [];

foreach ($section as $sec) {
    $year = 'Grade ' . $sec['year'];

    $sectionList[] = [
        'section_id' => $sec['section_id'],
        'section_name' => $sec['section_name'],
        'year' => $year,
        'advisor_name' => $sec['advisor_name'],
        'strand_name' => $sec['strand_name'],
        'advisor_id' => $sec['advisor_id']
    ];
}


echo json_encode($sectionList);