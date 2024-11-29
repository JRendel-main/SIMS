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
                            <div class="page-title-box d-flex justify-content-between align-items-center">
                                <h4 class="page-title">Student Lists</h4>
                                <button class="btn btn-info btn-sm" id="sendQR">
                                    <!-- Send students grade link to all students -->
                                    Send Grades link to all Students

                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Student Lists</h4>
                                    <table id="student_lists" class="table dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Student #</th>
                                                <th>Learner's Name</th>
                                                <th>Actions</th>
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
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <!-- END wrapper -->

    <?php include 'layouts/right-sidebar.php'; ?>

    <?php include 'layouts/footer-scripts.php'; ?>

    <!--   App js -->
    <script src="../assets/js/app.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.11/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/ve ndor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="../assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js"></script>
    <script src="../    assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../  assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
    <script src="../assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../assets/vendor/datatables.net-select/js/dataTables.select.min.js"></script>
    <script src="../assets/vendor/qrcode/qrcode.js"></script>
    <script>
    $(document).ready(() => {
        $.ajax({
            type: "POST",
            url: "controllers/getAllStudents.php",
            data: {
                teacher_id: <?php echo $teacher_id; ?>
            },
            success: function(response) {
                var response = JSON.parse(response);

                $('#student_lists').DataTable({
                    data: response,
                    columns: [{
                            data: 'student_id'
                        },
                        {
                            data: 'learner_name'
                        },
                        {
                            data: 'student_id',
                            render: function(data, type, row) {
                                return `<a href="student-grade.php?student_id=${data}" class="btn btn-info">
                                <i class="bi bi-eye"></i>
                                </a>
                                <a href="student-attendance.php?student_id=${data}" class="btn btn-success">
                                <i class="bi bi-calendar"></i>
                                </a>
                                `;
                            }
                        },
                    ],
                    "order": [
                        [2, "asc"]
                    ]
                });
            }
        });
    })

    $('#sendQR').click(() => {
        // Add confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to send QR grades to all students. This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, send it!'
        }).then(async (result) => {
            if (result.isConfirmed) {
                // Disable the button and show loading animation
                $('#sendQR').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...'
                ).prop('disabled', true);

                // Send request to send QR grades
                try {
                    const response = await $.ajax({
                        type: "POST",
                        url: "controllers/getStudentEmail.php",
                        data: {
                            teacher_id: <?php echo $teacher_id; ?>
                        }
                    });

                    const studentEmails = JSON.parse(response);

                    for (const student of studentEmails) {
                        const student_id = student.student_id;
                        const email = student.email;

                        await new Promise((resolve, reject) => {
                            $.ajax({
                                type: "POST",
                                url: "controllers/sendEmail.php",
                                data: {
                                    student_id: student_id,
                                    email: email
                                },
                                success: function(response) {
                                    const responseData = JSON.parse(response);

                                    if (responseData.status == 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: responseData.message
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: responseData.message
                                        });
                                    }
                                    resolve
                                        (); // Resolve the promise after each AJAX request completes
                                },
                                error: function(xhr, status, error) {
                                    reject(
                                        error
                                    ); // Reject the promise if there's an error
                                }
                            });
                        });
                    }

                    // Re-enable the button and revert its text
                    $('#sendQR').html('Send QR Grades to all Students').prop('disabled', false);
                } catch (error) {
                    console.error(error);
                    // Handle error here
                }
            }
        })
    });
    </script>
</body>

</html>