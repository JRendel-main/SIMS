<?php
include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();
// Instantiate Teacher class with database connection
$teacherDb = new Teacher($conn);

$requestData = $_REQUEST;

$data = $teacherDb->fetchTeachers($requestData);

echo json_encode(
    array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($data['totalRecords']),
        "recordsFiltered" => intval($data['totalFiltered']),
        "data" => $data['data']
    )
);