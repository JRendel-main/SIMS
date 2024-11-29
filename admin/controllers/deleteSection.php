<?php

include '../../controllers/autoloader.php';

$section_id = $_POST['id'];

$db = new Database();
$conn = $db->connect();

$section = new Section($conn);

$deleteSection = $section->deleteSection($section_id);

if ($deleteSection) {
    echo json_encode(array('status' => 'success', 'message' => 'Section deleted successfully'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Failed to delete section'));
}

?>