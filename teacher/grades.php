<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>
<d?php if (!isset($_SESSION['login'])) { header('Location: ../index.php'); } if ($_SESSION['role'] !='teacher' ) {
    header('Location: ../admin/index.php'); } ?>

    <head>
        <title>Teacher Dashboard | Admin Portal</title>
        <?php include 'layouts/title-meta.php'; ?>

        <?php include 'layouts/head-css.php'; ?>
        <link href="../assets/vendor/fullcalendar/main.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet"
            type="text/css" />
        <link href="../assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet"
            type="text/css" />
        <link href="../assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css"
            rel="stylesheet" type="text/css" />
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
            <?php

            $section = new Section($conn);
            $subject = new Subject($conn);

            $section_id = $_GET['section_id'];
            $subject_id = $_GET['subject_id'];

            $sectionInfo = $section->getSection($section_id);
            $subjectInfo = $subject->getSubject($subject_id);

            $sectionName = $sectionInfo['section_name'];
            $subjectName = $subjectInfo['subject_name'];
            ?>
            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <buton class="btn btn-success" id="addGrade">
                                            <i class="bi bi-plus"></i>
                                            Add Student
                                        </buton>
                                    </div>
                                    <h4 class="page-title">
                                        <?php
                                        echo $sectionName . ' - ' . $subjectName;
                                        ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <table id="gradesTable" class="table table-centered table-bordered"
                                        style="width: 100%;">
                                        <thead>
                                        </thead>
                                        <tbody>
                                            <!-- Data will be fetched using AJAX -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container -->
            </div> <!-- content -->
        </div>

        <!-- Select Quarter Modal -->
        <div class="modal fade" id="selectQuarterModal" tabindex="-1" aria-labelledby="selectQuarterModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="selectQuarterModalLabel">Select Quarter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <select class="form-select" id="quarter" aria-label="Select Quarter">
                                <option selected disabled>Select Quarter</option>
                                <?php
                                $academic = new Academic($conn);
                                $semester = $academic->getSemester();
                                foreach ($semester as $sem) {
                                    echo '<option value="' . $sem['semester_id'] . '">' . $sem['Quarter'] . ' Grading (' . $sem['semester_name'] . ')</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <select class="form-select" id="academic" aria-label="Select Academic Year">
                                <option selected disabled>Select Academic Year</option>
                                <?php
                                $academic = new Academic($conn);
                                $academics = $academic->getAllAcademicYear();
                                foreach ($academics as $acad) {
                                    echo '<option value="' . $acad['academic_year_id'] . '">' . $acad['year'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="selectQuarter">Select</button>
                    </div>
                </div>
            </div>
        </div>
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
        $(document).ready(function() {
            // Initialize Bootstrap tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            $.ajax({
                url: 'controllers/getStudents.php',
                type: 'POST',
                data: {
                    section_id: <?php echo $section_id; ?>,
                    subject_id: <?php echo $subject_id; ?>
                },
                success: function(data) {
                    var data = JSON.parse(data);
                    var gender = data.gender;

                    var table = $('#gradesTable').DataTable({
                        data: data,
                        columns: [{
                                title: 'Student #',
                                data: 'student_id'
                            },
                            {
                                title: 'Student Name',
                                data: 'student_name'
                            },
                            {
                                title: 'Gender',
                                data: 'gender'
                            },
                            {
                                title: 'Action',
                                data: 'student_id',
                                render: function(data) {
                                    return `
                                        <a href="#" class="btn btn-info btn-sm edit-grades" data-student-id="${data}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Grades">
                                            <i class="bi bi-pencil"></i>
                                            Edit Grades
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm delete-grades" data-student-id="${data}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Grades">
                                            <i class="bi bi-trash"></i>
                                            Delete Student
                                        </a>
                                    `;
                                }
                            }
                        ],
                        order: [1, 'asc'],
                        responsive: true,
                        fixedHeader: true,
                        buttons: ['copy', 'excel', 'pdf', 'print'],
                        // make the student id smaller
                        columnDefs: [{
                            targets: 0,
                            width: '5%'
                        }]
                    });
                }
            });

            $('#gradesTable').on('click', '.edit-grades', function(e) {
                e.preventDefault();
                var studentId = $(this).data('student-id');

                // open select modal
                $('#selectQuarterModal').modal('show');
                $('#selectQuarter').on('click', function() {
                    // get the select
                    var quarterId = $('#quarter').val();
                    var academicId = $('#academic').val();

                    var quarterId =
                        window.location.href = 'edit_grades.php?student_id=' + studentId +
                        '&section_id=<?php echo $section_id; ?>&subject_id=<?php echo $subject_id; ?>&quarter_id=' +
                        quarterId + '&academic_id=' + academicId;
                })
            });

            $('#gradesTable').on('click', '.delete-grades', function(e) {
                e.preventDefault();
                var studentId = $(this).data('student-id');
                // Redirect to delete grades page with student id as parameter
                window.location.href = 'delete_grades.php?student_id=' + studentId +
                    '&section_id=<?php echo $section_id; ?>&subject_id=<?php echo $subject_id; ?>';
            });
        })
        </script>



    </body>

    </html>