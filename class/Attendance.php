<?php

class Attendance
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getStudentAttendance($student_id, $academic_id)
    {
        $sql = "SELECT * FROM attendance WHERE student_id = ? AND academic_id = ?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param('ii', $student_id, $academic_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $attendance = [];

        while ($row = $result->fetch_assoc()) {
            $attendance[] = $row;
        }

        return $attendance;
    }

    public function checkMonth($student_id, $academic_id, $month)
    {
        $sql = "SELECT * FROM attendance WHERE student_id = ? AND academic_id = ? AND month = ?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param('iis', $student_id, $academic_id, $month);
        $stmt->execute();

        $result = $stmt->get_result();
        $attendance = $result->fetch_assoc();

        return $attendance;
    }

    public function addStudentAttendance($student_id, $academic_id, $month, $school_days, $present_days)
    {
        $sql = "INSERT INTO attendance (student_id, academic_id, month, school_days, present_days) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param('iisii', $student_id, $academic_id, $month, $school_days, $present_days);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    // get data for bar chart in admin display the attendance of all students in every montj
    public function getAttendanceByMonth()
    {
        $sql = "SELECT month, SUM(present_days) as present_days, SUM(school_days) as school_days FROM attendance GROUP BY month";
        $result = $this->conn->query($sql);

        $attendance = [];

        while ($row = $result->fetch_assoc()) {
            $attendance[] = $row;
        }

        return $attendance;
    }
}