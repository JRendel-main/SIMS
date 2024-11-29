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
                                <h4 class="page-title">Dashboard</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-sm-6">
                            <!-- Teacher count, add icon and count of teacher-->
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <i class="bi bi-person-lines-fill" style="font-size: 50px; color: #f1b44c;"
                                                data-feather="users" height="50" width="50"></i>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-end">
                                                <h3 class="text-dark mt-1" id="teacherCount">0</h3>
                                                <p class="text-muted mb-1 text-truncate">Teachers</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <!-- Student count -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <i class="bi bi-person-fill" style="font-size: 50px; color: #f1b44c;"
                                                data-feather="users" height="50" width="50"></i>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-end">
                                                <h3 class="text-dark mt-1" id="studentCount">0</h3>
                                                <p class="text-muted mb-1 text-truncate">Students</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <!-- Section count -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <i class="bi bi-person-fill" style="font-size: 50px; color: #f1b44c;"
                                                data-feather="users" height="50" width="50"></i>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-end">
                                                <h3 class="text-dark mt-1" id="sectionCount">0</h3>
                                                <p class="text-muted mb-1 text-truncate">Sections</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <!-- Subject count -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <i class="bi bi-book-fill" style="font-size: 50px; color: #f1b44c;"
                                                data-feather="book" height="50" width="50"></i>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-end">
                                                <h3 class="text-dark mt-1" id="subjectCount">>0</h3>
                                                <p class="text-muted mb-1 text-truncate">Subjects</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Add recent student -->
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Recent Students</h4>
                                    <div class="table-responsive">
                                        <table class="table table-centered table-nowrap table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Student ID</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Grade</th>
                                                    <th scope="col">Section</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $academic = new Academic($conn);
                                                $students = $academic->getRecentStudents();

                                                foreach ($students as $student) {
                                                    echo "<tr>";
                                                    echo "<td>" . $student['student_id'] . "</td>";
                                                    echo "<td>" . $student['first_name'] . " " . $student['last_name'] . "</td>";
                                                    echo "<td>" . $student['grade'] . "</td>";
                                                    echo "<td>" . $student['section_name'] . "</td>";
                                                    echo "</tr>";
                                                }

                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <!-- Display bar chart for attendance of all students -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Attendance</h4>
                                    <div id="attendance-chart" class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div> <!-- container -->

                    </div> <!-- content -->

                    <?php include 'layouts/footer.php'; ?>

                </div>

                <!-- ============================================================== -->
                <!-- End Page content -->
                <!-- ============================================================== -->

            </div>
            <!-- END wrapper -->

            <?php include 'layouts/right-sidebar.php'; ?>

            <?php include 'layouts/footer-scripts.php'; ?>
            <!-- Apex chart cdn -->
            <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>

            <!-- App js -->
            <script src="../assets/js/app.min.js"></script>
            <script src="scripts/index.js"></script>
            <script>
                $(document).ready(function () {
                    $.ajax({
                        type: "GET",
                        url: "controllers/getDashboardCount.php",
                        success: function (response) {
                            var data = JSON.parse(response);
                            $('#teacherCount').text(data.teacherCount);
                            $('#studentCount').text(data.studentCount);
                            $('#subjectCount').text(data.subjectCount);
                            $('#sectionCount').text(data.sectionCount);
                        }
                    });

                    $.ajax({
                        type: "GET",
                        url: "controllers/getAttendanceByMonth.php",
                        success: function (response) {
                            var data = JSON.parse(response);
                            var months = [];
                            var presentDays = [];
                            var schoolDays = [];

                            data.forEach(function (item) {
                                months.push(item.month);
                                presentDays.push(item.present_days);
                                schoolDays.push(item.school_days);
                            });

                            var options = {
                                series: [{
                                    name: 'Present Days',
                                    data: presentDays
                                }, {
                                    name: 'School Days',
                                    data: schoolDays
                                }],
                                chart: {
                                    height: 350,
                                    type: 'bar',
                                },
                                plotOptions: {
                                    bar: {
                                        horizontal: false,
                                        columnWidth: '55%',
                                        endingShape: 'rounded'
                                    },
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    show: true,
                                    width: 2,
                                    colors: ['transparent']
                                },
                                xaxis: {
                                    categories: months,
                                },
                                yaxis: {
                                    title: {
                                        text: 'Days'
                                    }
                                },
                                fill: {
                                    opacity: 1
                                },
                                tooltip: {
                                    y: {
                                        formatter: function (val) {
                                            return val + " days"
                                        }
                                    }
                                }
                            };

                            var chart = new ApexCharts(document.querySelector("#attendance-chart"),
                                options);
                            chart.render();
                        }
                    });
                });
            </script>

</body>

</html>