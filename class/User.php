<?php
class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getId($email)
    {
        $sql = "SELECT user_id FROM user WHERE email = '$email'";
        $result = $this->db->query($sql);
        return $result->fetch_assoc()['user_id'];
    }

    public function login($username, $password)
    {
        // Prepare SQL statement
        $sql = "SELECT * FROM user WHERE username = '$username'";
        $result = $this->db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($password === $row['password_hash']) {
                return [
                    'success' => true,
                    'user' => $row
                ];
            } else {
                return [
                    'success' => false,
                    'error' => 'Invalid username or password'
                ];
            }
        } else {
            return [
                'success' => false,
                'error' => 'Invalid username or password'
            ];
        }
    }

    public function getAdminInfo($username)
    {
        $sql = "SELECT * FROM user WHERE username = '$username' LIMIT 1";
        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }

    public function addTeacher($data)
    {
        // destructure data
        $firstName = $data['teacherFirstName'];
        $middleName = $data['teacherMiddleName'];
        $lastName = $data['teacherLastName'];
        $dob = $data['teacherDob'];
        $gender = $data['teacherGender'];
        $contactNum = $data['teacherContactNum'];
        $title = $data['teacherTitle'];
        $email = $data['teacherEmail'];
        $username = $data['teacherUsername'];
        $password = $this->generateTeacherPassword();
        $category = 'teacher';

        // profile
        $teacherProfile = 'https://ui-avatars.com/api/?name=' . $firstName . '+' . $lastName . '&size=256';

        // insert to user email password
        $sql = "INSERT INTO user (username, email, password_hash, category) VALUES ('$username','$email', '$password', '$category')";
        $this->db->query($sql);
        $userId = $this->db->insert_id;

        // insert to teacher table
        $sql = "INSERT INTO teacher (user_id, first_name, middle_name, last_name, DOB, gender, contact_num, title, profile_picture_url) 
                VALUES ('$userId', '$firstName', '$middleName', '$lastName', '$dob', '$gender', '$contactNum', '$title', '$teacherProfile')";
        $this->db->query($sql);

        if ($this->db->affected_rows > 0) {
            return [
                'success' => true,
                'message' => 'Teacher added successfully',
                'user_id' => $userId
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to add teacher'
            ];
        }
    }

    public function getCredentials($user_id)
    {
        $sql = "SELECT * FROM user WHERE user_id = '$user_id'";
        $result = $this->db->query($sql);

        $data = [];

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data['username'] = $row['username'];
            $data['password'] = $row['password_hash'];
        }

        return $data;
    }

    private function generateTeacherPassword()
    {
        // generate according to year and random 5 number sample (2021-00001)
        $year = date('Y');
        $random = rand(10000, 99999);
        return $year . '-' . $random;
    }
}