<?php

class Teacher
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getTeacherInfo($id)
    {
        $sql = "SELECT * FROM teacher WHERE user_id = $id";
        $query = $this->conn->query($sql);

        if (!$query) {
            // Error occurred in SQL query execution
            die("SQL Error: " . $this->conn->error);
        }

        return $query->fetch_assoc();
    }

    public function getAllTeachers()
    {
        $sql = "SELECT * FROM teacher";
        $query = $this->conn->query($sql);

        if (!$query) {
            // Error occurred in SQL query execution
            die("SQL Error: " . $this->conn->error);
        }

        $data = array();
        while ($row = $query->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function getTeacher($id)
    {
        $sql = "SELECT a.*, b.* FROM teacher a, user b WHERE teacher_id = $id AND a.user_id = b.user_id";
        $query = $this->conn->query($sql);

        $data = [];
        while ($row = $query->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function fetchTeachers($requestData)
    {
        $columns = array(
            0 => 'teacher.teacher_id',
            1 => 'CONCAT(teacher.first_name, " ", teacher.middle_name, " ", teacher.last_name) AS name',
            2 => 'user.email',
            3 => 'teacher.gender',
            4 => 'teacher.contact_num',
            5 => 'teacher.title'
        );

        $sql = "SELECT teacher.teacher_id, 
                       CONCAT(teacher.first_name, ' ', teacher.middle_name, ' ', teacher.last_name) AS name, 
                       user.email, 
                       teacher.gender, 
                       teacher.contact_num,
                       teacher.title
                FROM teacher 
                INNER JOIN user ON teacher.user_id = user.user_id";

        if (!empty($requestData['order'])) {
            $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'];
        }

        $query = $this->conn->query($sql);

        if (!$query) {
            // Error occurred in SQL query execution
            die("SQL Error: " . $this->conn->error);
        }

        $totalData = $query->num_rows;
        $totalFiltered = $totalData;

        $sql .= " LIMIT " . $requestData['start'] . ", " . $requestData['length'];
        $query = $this->conn->query($sql);

        if (!$query) {
            // Error occurred in SQL query execution
            die("SQL Error: " . $this->conn->error);
        }

        $data = array();
        while ($row = $query->fetch_assoc()) {
            $data[] = $row;
        }

        return array(
            "totalRecords" => $totalData,
            "totalFiltered" => $totalFiltered,
            "data" => $data
        );
    }

    public function deleteTeacher($id)
    {
        $sql = "DELETE FROM teacher WHERE teacher_id = $id";
        $query = $this->conn->query($sql);

        if (!$query) {
            // Error occurred in SQL query execution
            die("SQL Error: " . $this->conn->error);
        }

        return true;
    }

    public function updateTeacher($id, $first_name, $middle_name, $last_name, $gender, $dob, $title, $email, $contact_num)
    {
        $query = 'UPDATE teacher SET first_name = ?, middle_name = ?, last_name = ?, gender = ?, DOB = ?, title = ?, contact_num = ? WHERE teacher_id = ?';
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('sssssssi', $first_name, $middle_name, $last_name, $gender, $dob, $title, $contact_num, $id);
        $stmt->execute();

        $query = 'UPDATE user SET email = ? WHERE user_id = (SELECT user_id FROM teacher WHERE teacher_id = ?)';
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('si', $email, $id);
        $stmt->execute();

        return true;

    }
}

?>