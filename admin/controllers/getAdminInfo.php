<?php
include '../../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();
$response = [];

$session = new Session();
$session->init();

$user = new User($conn);
$admin = $user->getAdminInfo($_SESSION['email']);

$username = $admin['username'];
$category = $admin['category'];

$response['username'] = $username;
$response['category'] = $category;

echo json_encode($response);