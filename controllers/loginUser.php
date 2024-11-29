<?php
include 'autoloader.php';

$db = new Database();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User($conn);
    $result = $user->login($username, $password);


    if ($result['success']) {
        $session = new Session();
        $session->init();
        $role = $result['user']['category'];

        if ($role == 'admin') {
            $session->set('login', true);
            $session->set('email', 'admin');
            $session->set('role', 'admin');
            header('Location: ../admin/index.php');
            echo '<script>alert("Login successful")</script>';
        } else {
            $session->set('login', true);
            $session->set('email', $result['user']['email']);
            $session->set('role', 'teacher');
            echo '<script>alert("Login successful")</script>';
            header('Location: ../teacher/index.php');
        }
    } else {
        $message = $result['error'];
        header('Location: ../index.php?error=' . $message);
    }
} else {
    header('Location: ../index.php?error=Invalid request method');
}