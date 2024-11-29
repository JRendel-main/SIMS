<!DOCTYPE html>
<html lang="en">
<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>
<?php

if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
}

if ($_SESSION['role'] != 'teacher') {
    header('Location: ../admin/index.php');
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
                                    <!-- Two buttons for prev and next buttons with icon on button-->
                                    <a href="javascript: void(0);" class="btn btn-info waves-effect waves-light">
                                        <i class="bi bi-chevron-left"></i> prev
                                    </a>
                                    <a href="javascript: void(0);" class="btn btn-info waves-effect waves-light">
                                        <i class="bi bi-chevron-right"></i> next
                                    </a>
                                </div>
                                <div class="page-title-left row">
                                    <div class="col-md-4">
                                        <h1 class="page-title">LAST NAME, FIRST NAME</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        if (isset($_GET['section_id'])) {
                            $section = new Section($conn);
                            $sectionId = $_GET['section_id'];
                        }
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered table-stripped">
                                        <thead>
                                            <tr class="text-center">
                                                <th rowspan="2" colspan="3">Learner's Name</th>
                                                <th colspan="13">Written Work</th>
                                                <th colspan="10">Performance Task</th>
                                                <th colspan="10">Quarterly Assessment</th>
                                                <th rowspan="3">Initial Grade</th>
                                                <th rowspan="3">Final Grade</th>
                                            </tr>
                                            <tr>
                                                <th>1</th>
                                                <th>2</th>
                                                <th>3</th>
                                                <th>4</th>
                                                <th>5</th>
                                                <th>6</th>
                                                <th>7</th>
                                                <th>8</th>
                                                <th>9</th>
                                                <th>10</th>
                                                <th>Total</th>
                                                <th>PS</th>
                                                <th>WS</th>
                                                <th>1</th>
                                                <th>2</th>
                                                <th>3</th>
                                                <th>4</th>
                                                <th>5</th>
                                                <th>6</th>
                                                <th>7</th>
                                                <th>8</th>
                                                <th>9</th>
                                                <th>10</th>
                                                <th>Total</th>
                                                <th>PS</th>
                                                <th>WS</th>
                                                <th>1</th>
                                                <th>Total</th>
                                                <th>PS</th>
                                                <th>WS</th>
                                            </tr>
                                            <tr>
                                                <th colspan="3">
                                                    <!-- Highest possible score -->
                                                    <p class="text-center">Highest Possible Score</p>
                                                </th>
                                                <!-- Add editable cells -->
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                                <th contenteditable="true"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $student = new Student($conn);
                                            $students = $student->getStudentsBySection($sectionId);

                                            // seprate male and female
                                            $boys = [];
                                            $girls = [];

                                            // display name only on first row
                                            foreach ($students as $student) {
                                                $studentId = $student['student_id'];
                                                $firstName = $student['first_name'];
                                                $lastName = $student['last_name'];
                                                $student_name = $lastName . ', ' . $firstName;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
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
            <!-- Modal content goes here -->
        </div>
        <!-- Modal for editing teacher -->
        <div class="modal fade" id="editTeacherModal" tabindex="-1" aria-labelledby="editTeacherModalLabel"
            aria-hidden="true">
            <!-- Modal content goes here -->
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
    <script src="scripts/viewGrades.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            var table = $('#datatable').DataTable({
                "scrollX": true,
                "paging": false,
                "searching": false,
                "info": false,
                "ordering": false,
                "autoWidth": false,
                "responsive": true,
                "fixedHeader": true,
                "select": true,
                "keys": true,
                "buttons": ['copy', 'excel', 'pdf', 'print']
            });

            $('#datatable tbody').on('click', 'td', function () {
                table.cell(this).edit();
            });
        });
    </script>
</body>

</html>