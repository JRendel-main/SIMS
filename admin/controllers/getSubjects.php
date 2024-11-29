<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$subjectDb = new Subject($conn);
$requestData = $_REQUEST;

$data = $subjectDb->fetchSubjects($requestData);

echo json_encode(
    [
        'draw' => $requestData['draw'],
        'recordsTotal' => $data['totalData'],
        'recordsFiltered' => $data['totalFiltered'],
        'data' => $data['data']
    ]
)

    ?>