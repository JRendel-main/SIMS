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
    <link href="../assets/vendor/fullcalendar/main.min.css" rel="stylesheet" type="text/css" />
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
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Student Lists</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <h4 class="header-title">Grades Lists</h4>
                                        <p class="text-muted font-13 mb-4">
                                            List of grades of the student.
                                        </p>
                                        <select class="form-select" id="academic_id" name="academic_id">
                                            <option value="0">Select Academic Year</option>
                                            <?php
                                            $academic = new Academic($conn);
                                            $schoolYear = $academic->getAllAcademicYear();

                                            foreach ($schoolYear as $row) {
                                                echo '<option value="' . $row['academic_year_id'] . '">' . $row['year'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <table id="student_lists" class="table dt-responsive table-bordered w-100">
                                        <thead>
                                            <tr>
                                                <th>Subject Name</th>
                                                <th>First Quarter</th>
                                                <th>Second Quarter</th>
                                                <th>Third Quarter</th>
                                                <th>Fourth Quarter</th>
                                                <th>Final Grade</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <!-- END wrapper -->

    <?php include 'layouts/right-sidebar.php'; ?>

    <?php include 'layouts/footer-scripts.php'; ?>

    <!-- App js -->
    <script src="../assets/js/app.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.11/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <script>
        $(document).ready(() => {
            // event listener for academic year
            $('#academic_id').on('change', function () {
                let academic_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "controllers/getStudentGrades.php",
                    data: {
                        student_id: <?php echo $_GET['student_id']; ?>,
                        academic_id: academic_id
                    },
                    success: function (response) {
                        response = JSON.parse(response);
                        $('#student_lists').DataTable().clear().destroy();
                        $('#student_lists').DataTable({
                            data: response,
                            columns: [{
                                data: 'subject_name'
                            },
                            {
                                data: function (row) {
                                    return row.grades[0] ? row.grades[0]
                                        .final_grade :
                                        '';
                                }
                            },
                            {
                                data: function (row) {
                                    return row.grades[1] ? row.grades[1]
                                        .final_grade :
                                        '';
                                }
                            },
                            {
                                data: function (row) {
                                    return row.grades[2] ? row.grades[2]
                                        .final_grade :
                                        '';
                                }
                            },
                            {
                                data: function (row) {
                                    return row.grades[3] ? row.grades[3]
                                        .final_grade :
                                        '';
                                }
                            },
                            {
                                data: 'final_grade'
                            },
                            {
                                data: 'remarks',
                                render: function (data) {
                                    return data == 'Passed' ?
                                        '<span class="badge bg-success">Passed</span>' :
                                        '<span class="badge bg-danger">Failed</span>';
                                }
                            }
                            ],
                            "order": [
                                [0, "asc"]
                            ]
                        });
                    }
                });
            });



        })
    </script>

</body>

</html>