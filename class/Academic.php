<?php
class Academic
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllAcademicYear()
    {
        $query = "SELECT * FROM academic_year";
        $result = $this->conn->query($query);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function getAllSection()
    {
        $query = 'SELECT a.*, b.strand_name, CONCAT(c.first_name, " ", c.last_name) as advisor_name FROM section a, strand b, teacher c WHERE a.strand_id = b.strand_id AND a.advisor_id = c.teacher_id ORDER BY a.section_id DESC';
        $result = $this->conn->query($query);
        $data = [];

        if (!$result) {
            // Handle SQL error
            echo "Error: " . $this->conn->error;
            return $data;
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }


    public function addSection($section_name, $grade_level, $advisor_id, $strand_id)
    {
        $query = "INSERT INTO section (section_name, year, advisor_id, strand_id) VALUES ('$section_name', '$grade_level', '$advisor_id', '$strand_id')";
        $result = $this->conn->query($query);

        if (!$result) {
            die("Error in SQL query: " . $this->conn->error);
        }

        return $result;
    }

    public function getAllStrand()
    {
        $query = "SELECT * FROM strand";
        $result = $this->conn->query($query);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function addStrand($strand_name)
    {
        $query = "INSERT INTO strand (strand_name) VALUES ('$strand_name')";
        $result = $this->conn->query($query);

        if (!$result) {
            die("Error in SQL query: " . $this->conn->error);
        }

        return $result;
    }

    public function getTeacherId($user_id)
    {
        $query = "SELECT teacher_id FROM teacher WHERE user_id = $user_id";
        $results = $this->conn->query($query);

        // get the teacher id
        $teacher = $results->fetch_assoc();
        return $teacher['teacher_id'];
    }

    public function getSection($advisor_id)
    {
        $query = "SELECT * FROM section WHERE advisor_id = $advisor_id";
        $results = $this->conn->query($query);

        // get the section name
        $section = $results->fetch_assoc();
        return $section;

    }


    public function getTotalStudents($teacher_id)
    {
        $query = "SELECT COUNT(*) as total_students FROM student WHERE section_id = (SELECT section_id FROM section WHERE advisor_id = $teacher_id)";
        $results = $this->conn->query($query);

        // get the total students
        $students = $results->fetch_assoc();
        return $students['total_students'];
    }

    public function getAllSemester()
    {
        $query = "SELECT * FROM semester";
        $result = $this->conn->query($query);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function getSemesterId($semester)
    {
        $query = "SELECT * FROM semester WHERE semester_id = '$semester'";
        $results = $this->conn->query($query);

        // get all 
        $semester = $results->fetch_assoc();
        return $semester;
    }

    public function getStrand($strand_id)
    {
        $query = "SELECT * FROM strand WHERE strand_id = $strand_id";
        $result = $this->conn->query($query);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function getSemester()
    {
        $query = "SELECT * FROM semester ORDER BY Quarter ASC";
        $result = $this->conn->query($query);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function addAcademicYear($schoolYear)
    {
        $query = "INSERT INTO academic_year (year) VALUES ('$schoolYear')";
        $result = $this->conn->query($query);

        if (!$result) {
            die("Error in SQL query: " . $this->conn->error);
        }

        return $result;
    }

    public function deleteAcademicYear($schoolYear)
    {
        $query = "DELETE FROM academic_year WHERE academic_year_id = $schoolYear";
        $result = $this->conn->query($query);

        if (!$result) {
            die("Error in SQL query: " . $this->conn->error);
        }

        return $result;
    }

    public function getAcademicYear($academic_id)
    {
        $query = "SELECT * FROM academic_year WHERE academic_year_id = $academic_id LIMIT 1";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return [];
    }

    public function getStudentCount()
    {
        $query = "SELECT COUNT(*) as total_students FROM student";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return [];
    }

    public function getTeacherCount()
    {
        $query = "SELECT COUNT(*) as total_teachers FROM teacher";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return [];
    }

    public function getSubjectCount()
    {
        $query = "SELECT COUNT(*) as total_subjects FROM subject";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return [];
    }

    public function getSectionCount()
    {
        $query = "SELECT COUNT(*) as total_sections FROM section";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return [];
    }

    public function getRecentStudents()
    {
        // display also the section_name and grade
        $query = "SELECT a.student_id, a.first_name, a.last_name, b.section_name, b.year as grade FROM student a, section b WHERE a.section_id = b.section_id ORDER BY a.student_id DESC LIMIT 5";
        $result = $this->conn->query($query);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
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
}