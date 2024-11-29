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
                                        data-bs-target="#addSectionModal">
                                        <i class="bi bi-plus"></i>
                                        Add Section</button>
                                </div>
                                <h4 class="page-title">Section Lists</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <table id="section" class="table table-striped dt-responsive nowrap w-100">
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

        <!-- Add section modal -->
        <div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="addSectionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="addSectionForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addSectionModalLabel">Add Section</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="sectionName" class="col-form-label">Section Name:</label>
                                <input type="text" class="form-control" id="sectionName" name="sectionName" required>
                            </div>
                            <div class="mb-3">
                                <label for="gradeLevel" class="col-form-label">Grade Level:</label>
                                <select class="form-select" id="gradeLevel" name="gradeLevel" required>
                                    <option value="">Select Grade Level</option>
                                    <option value="1">First Year (Freshmen)</option>
                                    <option value="2">Second Year(Sophomore)</option>
                                    <option value="3">Third Year(Junior)</option>
                                    <option value="3">Fourth Year(Senior)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="advisorId" class="col-form-label">Advisor:</label>
                                <select class="form-select" id="advisorId" name="advisorId" required>
                                    <option value="">Select Advisor</option>
                                    <?php
                                    $teacher = new Teacher($conn);
                                    $teachers = $teacher->getAllTeachers();
                                    foreach ($teachers as $teacher) {
                                        echo '<option value="' . $teacher['teacher_id'] . '">' . $teacher['first_name'] . ' ' . $teacher['last_name'] . ' - ' . $teacher['title'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="strandId" class="col-form-label">Strand:</label>
                                <select class="form-select" id="strandId" name="strandId" required>
                                    <option value="">Select Strand</option>
                                    <?php
                                    $strand = new Academic($conn);
                                    $strands = $strand->getAllStrand();
                                    foreach ($strands as $strand) {
                                        echo '<option value="' . $strand['strand_id'] . '">' . $strand['strand_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end modal for adding teacher manually -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- end modal for adding teacher manually -->

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Change advisor modal -->
    <div class="modal fade" id="changeAdvisorModal" tabindex="-1" aria-labelledby="changeAdvisorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="changeAdvisorForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeAdvisorModalLabel">Change Advisor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="sectionId" name="sectionId">
                        <div class="mb-3">
                            <label for="advisorId" class="col-form-label">Advisor:</label>
                            <select class="form-select" id="advisorId" name="advisorId" required>
                                <option value="">Select Advisor</option>
                                <?php
                                $teacher = new Teacher($conn);
                                $teachers = $teacher->getAllTeachers();
                                foreach ($teachers as $teacher) {
                                    echo '<option value="' . $teacher['teacher_id'] . '">' . $teacher['first_name'] . ' ' . $teacher['last_name'] . ' - ' . $teacher['title'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
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
    <script src="scripts/section.js"></script>

</body>

</html>