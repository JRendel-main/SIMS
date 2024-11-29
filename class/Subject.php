<?php

class Subject
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllSubject()
    {
        $query = "SELECT * FROM subject";
        $result = $this->conn->query($query);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function addSubject($subjctTeacher, $academic_year, $strand, $semester, $subject_name, $subjectCode)
    {
        $query = "INSERT INTO subject (subject_teacher, academic_year_id, strand_id, semester_id, subject_name, subject_code) VALUES ('$subjctTeacher', '$academic_year', '$strand', '$semester', '$subject_name', '$subjectCode')";
        $result = $this->conn->query($query);

        if (!$result) {
            die("Error in SQL query: " . $this->conn->error);
        }

        return $result;
    }

    public function fetchSubjects($requestData)
    {
        $columns = ['subject_id', 'academic_year_id', 'strand_id', 'semester_id', 'subject_name', 'subject_code'];
        $query = "SELECT a.*, b.*, c.*, d.* 
          FROM subject a 
          INNER JOIN academic_year b ON a.academic_year_id = b.academic_year_id 
          INNER JOIN strand c ON a.strand_id = c.strand_id 
          INNER JOIN semester d ON a.semester_id = d.semester_id";

        $data = [];
        $totalData = 0;
        $totalFiltered = 0;

        if (!empty($requestData['search']['value'])) {
            $query .= " WHERE subject_name LIKE '%" . $requestData['search']['value'] . "%' ";
        }

        $result = $this->conn->query($query);
        $totalData = $result->num_rows;
        $totalFiltered = $totalData;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $json_data = [
            "draw" => intval($requestData['draw']),
            "totalData" => intval($totalData),
            "totalFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        return $json_data;
    }

    public function deleteSubject($subjectId)
    {
        $query = "DELETE FROM subject WHERE subject_id = '$subjectId'";
        $result = $this->conn->query($query);

        if (!$result) {
            die("Error in SQL query: " . $this->conn->error);
        }

        return $result;
    }

    public function getSubject($subjectId)
    {
        $query = "SELECT * FROM subject WHERE subject_id = $subjectId";
        $result = $this->conn->query($query);
        $data = [];

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        }

        return $data;
    }

    public function getStudentSubjects($student_id)
    {
        $query = "SELECT * FROM subject WHERE subject_id IN (SELECT subject_id FROM grades WHERE student_id = $student_id)";
        $result = $this->conn->query($query);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function getStudentAllSubjectsLists($student_id)
    {
        $query = "SELECT * FROM subject WHERE subject_id IN (SELECT subject_id FROM grades WHERE student_id = $student_id)";
        $result = $this->conn->query($query);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function getSubjectsBySection($section_id)
    {
        $query = "SELECT * FROM subject WHERE strand_id = (SELECT strand_id FROM section WHERE section_id = $section_id)";
        $result = $this->conn->query($query);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }
}