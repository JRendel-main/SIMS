<!DOCTYPE html>

<head>
    <title>NEHS | Student Management Portal</title>

    <?php include '../../layouts/head-css.php'; ?>
</head>

<body class="authentication-bg pb-0">

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">

            <div class="card-body d-flex flex-column h-100 gap-3">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-start">
                    <a href="index.php" class="text-center logo-dark">
                        <span><img src="../../assets/images/nehs.png" alt="dark logo" height="80"></span>
                    </a>
                    <h1 class="text-center">NEHS Student Management Portal</h1>
                    <div class="text-center">
                        <p class="text-muted">Sign in to continue to NEHS Student Management Portal.</p>
                    </div>
                </div>
                <div class="mb-auto">
                    <!-- form -->
                    <form action="#">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input class="form-control" type="textbox" id="username" required=""
                                placeholder="Enter your username">
                        </div>
                        <div class="mb-3">
                            <a href="auth-recoverpw-2.php" class="text-muted float-end"><small>Forgot your
                                    password?</small></a>
                            <label for="password" class="form-label">Password</label>
                            <input class="form-control" type="password" required="" id="password"
                                placeholder="Enter your password">
                        </div>
                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-success" type="submit"><i class="ri-login-box-line"></i> Log In
                            </button>
                        </div>
                    </form>
                    <!-- end form-->
                </div>

                <!-- Footer-->
                <footer class="footer footer-alt">
                    <p class="text-muted">Don't have an account? <a href="auth-register-2.php"
                            class="text-muted ms-1"><b>Request here</b></a></p>
                </footer>

            </div> <!-- end .card-body -->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                <h2 class="mb-3">Quote of the day</h2>
                <p class="lead">"It is the supreme art of the teacher to awaken joy in creative expression and
                    knowledge."</p>
                <p>- Albert Einstein</p>
            </div> <!-- end auth-user-testimonial-->
        </div>
        <!-- end Auth fluid right content -->
    </div>
    <!-- end auth-fluid-->
    <?php include '../../layouts/footer-scripts.php'; ?>

    <!-- App js -->
    <script src="../../assets/js/app.min.js"></script>

</body>

</html>