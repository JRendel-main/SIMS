<?php

include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$user = new User($conn);

$teacherFirstName = $_POST['teacherFirstName'];
$teacherMiddleName = $_POST['teacherMiddleName'];
$teacherLastName = $_POST['teacherLastName'];
$teacherGender = $_POST['teacherGender'];
$teacherDob = $_POST['teacherDob'];
$teacherTitle = $_POST['teacherTitle'];
$teacherEmail = $_POST['teacherEmail'];
$teacherContactNum = $_POST['teacherContactNum'];

// get the text before @ on email
$teacherUsername = explode('@', $teacherEmail)[0];

$formData = [
    'teacherFirstName' => $teacherFirstName,
    'teacherMiddleName' => $teacherMiddleName,
    'teacherLastName' => $teacherLastName,
    'teacherGender' => $teacherGender,
    'teacherDob' => $teacherDob,
    'teacherTitle' => $teacherTitle,
    'teacherEmail' => $teacherEmail,
    'teacherContactNum' => $teacherContactNum,
    'teacherUsername' => $teacherUsername
];

$response = $user->addTeacher($formData);

if ($response['success']) {
    $userId = $response['user_id'];
    $credentials = $user->getCredentials($userId);

    $email = new Email();
    $email->sendTeacherCredentials($teacherEmail, $teacherUsername, $credentials['password']);
    echo json_encode([
        'success' => true,
        'message' => 'Teacher added successfully'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to add teacher'
    ]);
}