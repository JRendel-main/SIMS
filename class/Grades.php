<?php
class Grades
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getGrades($student_id)
    {
        $sql = "SELECT * FROM grades WHERE student_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$student_id]);
        return $stmt->fetchAll();
    }

    public function addGrade($final_grade, $student_id, $semester, $subject_id)
    {
        $sql = "INSERT INTO grades (final_grade, student_id, semester, subject_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$final_grade, $student_id, $semester, $subject_id]);
    }

    public function editGrade($grade_id, $final_grade)
    {
        $sql = "UPDATE grades SET final_grade = ? WHERE grades_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$final_grade, $grade_id]);
    }

    public function getGradesForStudentAndSubjectByComponent($student_id, $subject_id, $component_id)
    {
        $sql = "SELECT * FROM grades WHERE student_id = ? AND subject_id = ? AND component_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $student_id, $subject_id, $component_id); // Assuming all IDs are integers
        $stmt->execute();

        $result = $stmt->get_result(); // Get the result set
        $data = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array

        return $data;
    }


    public function getGradeComponent($subject_id)
    {
        $sql = "SELECT * FROM grade_component WHERE subject_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $subject_id); // Assuming $subject_id is an integer
        $stmt->execute();

        $result = $stmt->get_result(); // Get the result set
        $data = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array

        return $data;
    }

    public function deleteComponent($component)
    {
        $sql = "DELETE FROM grade_component WHERE component_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $component); // Assuming $component is an integer
        $stmt->execute();

        // check if the delete was successful
        return $stmt->affected_rows;
    }

    public function getGradesForStudentAndSubject($student_id, $subject_id, $semester_id, $academic_id)
    {
        $sql = "SELECT a.grades_id, a.initial_grade, a.highest_grade, b.component_name, b.component_id, b.weight FROM grades a JOIN grade_component b ON a.component_id = b.component_id WHERE a.student_id = ? AND b.subject_id = ? AND a.semester_id = ? AND a.academic_id = ?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("iiii", $student_id, $subject_id, $semester_id, $academic_id); // Assuming $student_id and $subject_id are integers
        $stmt->execute();

        $result = $stmt->get_result(); // Get the result set

        $data = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array

        return $data;
    }

    public function calculateTotalGrade($grades, $gradeComponent)
    {
        $totalGrade = 0;
        foreach ($gradeComponent as $component) {
            $totalGrade += $grades[$component['component_id']] * $component['weight'];
        }
        return $totalGrade;
    }

    public function updateInitialGrade($grade_id, $initial_grade)
    {
        $sql = "UPDATE grades SET initial_grade = ? WHERE grades_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $initial_grade, $grade_id); // Assuming $initial_grade and $grade_id are integers
        $stmt->execute();

        // check if the update was successful
        return $stmt->affected_rows;
    }

    public function updateHighestGrade($grade_id, $highest_grade)
    {
        $sql = "UPDATE grades SET highest_grade = ? WHERE grades_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $highest_grade, $grade_id); // Assuming $highest_grade and $grade_id are integers
        $stmt->execute();

        // check if the update was successful
        return $stmt->affected_rows;
    }

    public function deleteGrade($grade_id)
    {
        $sql = "DELETE FROM grades WHERE grades_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $grade_id); // Assuming $grade_id is an integer
        $stmt->execute();

        // check if the delete was successful
        return $stmt->affected_rows;
    }

    public function getAllStudentFinals($teacher_id)
    {
        $sql = "SELECT * FROM student WHERE section_id = (SELECT section_id FROM section WHERE advisor_id = ?) ORDER BY last_name ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $teacher_id); // Assuming $teacher_id is an integer
        $stmt->execute();

        $result = $stmt->get_result(); // Get the result set
        $data = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array

        return $data;
    }

    public function getStudentGrades($student_id)
    {
        $sql = "SELECT * FROM grades WHERE student_id = $student_id";
        $result = $this->conn->query($sql);

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Fetch semester information
                $semester_id = $row['semester_id'];
                $semester_sql = "SELECT * FROM semester WHERE semester_id = $semester_id";
                $semester_result = $this->conn->query($semester_sql);
                $semester_row = $semester_result->fetch_assoc();
                $semester_name = $semester_row['semester_name'];

                $data[] = [
                    'grades_id' => $row['grades_id'],
                    'semester' => $semester_name,
                    'component_id' => $row['component_id'],
                    'highest_grade' => $row['highest_grade'],
                    'initial_grade' => $row['initial_grade'],
                    'student_id' => $row['student_id'],
                    'subject_id' => $row['subject_id']
                ];
            }
        }

        return $data;
    }

    public function getStudentAllSubjects($student_id)
    {
        $sql = "SELECT * FROM subject WHERE subject_id IN (SELECT subject_id FROM grades WHERE student_id = ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $student_id); // Assuming $student_id is an integer
        $stmt->execute();

        $result = $stmt->get_result(); // Get the result set
        $data = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array

        return $data;
    }

    public function calculateTotalGrades($student_id)
    {
        $sql = "SELECT * FROM grades WHERE student_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $student_id); // Assuming $student_id is an integer
        $stmt->execute();

        $result = $stmt->get_result(); // Get the result set
        $data = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array

        $totalGrades = [];
        foreach ($data as $grade) {
            $totalGrades[$grade['subject_id']][] = $grade;
        }

        return $totalGrades;
    }

    public function submitFinalGrade($student_id, $subject_id, $semester_id, $academic_id, $final_grade)
    {
        // check if there is already a final grade for the student
        $sql = "SELECT * FROM final_grade WHERE student_id = ? AND subject_id = ? AND semester_id = ? AND academic_id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            // Handle the error here, perhaps log it or return an error code
            return "Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error;
        }

        $stmt->bind_param("iiii", $student_id, $subject_id, $semester_id, $academic_id); // Assuming $student_id, $subject_id, and $semester_id are integers
        $stmt->execute();

        if ($stmt->errno) {
            // Handle the error here, perhaps log it or return an error code
            return "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $result = $stmt->get_result(); // Get the result set

        if ($result->num_rows > 0) {
            // Update the final grade
            $sql = "UPDATE final_grade SET final_grade = ? WHERE student_id = ? AND subject_id = ? AND semester_id = ? AND academic_id = ?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                // Handle the error here, perhaps log it or return an error code
                return "Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error;
            }
            $stmt->bind_param("diiii", $final_grade, $student_id, $subject_id, $semester_id, $academic_id); // Assuming $final_grade, $student_id, $subject_id, and $semester_id are integers
            $stmt->execute();

            if ($stmt->errno) {
                // Handle the error here, perhaps log it or return an error code
                return "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            return $stmt->affected_rows;
        } else {
            // Insert the final grade
            $sql = "INSERT INTO final_grade (student_id, subject_id, semester_id, academic_id, final_grade) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                // Handle the error here, perhaps log it or return an error code
                return "Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error;
            }
            $stmt->bind_param("iiiid", $student_id, $subject_id, $semester_id, $academic_id, $final_grade); // Assuming $student_id, $subject_id, and $semester_id are integers
            $stmt->execute();

            if ($stmt->errno) {
                // Handle the error here, perhaps log it or return an error code
                return "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            return $stmt->affected_rows;
        }
    }

    public function getStudentFinals($section_id, $subject_id)
{
    $sql = "
        SELECT 

            Student.student_id,

            Student.first_name,

            Student.last_name,

            Grade.grades_id,

            Grade.final_grade,

            Grade.remarks,

            Subject.semester

        FROM 

            student as Student 

        LEFT JOIN 

            section as Section ON Section.section_id = Student.section_id 

        LEFT JOIN

            grades as Grade ON Grade.student_id = Student.student_id AND Grade.subject_id = ?

        LEFT JOIN 

            subject as Subject ON Subject.subject_id = Grade.subject_id

        WHERE

            Student.section_id = ?
    ";

    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $this->conn->error);
    }

    $stmt->bind_param("ii", $subject_id, $section_id); // Bind parameters
    $stmt->execute();

    $result = $stmt->get_result(); // Get the result set
    if (!$result) {
        throw new Exception("Failed to execute query: " . $stmt->error);
    }

    $data = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as an associative array

    $stmt->close(); // Close the statement
    return $data;
}

public function getStudentFinalsGrades($student_id, $academic_id, $semester)
{
    $sql = "
        SELECT 

            Grades.*,

            Subject.*,

            Teacher.*

        FROM 

            grades as Grades 

        LEFT JOIN 

            subject as Subject ON Subject.subject_id = Grades.subject_id 

        LEFT JOIN

            teacher as Teacher ON Teacher.teacher_id = Subject.subject_teacher

        WHERE

            Subject.academic_year_id = ? AND Grades.student_id = ? AND Grades.semester = ?
    ";

    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $this->conn->error);
    }

    $stmt->bind_param("iis", $academic_id, $student_id, $semester); // Bind parameters
    $stmt->execute();

    $result = $stmt->get_result(); // Get the result set
    if (!$result) {
        throw new Exception("Failed to execute query: " . $stmt->error);
    }

    $data = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as an associative array

    $stmt->close(); // Close the statement
    return $data;
}



}