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
</head>

<body>
    <div class="wrapper">
        <?php include 'layouts/menu.php'; ?>
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Teacher Dashboard</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <span class="float-start m-2 me-4">
                                        <img src="https://ui-avatars.com/api/?name=John+Doe" style="height: 100px;"
                                            alt="avatar-2" class="rounded-circle img-thumbnail" id="profile">
                                    </span>
                                    <div class="float-start">
                                        <h4 class="mt-1 mb-1" id="teacher-name"><?php echo $username ?></h4>
                                        <p class="fs-13" id="teacher-title"><?php echo $category ?></p>
                                        <div class="mt-4">
                                            <h4 class="header-title">
                                                <?php
                                                $teacher = new Academic($conn);
                                                $teacherId = $teacher->getTeacherId($userId);
                                                $academic = new Academic($conn);
                                                $section = $academic->getSection($teacherId);

                                                if (!empty($section)) {
                                                    echo $section['section_name'];
                                                } else {
                                                    echo "No advisory class yet.";
                                                }
                                                ?>
                                            </h4>
                                            <p class="text-muted">Total Students:
                                                <?php
                                                $totalStudents = $academic->getTotalStudents($teacherId);
                                                echo $totalStudents ? $totalStudents : "0";
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-8">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Advisory Class</h4>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-centered table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Section</th>
                                                    <th>Strand</th>
                                                    <th>Subject</th>
                                                    <th>Teacher</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $result = $academic->getSubjectSection($teacherId);

                                                // Ensure $result is not an array before accessing num_rows
                                                if ($result instanceof mysqli_result && $result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td>" . $row['section_name'] . "</td>";
                                                        echo "<td>" . $row['strand_name'] . "</td>";
                                                        echo "<td>" . $row['subject_name'] . "</td>";
                                                        echo "<td>" . $row['teacher_name'] . "</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='4'>No advisory class yet.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include 'layouts/footer.php'; ?>
            </div>
        </div>
        <?php include 'layouts/right-sidebar.php'; ?>
        <?php include 'layouts/footer-scripts.php'; ?>
        <script src="../assets/js/app.min.js"></script>
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
        <script src="scripts/index.js"></script>
    </div>
</body>

</html>