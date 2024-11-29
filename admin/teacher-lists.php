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
    <title>Teacher Dashboard | Admin Portal</title>
    <?php include 'layouts/title-meta.php'; ?>

    <?php include 'layouts/head-css.php'; ?>
    <link href="../assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="../assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="../assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="../assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="../assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="../assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet"
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
                                    <button class="btn btn-success waves-effect waves-light" data-bs-toggle="modal"
                                        data-bs-target="#addTeacherModal">
                                        <i class="bi bi-plus"></i>
                                        Add Manually</button>
                                </div>
                                <h4 class="page-title">Teacher Lists</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <table id="teacher-lists" class="table table-striped dt-responsive nowrap w-100">
                                    <thead></thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- container -->

            </div> <!-- content -->

            <?php include 'layouts/footer.php'; ?>

        </div>
        <!-- Modal for adding teacher manually -->
        <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title text-white" id="addTeacherModalLabel">Add Teacher Manually</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form id="addTeacherForm">
                                    <div class="mb-3">
                                        <label for="teacherFirstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="teacherFirstName"
                                            name="teacherFirstName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="teacherMiddleName" class="form-label">Middle Name</label>
                                        <input type="text" class="form-control" id="teacherMiddleName"
                                            name="teacherMiddleName">
                                    </div>
                                    <div class="mb-3">
                                        <label for="teacherLastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="teacherLastName"
                                            name="teacherLastName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="teacherGender" class="form-label">Gender</label>
                                        <select class="form-select" id="teacherGender" name="teacherGender" required>
                                            <option value="">Select gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="teacherDob" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="teacherDob" name="teacherDob"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="teacherTitle" class="form-label">Current Title</label>
                                        <input type="text" class="form-control" id="teacherTitle" name="teacherTitle"
                                            required>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="teacherEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="teacherEmail" name="teacherEmail"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="teacherContactNum" class="form-label">Contact Number</label>
                                    <input type="text" class="form-control" id="teacherContactNum"
                                        name="teacherContactNum" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light"
                            id="addTeacherManuallyBtn">Add Teacher</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for editing teacher -->
        <div class="modal fade" id="editTeacherModal" tabindex="-1" aria-labelledby="editTeacherModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editTeacherModalLabel">Edit Teacher Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editTeacherForm">
                            <input type="hidden" id="teacher_id" name="teacher_id">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editTeacherFirstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="editTeacherFirstName"
                                            name="first_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editTeacherMiddleName" class="form-label">Middle Name</label>
                                        <input type="text" class="form-control" id="editTeacherMiddleName"
                                            name="middle_name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editTeacherLastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="editTeacherLastName"
                                            name="last_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editTeacherGender" class="form-label">Gender</label>
                                        <select class="form-select" id="editTeacherGender" name="gender" required>
                                            <option value="">Select gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editTeacherDob" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="editTeacherDob" name="dob" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editTeacherTitle" class="form-label">Current Title</label>
                                        <input type="text" class="form-control" id="editTeacherTitle" name="title"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editTeacherEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="editTeacherEmail" name="email"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editTeacherContactNum" class="form-label">Contact Number</label>
                                        <input type="text" class="form-control" id="editTeacherContactNum"
                                            name="contact_num" required>
                                    </div>
                                    <!-- Advisory Section -->
                                    <div class="mb-3">
                                        <label for="editTeacherAdvisory" class="form-label">Advisory Section</label>
                                        <select class="form-select" id="editTeacherAdvisory" name="editTeacherAdvisory">
                                            <!-- Populate options dynamically using JavaScript or PHP -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- end modal for adding teacher manually -->

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

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
    <script src="scripts/teacher-lists.js"></script>

</body>

</html>