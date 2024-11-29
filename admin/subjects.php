<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>
<?php

if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
}

if ($_SESSION['role'] != 'admin') {
    header('Location: ../teacher/index.php');
}
?>

<head>
    <title>Admin Dashboard | Admin Portal</title>
    <?php include 'layouts/title-meta.php'; ?>

    <?php include 'layouts/head-css.php'; ?>
    <link href="../assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="../assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="../assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">
        <?php include 'layouts/menu.php'; ?>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <button class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#addSubjectModal"><i class="bi bi-plus"></i> Add
                                        Subject</button>
                                </div>
                                <h4 class="page-title">Subject Lists</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <table id="subject" class="table dt-responsive nowrap w-100">
                                    <thead></thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- container -->
            </div> <!-- content -->
            <?php include 'layouts/footer.php'; ?>
        </div>
        <!-- end content-page -->
    </div>
    <!-- END wrapper -->

    <!-- Add subject modal -->
    <!-- add select for Academic Year,  Strand, Semester, Subject Name, Subject Code-->
    <div class="modal fade" id="addSubjectModal" tabindex="-1" role="dialog" aria-labelledby="addSubjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addSubjectForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSubjectModalLabel">Add Subject</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="academic-year" class="col-form-label">Academic Year:</label>
                            <?php
                            $academic = new Academic($conn);
                            $academicYear = $academic->getAllAcademicYear();

                            if (count($academicYear) > 0) {
                                echo '<select class="form-select" id="academic-year" name="academic-year" required>';
                                echo '<option value="">Select Academic Year</option>';
                                foreach ($academicYear as $row) {
                                    echo '<option value="' . $row['academic_year_id'] . '">' . $row['year'] . '</option>';
                                }
                                echo '</select>';
                            } else {
                                echo '<p class="text-danger">No academic year found. Please add academic year first.</p>';
                            }
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="strand" class="col-form-label">Strand:</label>
                            <?php
                            $strand = new Academic($conn);
                            $strandList = $strand->getAllStrand();

                            if (count($strandList) > 0) {
                                echo '<select class="form-select" id="strand" name="strand" required>';
                                echo '<option value="">Select Strand</option>';
                                foreach ($strandList as $row) {
                                    echo '<option value="' . $row['strand_id'] . '">' . $row['strand_name'] . '</option>';
                                }
                                echo '</select>';
                            } else {
                                echo '<p class="text-danger">No strand found. Please add strand first.</p>';
                            }
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="col-form-label">Semester:</label>
                            <?php
                            $semester = new Academic($conn);
                            $semesterList = $semester->getAllSemester();

                            if (count($semesterList) > 0) {
                                echo '<select class="form-select" id="semester" name="semester" required>';
                                echo '<option value="">Select Semester</option>';
                                foreach ($semesterList as $row) {
                                    echo '<option value="' . $row['semester_id'] . '">' . $row['semester_name'] . '</option>';
                                }
                                echo '</select>';
                            } else {
                                echo '<p class="text-danger">No semester found. Please add semester first.</p>';
                            }
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="subjectTeacher" class="col-form-label">Subject Teacher:</label>
                            <?php
                            $teacher = new Teacher($conn);
                            $teacherList = $teacher->getAllTeachers();

                            if (count($teacherList) > 0) {
                                echo '<select class="form-select" id="subjectTeacher" name="subjectTeacher" required>';
                                echo '<option value="">Select Subject Teacher</option>';
                                foreach ($teacherList as $row) {
                                    echo '<option value="' . $row['teacher_id'] . '">' . $row['last_name'] . ', ' . $row['first_name'] . '</option>';
                                }
                                echo '</select>';
                            } else {
                                echo '<p class="text-danger">No teacher found. Please add teacher first.</p>';
                            }
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="subjectName" class="col-form-label">Subject Name:</label>
                            <input type="text" class="form-control" id="subjectName" name="subjectName" required>
                        </div>
                        <div class="mb-3">
                            <label for="subjectCode" class="col-form-label">Subject Code:</label>
                            <input type="text" class="form-control" id="subjectCode" name="subjectCode" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Subject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- edit subject modal -->

    <div class="modal fade" id="editSubjectModal" tabindex="-1" role="dialog" aria-labelledby="editSubjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editSubjectForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSubjectModalLabel">Edit Subject</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="editSubjectModalBody">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Subject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php include 'layouts/right-sidebar.php'; ?>

    <?php include 'layouts/footer-scripts.php'; ?>
    <script src="../assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="../assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js"></script>
    <script src="../assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
    <script src="../assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../assets/vendor/datatables.net-select/js/dataTables.select.min.js"></script>

    <!-- App js -->
    <script src="../assets/js/app.min.js"></script>
    <script src="scripts/subjects.js"></script>
</body>

</html>