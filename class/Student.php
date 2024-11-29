<?php

class Student
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getStudentsBySection($section_id)
    {
        $query = "SELECT * FROM student WHERE section_id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $section_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            return $data;
        } else {
            return false;
        }
    }

    public function getStudent($student_id)
    {
        $query = "SELECT * FROM student WHERE student_id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();

            return $data;
        } else {
            return false;
        }
    }

    public function addStudent($first_name, $middle_name, $last_name, $email, $dob, $barangay, $city, $province, $nationality, $religion, $gender, $remarks, $section_id)
    {
        $query = "INSERT INTO student (section_id, first_name, middle_name, last_name, email, dob, barangay, city, province, nationality, religion, gender, remarks) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("issssssssssss", $section_id, $first_name, $middle_name, $last_name, $email, $dob, $barangay, $city, $province, $nationality, $religion, $gender, $remarks);

            // Execute the statement
            if ($stmt->execute()) {
                // Insert successful
                return true;
            } else {
                // Error handling
                return false;
            }
        } else {
            // Error handling
            return false;
        }
    }

    public function getAllBoys($section_id)
    {
        $query = "SELECT * FROM student WHERE section_id = ? AND gender = 'Male'";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $section_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            return $data;
        } else {
            return false;
        }
    }

    public function getAllGirls($section_id)
    {
        $query = "SELECT * FROM student WHERE section_id = ? AND gender = 'Female'";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $section_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            return $data;
        } else {
            return false;
        }
    }

    public function getStudentsSection($section_id)
    {
        $query = "SELECT * FROM student WHERE section_id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $section_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            return $data;
        } else {
            return false;
        }
    }

    public function getStudentEmail($teacher_id)
    {
        $query = "SELECT s.email, s.student_id FROM student s JOIN section se ON s.section_id = se.section_id JOIN teacher t ON se.advisor_id = t.teacher_id WHERE t.teacher_id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $teacher_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            return $data;
        } else {
            return false;
        }
    }
}