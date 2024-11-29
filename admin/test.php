<?php

include '../controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$user = new User($conn);

$password = $user->getCredentials(9);

echo $password['password'];