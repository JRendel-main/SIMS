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
                                <h4 class="page-title">Student Attendance</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="row">
                                                <h4 class="header-title">Student Attendance Management</h4>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#addAttendanceModal">
                                                    Add Attendance
                                                </button>
                                                <p class="text-muted font-13 mb-4">
                                                    View student attendance by selecting the academic year.
                                                </p>
                                            </div>
                                        </div>
                                        <!-- <h4 class="header-title">Student Attendance Management</h4>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#addAttendanceModal">
                                            Add Attendance
                                        </button>
                                        <p class="text-muted font-13 mb-4">
                                            View student attendance by selecting the academic year.
                                        </p> -->
                                        <select class="form-select" id="academic_id" name="academic_id">
                                            <option value="" diabled>Select Academic Year</option>
                                            <?php
                                            $academic = new Academic($conn);
                                            $schoolYear = $academic->getAllAcademicYear();

                                            foreach ($schoolYear as $row) {
                                                echo '<option value="' . $row['academic_year_id'] . '">' . $row['year'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <table id="attendance" class="table dt-responsive table-bordered w-100">
                                        <thead>
                                            <tr>
                                                <td>Month</td>
                                                <td>No. of School Days</td>
                                                <td>No. of Present Days</td>
                                                <td>Actions</td>
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


    <!-- Add attendnace modal -->
    <div class="modal fade" id="addAttendanceModal" tabindex="-1" aria-labelledby="addAttendanceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAttendanceModalLabel">Add Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" name="student_id" value="<?php echo $_GET['student_id']; ?>">
                        <div class="mb-3">
                            <label for="academic_id" class="form-label">Academic Year</label>
                            <select class="form-select" id="academic_id" name="academic_id">
                                <option value="0" disabled>Select Academic Year</option>
                                <?php
                                $academic = new Academic($conn);
                                $schoolYear = $academic->getAllAcademicYear();

                                foreach ($schoolYear as $row) {
                                    echo '<option value="' . $row['academic_year_id'] . '">' . $row['year'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="month" class="form-label">Month</label>
                            <select class="form-select" id="month" name="month">
                                <option value="0" disabled>Select Month</option>
                                <option value="8">Aug</option>
                                <option value="9">Sep</option>
                                <option value="10">Oct</option>
                                <option value="11">Nov</option>
                                <option value="12">Dec</option>
                                <option value="1">Jan</option>
                                <option value="2">Feb</option>
                                <option value="3">Mar</option>
                                <option value="4">Apr</option>
                                <option value="5">May</option>
                                <option value="6">Jun</option>
                                <option value="7">Jul</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="school_days" class="form-label">No. of School Days</label>
                            <input type="number" class="form-control" id="school_days" name="school_days">
                        </div>
                        <div class="mb-3">
                            <label for="present_days" class="form-label">No. of days present</label>
                            <input type="number" class="form-control" id="present_days" name="present_days">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Attendance</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'layouts/right-sidebar.php'; ?>

    <?php include 'layouts/footer-scripts.php'; ?>

    <!-- App js -->
    <script src="../assets/js/app.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.11/index.global.min.js'>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js">
    </script>
    <script src="../assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js">
    </script>
    <script src="../assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js">
    </script>
    <script src="../assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js">
    </script>
    <script src="../assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js">
    </script>
    <script src="../assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js">
    </script>
    <script src="../assets/vendor/datatables.net-select/js/dataTables.select.min.js"></script>
    <script>
    $(document).ready(() => {
        // event listener for academic year
        $('#academic_id').on('change', function() {
            let academic_id = $(this).val();

            $.ajax({
                type: "POST",
                url: "controllers/getStudentAttendance.php",
                data: {
                    student_id: <?php echo $_GET['student_id']; ?>,
                    academic_id: academic_id
                },
                success: function(response) {
                    var response = JSON.parse(response);

                    var table = $('#attendance').DataTable({
                        destroy: true,
                        data: response,
                        columns: [{
                                data: 'month'
                            },
                            {
                                data: 'school_days'
                            },
                            {
                                data: 'present_days'
                            },
                            {
                                data: null,
                                render: function(data, type, row) {
                                    return `<button class="btn btn-danger">Delete</button>`;
                                }
                            },
                        ],
                        // remove all buttons
                        dom: 'Bfrtip',
                        buttons: [],
                        // remove sorting
                        "order": [],
                        "columnDefs": [{
                            "targets": [3],
                            "orderable": false
                        }],
                        // remove search, pagination,text
                        "paging": false,
                        "searching": false,
                        "info": false
                    });
                }
            });
        });

        // event listener for add attendance
        $('#addAttendanceModal form').on('submit', function(e) {
            e.preventDefault();

            // serialized the form 
            let formData = $(this).serialize();

            let school_days = $('#school_days').val();
            let present_days = $('#present_days').val();

            // if present days is greater than school days
            if (parseInt(present_days) > parseInt(school_days)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Present days cannot be greater than school days'
                });
                return;
            }

            $.ajax({
                type: "POST",
                url: "controllers/addAttendance.php",
                data: formData,
                success: function(response) {
                    response = JSON.parse(response);

                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                }
            });
        });
    })
    </script>

</body>

</html>