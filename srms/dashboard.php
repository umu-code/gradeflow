<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/config.php');

// Redirect to login page if session is not set
if (!isset($_SESSION['alogin']) || strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
    exit;
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Result Management System | Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/toastr/toastr.min.css" media="screen">
    <link rel="stylesheet" href="css/icheck/skins/line/blue.css">
    <link rel="stylesheet" href="css/icheck/skins/line/red.css">
    <link rel="stylesheet" href="css/icheck/skins/line/green.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>
<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <?php include('includes/topbar.php'); ?>
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/leftbar.php'); ?>

                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-sm-6">
                                <h2 class="title">Dashboard</h2>
                            </div>
                        </div>
                    </div>

                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <!-- Registered Users -->
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat bg-primary" href="manage-students.php">
                                        <?php
                                        $sql1 = "SELECT COUNT(StudentId) as total FROM Students";
                                        $query1 = $dbh->prepare($sql1);
                                        $query1->execute();
                                        $query1->bind_result($totalstudents);
                                        $query1->fetch();
                                        $query1->close();
                                        ?>
                                        <span class="number counter" style="font-weight: bolder;"><?php echo htmlentities($totalstudents); ?></span>
                                        <span class="name" style="font-weight: bold;">Registered Students</span>
                                        <span class="bg-icon"><i class="fa fa-users"></i></span>
                                    </a>
                                </div>

                                <!-- Subjects Listed -->
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat bg-danger" href="manage-courseunits.php">
                                        <?php
                                        $sql2 = "SELECT COUNT(CourseUnitId) as total FROM CourseUnits";
                                        $query2 = $dbh->prepare($sql2);
                                        $query2->execute();
                                        $query2->bind_result($totalsubjects);
                                        $query2->fetch();
                                        $query2->close();
                                        ?>
                                        <span class="number counter" style="font-weight: bolder;"><?php echo htmlentities($totalsubjects); ?></span>
                                        <span class="name" style="font-weight: bold;">Courseunits Listed</span>
                                        <span class="bg-icon"><i class="fa fa-ticket"></i></span>
                                    </a>
                                </div>

                                <!-- Total Classes Listed -->
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-top:1%;">
                                    <a class="dashboard-stat bg-warning" href="manage-courses.php">
                                        <?php
                                        $sql3 = "SELECT COUNT(id) as total FROM courses";
                                        $query3 = $dbh->prepare($sql3);
                                        $query3->execute();
                                        $query3->bind_result($totalclasses);
                                        $query3->fetch();
                                        $query3->close();
                                        ?>
                                        <span class="number counter" style="font-weight: bolder;"><?php echo htmlentities($totalclasses); ?></span>
                                        <span class="name"style="font-weight: bold;" >Total Courses Listed</span>
                                        <span class="bg-icon"><i class="fa fa-bank"></i></span>
                                    </a>
                                </div>

                                <!-- Results Declared -->
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-top:1%;">
                                    <a class="dashboard-stat bg-success" href="manage-results.php">
                                        <?php
                                        $sql4 = "SELECT COUNT(DISTINCT id) as total FROM results";
                                        $query4 = $dbh->prepare($sql4);
                                        $query4->execute();
                                        $query4->bind_result($totalresults);
                                        $query4->fetch();
                                        $query4->close();
                                        ?>
                                        <span class="number counter" style="font-weight: bolder;"><?php echo htmlentities($totalresults); ?></span>
                                        <span class="name" style="font-weight: bold;">Results Declared</span>
                                        <span class="bg-icon"><i class="fa fa-file-text"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Files -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(function() {
            // Counter for dashboard stats
            $('.counter').counterUp({
                delay: 10,
                time: 1000
            });

            // Welcome notification
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr["success"]("Welcome to Student Result Management System!");
        });
    </script>
</body>
</html>
