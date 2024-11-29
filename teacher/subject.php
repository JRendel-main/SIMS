<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>
<p?php if (!isset($_SESSION['login'])) { header('Location: ../index.php'); } if ($_SESSION['role'] !='teacher' ) {
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
            <div class="content-page">
                <div class="content">

                    <?php
                    //check if there is get request
                    if (isset($_GET['section_id'])) {
                        $section = new Section($conn);
                        $sectionId = $_GET['section_id'];

                        $section = $section->getSection($sectionId);
                        $strand_id = $section['strand_id'];

                        $subject = new Subject($conn);
                        $subjectDetails = $subject->getSubject($_GET['subjectId']);

                    }
                    ?>
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
                                    <h4 class="page-title">
                                        <?php
                                        echo $subjectDetails['subject_name'] . ' - ' . $section['section_name'];
                                        ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#addComponentModal">
                                        <i class="bi bi-plus"></i> Add Component
                                    </button>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Grades Components</h4>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Component Name</th>
                                                        <th>Weight (%)</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $grades = new grades($conn);
                                                    $gradeComponents = $grades->getGradeComponent($_GET['subjectId']);
                                                    if ($gradeComponents) {
                                                        foreach ($gradeComponents as $component) {
                                                            echo '<tr>
                                                                    <td>' . $component['component_name'] . '</td>
                                                                    <td>' . $component['weight'] . '</td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-sm btn-danger delete-component" data-component-id="' . $component['component_id'] . '">
                                                                            Delete
                                                                        </button>
                                                                    </td>
                                                                </tr>';
                                                        }
                                                    } else {
                                                        // Use alert bootstrap
                                                        echo '<tr>
                                                                <td colspan="3" class="text-center">No data found</td>
                                                            </tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php
                                        // Calculate the total weight and check if it equals 100
                                        if ($gradeComponents) {
                                            $totalWeight = array_reduce($gradeComponents, function ($carry, $item) {
                                                return $carry + $item['weight'];
                                            }, 0);

                                            if ($totalWeight != 100) {
                                                echo '<div class="alert alert-danger" role="alert">
                                                        Total weight should be 100%
                                                    </div>';

                                            }
                                        }
                                        ?>
                                        <div class="mb-3">
                                            <button type="button" class="btn btn-info waves-effect waves-light">
                                                Next <i class="bi bi-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div> <!-- container -->
            </div> <!-- content -->
        </div>

        <!-- Add Component Modal -->
        <div class="modal fade" id="addComponentModal" tabindex="-1" role="dialog"
            aria-labelledby="addComponentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addComponentModalLabel">Add Component</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="addComponentForm">
                        <div class="modal-body">
                            <input type="hidden" id="subjectId">
                            <div class="mb-3">
                                <label for="componentName" class="form-label">Component Name</label>
                                <input type="text" class="form-control" id="componentName" required>
                            </div>
                            <div class="mb-3">
                                <label for="weight" class="form-label">Weight (%)</label>
                                <input type="number" class="form-control" id="weight" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Component</button>
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
        <!-- <script src="scripts/subject.js"></script> -->
        <script>
        $(document).ready(() => {
            $('#addComponentForm').submit((e) => {
                e.preventDefault();
                let subjectId = <?php echo $_GET['subjectId']; ?>;
                let componentName = $('#componentName').val();
                let weight = $('#weight').val();

                $.ajax({
                    type: 'POST',
                    url: 'controllers/addComponent.php',
                    data: {
                        subject_id: subjectId,
                        component: componentName,
                        percentage: weight
                    },
                    success: function(response) {
                        let data = JSON.parse(response);
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.message,
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message,
                            });
                        }
                    }
                });
            });
            // Delete component
            $('.delete-component').click(function() {
                let componentId = $(this).data('component-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this component!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: 'controllers/deleteComponent.php',
                            data: {
                                component_id: componentId
                            },
                            success: function(response) {
                                let data = JSON.parse(response);
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: data.message,
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: data.message,
                                    });
                                }
                            }
                        });
                    }
                });
            });
        });

        // when next button is clicked
        $('.btn-info').click(function() {
            window.location.href =
                'grades.php?section_id=<?php echo $sectionId; ?>&subject_id=<?php echo $_GET['subjectId']; ?>';
        });
        </script>



    </body>

    </html>