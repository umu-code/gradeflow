<?php
session_start();
error_reporting(0);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include('includes/config.php');

if (!isset($_SESSION['alogin']) || strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_GET['id'])) {
        $subid = $_GET['id'];
        $sql = "DELETE FROM results WHERE id = '$subid'";
        $stmt = mysqli_query($dbh ,$subid);
        if ($stmt) {
            echo '<script>alert("Data deleted.")</script>';
            echo "<script>window.location.href ='manage-results.php'</script>";
        } else {
            echo '<script>alert("Error deleting data.")</script>';
        }
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Manage Students</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/prism/prism.css" media="screen">
	    <link href="images/umu.png" rel="shortcut icon" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/modernizr/modernizr.min.js"></script>
        <style>
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #dd3d36;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .succWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #5cb85c;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }
        </style>
    </head>

    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
            <?php include('includes/topbar.php'); ?>
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">
                    
                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Student Results Visualized</h2>
                                </div>
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li><a href="add-result.php">Results</a></li>
                                        <li class="active"><a href="results_visual.php">View Results Visualized</a></li>
                                        <li><a href="manage-results.php">Manage Results</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->

                        <section class="section">
                            <div class="container-fluid">

                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>View Students Result Graded Summary</h5>
                                                </div>
                                            </div>
                                            <?php if ($msg) { ?>
                                                <div class="alert alert-success left-icon-alert" role="alert">
                                                    <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                                </div>
                                            <?php } else if ($error) { ?>
                                                <div class="alert alert-danger left-icon-alert" role="alert">
                                                    <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                                </div>
                                            <?php } ?>
                                            <div class="panel-body p-20">

                                                        <?php
                                                        $sql = "SELECT 
                                                                    s.StudentId, 
                                                                    s.StudentName, 
                                                                    s.RegistrationNumber, 
                                                                    s.CourseId, 
                                                                    courses.CourseName, 
                                                                    results.id, 
                                                                    results.CourseId, 
                                                                    results.CourseunitId, 
                                                                    results.CourseWorkmarks, 
                                                                    results.FinalAssesmentmarks, 
                                                                    results.TotalMarks, 
                                                                    results.Grade,
                                                                    results.Year, 
                                                                    CourseUnits.CourseUnitId, 
                                                                    CourseUnits.CourseUnitName, 
                                                                    cc.CourseUnitId
                                                                FROM Students as s
                                                                JOIN courses ON courses.id = s.CourseId
                                                                JOIN `course&courseunit_combination` as cc ON cc.CourseId = s.CourseId
                                                                JOIN CourseUnits ON cc.CourseUnitId = CourseUnits.CourseUnitId 
                                                                JOIN results ON results.RegistrationNumber = s.StudentId AND results.CourseId = s.CourseId";

                                                        $result = mysqli_query($dbh, $sql);
                                                        $cnt = 1;

                                                        if (mysqli_num_rows($result) > 0) {
                                                            $garde =[];
                                                            while ($row = mysqli_fetch_assoc($result)) { 
                                                                $marks = $row['TotalMarks'];
                                                                if ($marks >= 95) {
                                                                    $grade = 'A+';
                                                                } elseif ($marks >= 90) {
                                                                    $grade = 'A';
                                                                } elseif ($marks >= 85) {
                                                                    $grade = 'B+';
                                                                }elseif ($marks >= 80) {
                                                                    $grade = 'B';
                                                                }elseif ($marks >= 75) {
                                                                    $grade = 'C+';
                                                                }elseif ($marks >= 70) {
                                                                    $grade = 'C';
                                                                } elseif ($marks >= 65) {
                                                                    $grade = 'C+';
                                                                }elseif ($marks >= 60) {
                                                                    $grade = 'C';
                                                                }elseif ($marks >= 55) {
                                                                    $grade = 'D+';
                                                                }elseif ($marks >= 50) {
                                                                    $grade = 'D';
                                                                }elseif ($marks >= 49) {
                                                                    $grade = 'SUP';
                                                                }
                                                                else {
                                                                    $grade = 'RTF';
                                                                }  
                                                        
                                                                $grades[] = array_merge($row, ['Grade' => $grade]); 
                                                            }

                                                           }?>
                                                            <div>
                                                                <?php
                                                                     $gradeCounts = array_count_values(array_column($grades, 'Grade'));
                                                                ?>
                                                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                                                <canvas id="gradeChart" width="300" height="100"></canvas>
                                                                <script>
                                                                const ctx = document.getElementById('gradeChart').getContext('2d');
                                                                        const gradeChart = new Chart(ctx, {
                                                                        type: 'bar',
                                                                        data: {
                                                                            labels: <?= json_encode(array_keys($gradeCounts)) ?>,
                                                                            datasets: [{
                                                                            label: 'Number of Students',
                                                                            data: <?= json_encode(array_values($gradeCounts)) ?>,
                                                                            backgroundColor: ['#4CAF50', '#2196F3', '#FFC107', '#FF5722', '#9E9E9E'],
                                                                            }]
                                                                        }
                                                                    });
                                                                </script>
                                                        

                                                            </div>
                                                                


        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $('#example').DataTable();
                $('#example2').DataTable({
                    "scrollY": "300px",
                    "scrollCollapse": true,
                    "paging": false
                });
                $('#example3').DataTable();
            });
        </script>
    </body>

    </html>
<?php }
?>


