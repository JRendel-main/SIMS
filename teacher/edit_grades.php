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
        <?php
        // Check if student_id and subject_id are set
        if (!isset($_GET['student_id']) || !isset($_GET['subject_id'])) {
            header('Location: some-error-page.php'); // Redirect to an error page
        }

        $student_id = $_GET['student_id'];
        $subject_id = $_GET['subject_id'];

        $student = new Student($conn);
        $grade = new Grades($conn);
        $gradeComponent = $grade->getGradeComponent($subject_id);
        $studentDetails = $student->getStudent($student_id);
        $studentName = $studentDetails['last_name'] . ', ' . $studentDetails['first_name'] . ' ' . $studentDetails['middle_name'];
        ?>
        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">

                                <h4 class="page-title">
                                    <?php echo $studentName; ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card">
                            <div class="card-header text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3 text-left">
                                            <?php
                                            $academic = new Academic($conn);
                                            $semester = $academic->getSemester();

                                            $semesterId = $_GET['quarter_id'];
                                            $semesterName = $academic->getSemesterId($semesterId);
                                            $academic_year = $academic->getAcademicYear($_GET['academic_id']);

                                            echo '<h2 class="text-dark">' . $academic_year['year'] . ' - ' . $semesterName['Quarter'] . ' Quarter</h2>';
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Add grades modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#addGradesModal">
                                            <i class="bi bi-plus"></i>
                                            Add Grades
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <?php
                                        $grade = new Grades($conn);
                                        $grades = $grade->getGradesForStudentAndSubject($student_id, $subject_id, $_GET['quarter_id'], $_GET['academic_id']);

                                        $totalHG = 0;
                                        $totalIG = 0;
                                        $weightedScore = 0;
                                        $gradeNumber = 0;

                                        $totalGrades = 0;
                                        // create a table for each grade component
                                        foreach ($gradeComponent as $gc) {
                                            echo '<h5>' . $gc['component_name'] . ' - ' . $gc['weight'] . '%</h5>';
                                            echo '<table class="table table-bordered" id="gradesTable">';
                                            echo '<thead class="table-success">';
                                            echo '<tr>';
                                            // count every grades in the grade component
                                            $count = 1;
                                            foreach ($grades as $grade) {
                                                if ($grade['component_id'] == $gc['component_id']) {
                                                    $count++;
                                                }
                                            }
                                            echo '<th colspan="' . $count . '">Grade Factor</th>';
                                            echo '<th>Total</th>';
                                            echo '<th scope="col">Percentage Score</th>';
                                            echo '<th scope="col">Weighted Score</th>';
                                            echo '</tr>';
                                            echo '<tr>';
                                            echo '</thead>';
                                            echo '<tbody>';
                                            // displayt every initial grade
                                            echo '<tr>';
                                            echo '<td><b>Highest </b></td>';
                                            foreach ($grades as $grade) {
                                                // display only what is in the grade component
                                                if ($grade['component_id'] == $gc['component_id']) {
                                                    echo '<td>' . $grade['highest_grade'] . '</td>';
                                                    $totalHG += $grade['highest_grade'];
                                                }
                                            }
                                            echo '<td>' . $totalHG . '</td>';
                                            // convert the totalHG to percentage based on the every grade and the total
                                            if ($totalHG == 0 && $totalHG == 0) {
                                                $percentage = 0;
                                            } else {
                                                $percentage = ($totalHG / $totalHG) * 100;
                                            }
                                            echo '<td>' . $percentage . '%</td>';
                                            $weightScore = $percentage * (0.01 * $gc['weight']);
                                            // round off the weighted score to 2 decimal places
                                            $weightScore = round($weightScore, 2);
                                            echo '<td>' . $weightScore . '%</td>';
                                            echo '</tr>';
                                            echo '<tr>';
                                            echo '<td><b>Initial Grade</b></td>';
                                            foreach ($grades as $grade) {
                                                // display only what is in the grade component
                                                if ($grade['component_id'] == $gc['component_id']) {
                                                    echo '<td class="initial-grade" data-grade-id="' . $grade['grades_id'] . '">' . $grade['initial_grade'] . '</td>';
                                                    $totalIG += $grade['initial_grade'];
                                                }
                                            }
                                            echo '<td>' . $totalIG . '</td>';
                                            // convert the totalIG to percentage based on the every grade and the total
                                            if ($totalIG == 0 && $totalHG == 0) {
                                                $percentage = 0;
                                            } else {
                                                $percentage = ($totalIG / $totalHG) * 100;
                                            }
                                            // round off the percentage to 2 decimal places
                                            $percentage = round($percentage, 2);
                                            echo '<td>' . $percentage . '%</td>';
                                            // display the final grade weighted by the percentage
                                            $weightScore = $percentage * (0.01 * $gc['weight']);
                                            // show only 2 decimal places dont round off
                                            if ($percentage > 74) {
                                                echo '<td class="table-success">' . $percentage . '%</td>';
                                            } else {
                                                echo '<td class="table-danger">' . $percentage . '%</td>';
                                            }
                                            echo '</tr>';
                                            echo '</tbody>';
                                            echo '</table>';

                                            $totalGrades += $weightScore;

                                            // reset the totalHG and totalIG
                                            $totalHG = 0;
                                            $totalIG = 0;
                                        }

                                        // get the grade number
                                        if ($totalGrades <= 75) {
                                            $gradeNumber = '<span class="badge bg-danger">Failed</span>';
                                        } else {
                                            $gradeNumber = '<span class="badge bg-success">Passed</span>';
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <h5>Final Grade</h5>
                                        <table class="table table-stripped text-center">
                                            <thead class="
                                                table-dark
                                            ">
                                                <tr>
                                                    <th>Initial Grade</th>
                                                    <th>Quarterly Grade</th>
                                                    <th>Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php
                                                    $roundedRawGrades = round($totalGrades, 2);
                                                    echo $roundedRawGrades; ?>%</td>
                                                    <td>
                                                        <?php
                                                        $roundedGrades = round($totalGrades);
                                                        echo $roundedGrades;

                                                        ?>
                                                    </td>
                                                    <td><?php echo $gradeNumber; ?></td>
                                                    <?php
                                                    $grade = new Grades($conn);
                                                    $grade->submitFinalGrade($student_id, $subject_id, $_GET['quarter_id'], $_GET['academic_id'], $roundedGrades);
                                                    ?>
                                                </tr>
                                            </tbody>
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

    <!-- Add Grades Modal -->
    <div class="modal fade" id="addGradesModal" tabindex="-1" aria-labelledby="addGradesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="addGradesForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addGradesModalLabel">Add Grades</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="academic_year">Academic Year</label>
                            <select class="form-select" id="academic_year" name="academic_year">
                                <?php
                                $academic = new Academic($conn);
                                $academicYear = $academic->getAllAcademicYear();
                                foreach ($academicYear as $year) {
                                    echo '<option value="' . $year['academic_year_id'] . '">' . $year['year'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="gradeComponent" class="form-label">Quarter</label>
                            <select class="form-select" id="quarter" name="semester_id">
                                <?php
                                foreach ($semester as $sem) {
                                    echo '<option value="' . $sem['semester_id'] . '">' . $sem['Quarter'] . ' Grading (' . $sem['semester_name'] . ')</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="gradeComponent" class="form-label">Grade Component</label>
                            <select class="form-select" id="gradeComponent" name="component_id">
                                <?php
                                foreach ($gradeComponent as $gc) {
                                    echo '<option value="' . $gc['component_id'] . '">' . $gc['component_name'] . ' - ' . $gc['weight'] . '%</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="highestGrade" class="form-label">Highest Possible Grade</label>
                            <input type="number" class="form-control" id="highestGrade" name="highest_grade" required>
                        </div>
                        <div class="mb-3">
                            <label for="grade" class="form-label">Grade</label>
                            <input type="number" class="form-control" id="grade" name="initial_grade" required>
                        </div>
                        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                        <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Grade</button>
                    </div>
                </form>
            </div>
        </div>
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
        $(document).ready(function () {
            $('.initial-grade').click(function () {
                var gradeId = $(this).data('grade-id');

                // Open a SweetAlert prompt for confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User confirmed deletion, send AJAX request to delete the grade
                        $.ajax({
                            type: 'POST',
                            url: 'controllers/delete-grade.php',
                            data: {
                                grade_id: gradeId
                            },
                            success: function (response) {
                                var data = JSON.parse(response);
                                if (data.status === 'success') {
                                    // Grade deleted successfully, show success message
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: 'The grade has been deleted.',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        // Reload the page
                                        location.reload();
                                    });
                                } else {
                                    // Error deleting grade, show error message
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong! Please try again.'
                                    });
                                }
                            }
                        });
                    }
                });
            });
            $('#addGradesForm').submit(function (e) {
                e.preventDefault();

                // add validation, the grades cannot be greater than the highest grade
                var highestGrade = $('#highestGrade').val();
                var grade = $('#grade').val();

                if (parseInt(grade) > parseInt(highestGrade)) {
                    // use bootstrap validation form
                    $('#highestGrade').addClass('is-invalid');
                    $('#grade').addClass('is-invalid');

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Grade cannot be greater than the highest grade'
                    });
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: 'controllers/add-grades.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        var response = JSON.parse(response);
                        if (response.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Grade added successfully'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred. Please try again'
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>