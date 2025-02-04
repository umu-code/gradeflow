<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(!isset($_SESSION['alogin']) || strlen($_SESSION['alogin']) == "") {   
    header("Location: index.php"); 
} else {
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
    <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>
</head>
<body class="top-navbar-fixed">
    <div class="main-wrapper">

        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php');?> 
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/leftbar.php');?>  

                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Manage Students</h2>
                            </div>
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li><a href="add-students.php">Add new Student</a></li>
                                    <li class="active">Manage Students</li>
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
                                                <h5>View Students Info</h5>
                                            </div>
                                        </div>
                                        <?php if($msg) { ?>
                                            <div class="alert alert-success left-icon-alert" role="alert">
                                                <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                            </div>
                                        <?php } else if($error) { ?>
                                            <div class="alert alert-danger left-icon-alert" role="alert">
                                                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                            </div>
                                        <?php } ?>
                                        <div class="panel-body p-20">
                                            <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr align="center">
                                                        <th>No.</th>
                                                        <th>Student Name</th>
                                                        <th>Registration Number</th>
                                                        <th>Student Email</th>
                                                        <th>Program</th>
                                                        <th>Added_date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr align="center">
                                                        <th>No.</th>
                                                        <th>Student Name</th>
                                                        <th>Registration Number</th>
                                                        <th>Student Email</th>
                                                        <th>Program</th>
                                                        <th>Added_date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                <?php 
                                                $sql = "SELECT  Students.StudentId, Students.StudentName, Students.RegistrationNumber, Students.RegistrationDate, Students.StudentEmail, Students.Status, courses.CourseName, courses.Faculty 
                                                        FROM Students 
                                                        LEFT JOIN courses ON courses.id = Students.CourseId";
                                                $result = mysqli_query($dbh, $sql); // Using mysqli_query instead of PDO

                                                if ($result && mysqli_num_rows($result) > 0) {
                                                    $cnt = 1;
                                                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                                        <tr>
                                                            <td><?php echo htmlentities($cnt); ?></td>
                                                            <td><?php echo htmlentities($row['StudentName']); ?></td>
                                                            <td><?php echo htmlentities($row['RegistrationNumber']); ?></td>
                                                            <td><?php echo htmlentities($row['StudentEmail']); ?></td>
                                                            <td><?php echo htmlentities($row['CourseName']); ?></td>
                                                            <td><?php echo htmlentities($row['RegistrationDate']); ?></td>
                                                            <td><?php echo ($row['Status'] == 1) ? 'Active' : 'Blocked'; ?></td>
                                                            <td>
                                                                <a href="edit-student.php?stid=<?php echo htmlentities($row['StudentId']); ?>" class="btn btn-primary btn-xs" target="_blank">Edit</a>
                                                                <a href="edit-result.php?stid=<?php echo htmlentities($row['StudentId']); ?>" class="btn btn-warning btn-xs" target="_blank">View Result</a>
                                                            </td>
                                                        </tr>
                                                    <?php 
                                                        $cnt++;
                                                    }
                                                } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-md-12 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->
                    </section>
                    <!-- /.section -->
                </div>
                <!-- /.main-page -->
            </div>
            <!-- /.content-container -->
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- /.main-wrapper -->

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
<?php } ?>
