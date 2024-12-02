<?php
include 'controllers/autoloader.php';
$session = new Session();
$session->init();

$role = $session->get('role');

if ($role == 'admin') {
    header('Location: admin/index.php');
} else if ($role == 'teacher') {
    header('Location: teacher/index.php');
}

// check if there is error in get, if there is alert the message
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    echo "<script>alert('$error')</script>";
}
?>

<head>
    <title>Student Information Management System</title>

    <?php include 'layouts/head-css.php'; ?>
</head>

<body class="authentication-bg pb-0">

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">

            <div class="card-body d-flex flex-column h-100 gap-3">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-start">
                    <a href="index.php" class="text-center logo-dark">
                        <span><img src="assets/images/nehs.png" alt="dark logo" height="80"></span>
                    </a>
                    <h1 class="text-center">Student Information Management System</h1>
                    <div class="text-center">
                        <p class="text-muted">Dr. Gloria D Lacson Foundation College Inc.</p>
                    </div>
                </div>
                <div class="mb-auto">
                    <!-- form -->
                    <form action="controllers/loginUser.php" method="post">
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Username / Email Address</label>
                            <input class="form-control" type="textbox" id="emailaddress" required="" name='username'
                                placeholder="Enter your username / email">
                        </div>
                        <div class="mb-3">
                            <a href="auth-recoverpw-2.php" class="text-muted float-end"><small>Forgot your
                                    password?</small></a>
                            <label for="password" class="form-label">Password</label>
                            <input class="form-control" type="password" required="" id="password" name='password'
                                placeholder="Enter your password">
                        </div>
                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-success" type="submit"><i class="ri-login-box-line"></i> Log In
                            </button>
                        </div>
                    </form>
                    <!-- end form-->
                </div>

                <!-- Footer-->
                <footer class="footer footer-alt">
                    <p class="text-muted">New student? <a href="#" id="requestLink" class="text-muted ms-1"><b>Request
                                here</b></a></p>
                </footer>

            </div> <!-- end .card-body -->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                <h2 class="mb-3">Quote of the day</h2>
                <p class="lead">"It is the supreme art of the teacher to awaken joy in creative expression and
                    knowledge."</p>
                <p>- Albert Einstein</p>
            </div> <!-- end auth-user-testimonial-->
        </div>
        <!-- end Auth fluid right content -->
    </div>

    <div id="requestModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Request Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="controllers/requestAccount.php" method="post">
                        <div class="mb-6">
                            <div class="col-md-12">
                                <label for="firstname" class="form-label">First Name</label>
                                <input class="form-control" type="textbox" id="firstname" required="" name='firstname'
                                    placeholder="Enter your first name">
                            </div>
                            <div class="col-md-12">
                                <label for="middlename" class="form-label">Middle Name</label>
                                <input class="form-control" type="textbox" id="middlename" required="" name='middlename'
                                    placeholder="Enter your middle name">
                            </div>
                            <div class="col-md-12">
                                <label for="lastname" class="form-label">Last Name</label>
                                <input class="form-control" type="textbox" id="lastname" required="" name='lastname'
                                    placeholder="Enter your last name">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Email Address</label>
                            <input class="form-control" type="textbox" id="emailaddress" required="" name='email'
                                placeholder="Enter your email">
                            <small class="text-muted">Note: Your email will be used as your username</small>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-group">Gender</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value=""></option>
                                <option value="male">Male</option>
                                <option value="">Female</option>
                                <option value="">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="student_type" class="form-group">Student Type</label>
                            <select class="form-control" id="student_type" name="student_type">
                                <option value="regular">Regular</option>
                                <option value="irregular">Irregular</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="student_type" class="form-group">Course</label>
                            <select class="form-control" id="course" name="student_course">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="student_type" class="form-group">Section</label>
                            <select class="form-control" id="section" name="student_section">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-success" type="submit"><i class="ri-login-box-line"></i> Request
                                Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end auth-fluid-->
    <?php include 'layouts/footer-scripts.php'; ?>
    <script>
        document.getElementById('requestLink').addEventListener('click', function () {
            var myModal = new bootstrap.Modal(document.getElementById('requestModal'), {
                keyboard: false
            });
            myModal.show();
        });
    </script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>

</html>