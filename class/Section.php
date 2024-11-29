<?php

class Section
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getSection($section_id)
    {
        $sql = "SELECT * FROM section WHERE section_id = $section_id";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            return $data;
        } else {
            return false;
        }
    }

    public function getAdvisorySection($teacher_id)
    {
        $sql = "SELECT * FROM section where advisor_id = $teacher_id";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            return $data;
        } else {
            return false;
        }
    }

    public function getSubjectSection($teacher_id)
    {
        $sql = "SELECT s.year, 
            s.section_id,
            s.section_name, 
            st.strand_name,
            su.subject_id,
            su.subject_name,
            CONCAT(t.first_name,' ',t.last_name) AS teacher_name
            FROM section AS s
            INNER JOIN strand AS st ON st.strand_id = s.strand_id
            INNER JOIN subject AS su ON su.strand_id = s.strand_id
            INNER JOIN teacher AS t ON t.teacher_id = su.subject_teacher 
            WHERE t.teacher_id = ?";

        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $teacher_id); // Assuming teacher_id is an integer
            $stmt->execute();
            $result = $stmt->get_result();

            // Fetch all rows as an associative array
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            return $data;
        } else {
            return false;
        }
    }

    public function getStudentSection($student_id)
    {
        $sql = "SELECT * FROM section WHERE section_id = (SELECT section_id FROM student WHERE student_id = ?)";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $student_id); // Assuming student_id is an integer
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            return $data;
        } else {
            return false;
        }
    }

    public function deleteSection($section_id)
    {
        $sql = "DELETE FROM section WHERE section_id = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $section_id); // Assuming section_id is an integer
            $stmt->execute();
            return true;
        } else {
            return false;
        }
    }

}