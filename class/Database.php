<?php

class Database
{
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $db = 'student_management';

    public function connect()
    {
        $conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($conn->connect_error) {
            die ("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}