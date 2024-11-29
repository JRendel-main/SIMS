<?php

include '../../controllers/autoloader.php';

$id = $_POST['id'];

$db = new Database();
$conn = $db->connect();

$teacher = new Teacher($conn);
$teacherLists = $teacher->getTeacher($id);

$data = array();

foreach ($teacherLists as $teacherList) {
    $data[] = array(
        'teacher_id' => $teacherList['teacher_id'],
        'first_name' => $teacherList['first_name'],
        'middle_name' => $teacherList['middle_name'],
        'last_name' => $teacherList['last_name'],
        'gender' => $teacherList['gender'],
        'dob' => $teacherList['DOB'],
        'title' => $teacherList['title'],
        'contact' => $teacherList['contact_num'],
        'email' => $teacherList['email'],
        'username' => $teacherList['username']
    );
}

echo json_encode($data);