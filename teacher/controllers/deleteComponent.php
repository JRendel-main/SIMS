<?php

include '../../controllers/autoloader.php';

$component = $_POST['component_id'];

$db = new Database();
$conn = $db->connect();

$grades = new Grades($conn);

$deleteComponent = $grades->deleteComponent($component);

if ($deleteComponent > 0) {
    echo json_encode(array('success' => true, 'message' => 'Component deleted successfully'));
} else {
    echo json_encode(array('success' => false, 'message' => 'Failed to delete component'));
}

?>