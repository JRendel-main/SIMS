<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">
    <!-- Brand Logo Light -->
    <a href="index.php" class="logo logo-light" id="logo">
        <img src="../assets/images/nehs.png" alt="light logo" height="100" />
        <div class="logo-sm"></div>
    </a>

    <!-- Brand Logo Dark -->
    <a href="index.php" class="logo logo-dark">
        <span class="logo-lg">
            <img src="../assets/images/nehs.png" alt="dark logo" />
        </span>
        <span class="logo-sm">
            <p class="text-white">NEHS</p>
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->

        <!--- Sidemenu -->
        <ul class="side-nav">
            <li class="side-nav-title">Dashboard</li>

            <li class="side-nav-item">
                <a href="index.php" class="side-nav-link">
                    <i class="ri-dashboard-line"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <li class="side-nav-title">Users</li>

            <!-- user with second level -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarTeacher" aria-expanded="false"
                    class="side-nav-link side-sub-nav">
                    <i class="ri-user-2-line"></i>
                    <span> Teacher </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarTeacher">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="teacher-lists.php">Teacher List</a>
                        </li>
                        <!-- <li>
                            <a href="add-teacher.php">Add Teacher</a>
                        </li> -->
                    </ul>
                </div>
            </li>

            <!-- user with second level -->
            <!-- <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarStudent" aria-expanded="false"
                    class="side-nav-link side-sub-nav">
                    <i class="ri-user-3-line"></i>
                    <span> Student </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarStudent">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="student.php">Student List</a>
                        </li>
                        <li>
                            <a href="add-student.php">Add Student</a>
                        </li>
                    </ul>
                </div>
            </li> -->

            <li class="side-nav-title">Academic Settings</li>

            <li class="side-nav-item">
                <a href="school-year.php" class="side-nav-link">
                    <i class="ri-calendar-check-line"></i>
                    <span> School Year </span>
                </a>
            </li>

            <!-- Section -->
            <li class="side-nav-item">
                <a href="section.php" class="side-nav-link">
                    <i class="
                    ri-group-line
                    "></i>
                    <span> Section </span>
                </a>
            </li>

            <!-- Strand -->
            <li class="side-nav-item">
                <a href="strand.php" class="side-nav-link">
                    <i class="ri-group-line"></i>
                    <span> Strand </span>
                </a>
            </li>

            <!-- Subjects -->
            <li class="side-nav-item">
                <a href="subjects.php" class="side-nav-link">
                    <i class="ri-book-2-line"></i>
                    <span> Subjects </span>
                </a>
            </li>

            <!-- <li class="side-nav-title">Attendance</li>

            <li class="side-nav-item">
                <a href="attendance.php" class="side-nav-link">
                    <i class="ri-calendar-check-line"></i>
                    <span> Attendance </span>
                </a>
            </li>


            <li class="side-nav-title">Settings</li>

            <li class="side-nav-item">
                <a href="settings.php" class="side-nav-link">
                    <i class="ri-settings-3-line"></i>
                    <span> Settings </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="logout.php" class="side-nav-link">
                    <i class="ri-logout-box-line text-danger"></i>
                    <span> Logout </span>
                </a>
            </li> -->
        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left Sidebar End ========== -->