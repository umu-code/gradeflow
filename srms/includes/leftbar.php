<?php
session_start();
include('includes/config.php');
if (empty($_SESSION['alogin'])) {
    header("Location: index.php");
    exit;
}

?>


<div class="left-sidebar bg-black-300 box-shadow ">
    <div class="sidebar-content">
        <div class="user-info closed">
            <img src="http://placehold.it/90/c2c2c2?text=User" alt="admin" class="img-circle profile-img">
            <h6><?php echo htmlentities($_SESSION['alogin']); ?><br/></h6>
            <small class="info">Administrator</small>
            <hr>
        </div>
        <!-- /.user-info -->

        <div class="sidebar-nav">
            <ul class="side-nav color-gray">
                <li class="nav-header">
                    <span class="">Main Category</span>
                </li>
                <li>
                    <a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>

                </li>

                <li class="nav-header">
                    <span class="">Appearance</span>
                </li>
                <li class="has-children">
                    <a href="#"><i class="fa fa-file-text"></i> <span>Student Programs</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav">
                        <li><a href="create-course.php"><i class="fa fa-bars"></i> <span>Create Program</span></a></li>
                        <li><a href="manage-courses.php"><i class="fa fa fa-server"></i> <span>Manage Programs</span></a></li>

                    </ul>
                </li>
                <li class="has-children">
                    <a href="#"><i class="fa fa-file-text"></i> <span>CourseUnits</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav">
                        <li><a href="create-courseunit.php"><i class="fa fa-bars"></i> <span>Create CourseUnits</span></a></li>
                        <li><a href="manage-courseunits.php"><i class="fa fa fa-server"></i> <span>Manage CourseUnits</span></a></li>
                        <li><a href="add-course-courseunits.php"><i class="fa fa-newspaper-o"></i> <span>Add CourseUnits Combination </span></a></li>
                        <a href="manage-course-courseunits.php"><i class="fa fa-newspaper-o"></i> <span>Manage CourseUnits Combination </span></a>
                </li>
            </ul>
            </li>
            </li>
            <li class="has-children">
                <a href="#"><i class="fa fa-users"></i> <span>Admins</span> <i class="fa fa-angle-right arrow"></i></a>
                <ul class="child-nav">
                    <li><a href="add_admin.php"><i class="fa fa-bars"></i> <span>Add Admin</span></a></li>
                    <li><a href="manage-admin.php"><i class="fa fa fa-server"></i> <span>Manage Admins</span></a></li>

                </ul>
            </li>
            <li class="has-children">
                <a href="#"><i class="fa fa-users"></i> <span>Students</span> <i class="fa fa-angle-right arrow"></i></a>
                <ul class="child-nav">
                    <li><a href="add-students.php"><i class="fa fa-bars"></i> <span>Add Students</span></a></li>
                    <li><a href="manage-students.php"><i class="fa fa fa-server"></i> <span>Manage Students</span></a></li>

                </ul>
            </li>
            <li class="has-children">
                <a href="#"><i class="fa fa-info-circle"></i> <span>Results</span> <i class="fa fa-angle-right arrow"></i></a>
                <ul class="child-nav">
                    <li><a href="add-result.php"><i class="fa fa-bars"></i> <span>Add Results</span></a></li>
                    <li><a href="manage-results.php"><i class="fa fa fa-server"></i> <span>Manage Results</span></a></li>

                </ul>
            </li>


            <li class="has-children">
                <a href="#"><i class="fa fa-bell"></i> <span>Notices</span> <i class="fa fa-angle-right arrow"></i></a>
                <ul class="child-nav">
                    <li><a href="add-notice.php"><i class="fa fa-bars"></i> <span>Add Notice</span></a></li>
                    <li><a href="manage-notices.php"><i class="fa fa fa-server"></i> <span>Manage Notices</span></a></li>

                </ul>
            </li>



            <li><a href="change-password.php"><i class="fa fa fa-server"></i> <span> Admin Change Password</span></a></li>


        </div>
        <!-- /.sidebar-nav -->
    </div>
    <!-- /.sidebar-content -->
</div>