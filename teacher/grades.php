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

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container -->
            </div> <!-- content -->
        </div>
        <!-- End Page content -->
        <!-- ============================================================== -->
        <!-- END wrapper -->

        <!-- Add Component Modal -->
        <!-- Edit Grades Modal -->
        <div class="modal fade" id="editGradesModal" tabindex="-1" aria-labelledby="editGradesModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editGradesModalLabel">Edit Final Grade</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editGradesForm">
                            <input type="hidden" id="grades_id" name="grades_id">
                            <input type="hidden" id="student_id" name="student_id">
                            <input type="hidden" id="semester" name="semester">
                            <input type="hidden" id="subject_id" name="subject_id">
                            <div class="mb-3">
                                <label for="final_grade" class="form-label">Final Grade</label>
                                <input type="text" class="form-control" id="final_grade" name="final_grade">
                            </div>
                            <button type="button" class="btn btn-primary" id="editGradesSubmit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


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
                url: 'controllers/getStudentGrades.php',
                type: 'POST',
                data: {
                    section_id: <?php echo $section_id; ?>,
                    subject_id: <?php echo $subject_id; ?>,
                },
                success: function(data) {
                    var data = JSON.parse(data);
                    var semester = data[0]['semester']
                    var section_id = <?php echo $section_id; ?>;
                    var subject_id = <?php echo $subject_id; ?>;

                    var table = $('#gradesTable').DataTable({
                        data: data,
                        columns: [
                            {
                                title: 'Student #',
                                data: 'student_id',
                                createdCell: function(td) {
                                    td.style.width = "10%"; // Adjust width for this column
                                }
                            },
                            {
                                title: 'Student Name',
                                data: 'student_name',
                                createdCell: function(td) {
                                    td.style.width = "40%"; // Adjust width for this column
                                }
                            },
                            {
                                title: 'Final Grade',
                                data: 'final_grade',
                                createdCell: function(td) {
                                    td.style.width = "10%"; // Adjust width for this column
                                }
                            },
                            {
                                title: 'Remarks',
                                data: 'remarks',
                                createdCell: function(td) {
                                    td.style.width = "10%"; // Adjust width for this column
                                }
                            },
                            {
                                title: 'Action',
                                data: 'student_id',
                                createdCell: function(td) {
                                    td.style.width = "40%"; // Adjust width for this column
                                },
                                render: function(data, type, row) {
                                    return `
                                        <button class="btn btn-info btn-sm edit-grades" 
                                                data-student-id="${data}" 
                                                data-semester="${semester}" 
                                                data-subject-id="${subject_id}" 
                                                data-grades_id="${row.grades_id}"
                                                data-final-grade="${row.final_grade}"
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="Edit Grades" 
                                                style="margin-right: 5px;">
                                            <i class="bi bi-pencil"></i>
                                            Edit Grades
                                        </button>
                                    `;
                                }
                            }
                        ],
                        order: [1, 'asc'],
                        responsive: true,
                        fixedHeader: true,
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

                // Get grade_id, semester, and subject_id from the button's data attributes
                var grades_id = $(this).data('grades_id');
                var student_id = $(this).data('student-id');  // If needed
                var semester = $(this).data('semester');      // If needed
                var subject_id = $(this).data('subject-id');  // If needed
                var final_grade = $(this).data('final-grade');  // If needed


                // Open the modal
                $('#editGradesModal').modal('show');

                // Set the grade_id and other data in the modal inputs, if necessary
                $('#grades_id').val(grades_id); 
                $('#student_id').val(student_id); 
                $('#semester').val(semester);     
                $('#subject_id').val(subject_id);
                $('#final_grade').val(final_grade);

                console.log(final_grade)


            
                // Handle form submission inside the modal
                $('#editGradesSubmit').on('click', function() {
                    // Get the final grade from the input
                    var final_grade = $('#final_grade').val();

                    // AJAX request to submit data
                    $.ajax({
                        url: 'controllers/edit-grades.php',
                        type: 'POST',
                        data: {
                            grades_id: grades_id,
                            final_grade: final_grade,
                            student_id: student_id, 
                            semester: semester,       
                            subject_id: subject_id  
                        },
                        success: function(response) {
                            $('#editGradesModal').modal('hide'); // Hide the modal

                            // Show SweetAlert
                            Swal.fire({
                                title: 'Success!',
                                text: 'The grade has been updated successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Refresh the DataTable
                                    location.reload();
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred: ' + error,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });
            });


        })
        </script>



    </body>

    </html>