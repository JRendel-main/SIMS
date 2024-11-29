<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">
    <!-- Brand Logo Light -->
    <a href="index.php" class="logo logo-light">
        <img src="../assets/images/nehs.png" alt="light logo" height="80" />
    </a>

    <!-- Brand Logo Dark -->
    <a href="index.php" class="logo logo-dark">
        <span class="logo-lg">
            <img src="../assets/images/nehs.png" alt="dark logo" />
        </span>
        <span class="logo-sm">
            <img src="../assets/images/nehs.png" alt="small logo" />
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
        <div class="leftbar-user">
            <a href="pages-profile.php">
                <img src="assets/images/users/avatar-1.jpg" alt="user-image" height="42"
                    class="rounded-circle shadow-sm" />
                <span class="leftbar-user-name mt-2">Tosha Minner</span>
            </a>
        </div>

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
                <a data-bs-toggle="collapse" href="#sidebarStudent" aria-expanded="false"
                    class="side-nav-link side-sub-nav">
                    <i class="ri-user-3-line"></i>
                    <span> Advisory Class </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarStudent">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="add-student.php">Add Student</a>
                        </li>
                        <li>
                            <a href="student-list.php">Student List</a>
                        </li>
                        <li>
                            <a href="student-attendance.php">Student Attendance</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Section -->
            <li class="side-nav-item">
                <a href="section.php" class="side-nav-link">
                    <i class="ri-group-line"></i>
                    <span> Section </span>
                </a>
            </li>

            <li class=" side-nav-title">Attendance</li>

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
            </li>
        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left Sidebar End ========== -->