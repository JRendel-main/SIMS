<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>
<?php
include 'controllers/autoloader.php';

$db = new Database();
$conn = $db->connect();

$st_id = $_GET['student_id'];

$student = new Student($conn);
$studentInfo = $student->getStudent($st_id);

$studentName = $studentInfo['last_name'] . ', ' . $studentInfo['first_name'];

$section_id = $studentInfo['section_id'];

$section = new Section($conn);
$sectionInfo = $section->getSection($section_id);

$sectionName = $sectionInfo['section_name'];
?>

<head>
    <title>
        <?php echo $studentName; ?> | <?php echo $sectionName; ?>
    </title>
    <?php include 'layouts/title-meta.php'; ?>

    <?php include 'layouts/head-css.php'; ?>
    <link href=".assets/vendor/fullcalendar/main.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <style>
    /* Styles for printable version */
    @media print {

        /* Hide unnecessary elements */
        .content-page,
        .page-title-right,
        .breadcrumb {
            display: none;
        }

        /* Adjust table styles for printing */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            /* Add borders */
            padding: 8px;
            /* Adjust padding */
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            /* Add background color for header */
        }
    }
    </style>
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">
        <div class="">
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
                                        <div class="col-md-6">
                                            <?php
                                            $student = new Student($conn);
                                            $studentInfo = $student->getStudent($_GET['student_id']);

                                            $studentName = $studentInfo['last_name'] . ', ' . $studentInfo['first_name'];
                                            $section_id = $studentInfo['section_id'];

                                            echo '<h4 class="header-title">' . $studentName . '</h4>';

                                            $section = new Section($conn);
                                            $sectionInfo = $section->getSection($section_id);

                                            echo '<p class="text-muted font-13 mb-2">' . $sectionInfo['section_name'] . '</p>';
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex justify-content-end">
                                                <select class="form-select me-2" id="academic_id" name="academic_id">
                                                    <?php
                                                    $academic = new Academic($conn);
                                                    $schoolYear = $academic->getAllAcademicYear();

                                                    foreach ($schoolYear as $row) {
                                                        echo '<option value="' . $row['academic_year_id'] . '">' . $row['year'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-8">
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
                                        <div class="col-xl-4">
                                            <table class="table table-bordered" id="attendance">
                                                <thead>
                                                    <tr>
                                                        <th>Month</th>
                                                        <th>School Days</th>
                                                        <th>Present Days</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
    <div id="printTable" class="d-none">
        <table id="printTableContent" class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2">Subject Name</th>
                    <th colspan="2">First Semester</th>
                    <th colspan="2">Second Semester</th>
                    <th rowspan="2">Final Grade</th>
                </tr>
                <tr>
                    <th>1st Quarter</th>
                    <th>2nd Quarter</th>
                    <th>3rd Quarter</th>
                    <th>4th Quarter</th>
                </tr>
            </thead>
            <tbody id="printTableBody">
                <!-- Table body will be populated dynamically -->
            </tbody>
        </table>
    </div>



    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <!-- END wrapper -->

    <?php include 'layouts/right-sidebar.php'; ?>

    <?php include 'layouts/footer-scripts.php'; ?>

    <!-- App js -->
    <script src=".assets/js/app.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.11/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js"></script>
    <script src="assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
    <script src="assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="assets/vendor/datatables.net-select/js/dataTables.select.min.js"></script>
    <script>
    $(document).ready(() => {
        // event listener for academic year
        $('#academic_id').on('change', function() {

            $.ajax({
                type: "POST",
                url: "teacher/controllers/getStudentAttendance.php",
                data: {
                    student_id: <?php echo $_GET['student_id']; ?>,
                    academic_id: $('#academic_id').val()
                },
                success: function(response) {
                    response = JSON.parse(response);
                    $('#attendance').DataTable().clear().destroy();
                    $('#attendance').DataTable({
                        data: response,
                        columns: [{
                                data: 'month',
                            },
                            {
                                data: 'school_days',
                            },
                            {
                                data: 'present_days',
                            }
                        ],
                        // remove the show entries, search, info, pagination and make the table smaller
                        "lengthMenu": [
                            [5, 10, 25, 50, -1],
                            [5, 10, 25, 50, "All"]
                        ],
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "autoWidth": true,
                        "responsive": true,
                        "scrollX": true,
                        "scrollY": '50vh',
                        "scrollCollapse": true,
                        "pagingType": 'simple',
                        "fixedHeader": true,
                    });
                }
            });
            let academic_id = $(this).val();
            $.ajax({
                type: "POST",
                url: "teacher/controllers/getStudentGrades.php",
                data: {
                    student_id: <?php echo $_GET['student_id']; ?>,
                    academic_id: academic_id
                },
                success: function(response) {
                    response = JSON.parse(response);
                    $('#student_lists').DataTable().clear().destroy();
                    $('#student_lists').DataTable({
                        data: response,
                        columns: [{
                                data: 'subject_name'
                            },
                            {
                                data: function(row) {
                                    return row.grades[0] ? row.grades[0]
                                        .final_grade :
                                        '';
                                }
                            },
                            {
                                data: function(row) {
                                    return row.grades[1] ? row.grades[1]
                                        .final_grade :
                                        '';
                                }
                            },
                            {
                                data: function(row) {
                                    return row.grades[2] ? row.grades[2]
                                        .final_grade :
                                        '';
                                }
                            },
                            {
                                data: function(row) {
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
                                render: function(data) {
                                    return data == 'Passed' ?
                                        '<span class="badge bg-success">Passed</span>' :
                                        '<span class="badge bg-danger">Failed</span>';
                                }
                            }
                        ],
                        "order": [
                            [0, "asc"]
                        ],
                        // remove the show entries, search, info, pagination and make the table smaller
                        "lengthMenu": [
                            [5, 10, 25, 50, -1],
                            [5, 10, 25, 50, "All"]
                        ],
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "autoWidth": true,
                        "responsive": true,
                        "scrollX": true,
                        "scrollY": '50vh',
                        "scrollCollapse": true,
                        "pagingType": 'simple',
                        "fixedHeader": true,
                        // add print button
                        dom: 'Bfrtip',
                        buttons: [{
                            extend: 'print',
                            text: 'Print',
                            className: 'btn btn-info',

                        }]
                    });
                }
            });
        });


        $.ajax({
            type: "POST",
            url: "teacher/controllers/getStudentGrades.php",
            data: {
                student_id: <?php echo $_GET['student_id']; ?>
            },
            success: function(response) {
                response = JSON.parse(response);
                $('#student_lists').DataTable({
                    data: response,
                    columns: [{
                            data: 'subject_name'
                        },
                        {
                            data: function(row) {
                                return row.grades[0] ? row.grades[0].final_grade :
                                    '';
                            }
                        },
                        {
                            data: function(row) {
                                return row.grades[1] ? row.grades[1].final_grade :
                                    '';
                            }
                        },
                        {
                            data: function(row) {
                                return row.grades[2] ? row.grades[2].final_grade :
                                    '';
                            }
                        },
                        {
                            data: function(row) {
                                return row.grades[3] ? row.grades[3].final_grade :
                                    '';
                            }
                        },
                        {
                            data: 'final_grade'
                        },
                        {
                            data: 'remarks',
                            render: function(data) {
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


    })
    </script>

</body>

</html>