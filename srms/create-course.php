<?php
session_start();
error_reporting(0);

include('includes/config.php');

if (!isset($_SESSION['alogin']) || strlen($_SESSION['alogin']) == "") {   
    header("Location: index.php"); 
} else {
    if (isset($_POST['submit'])) {
        $CourseName = $_POST['CourseName'];
        $CourseCode = $_POST['CourseCode']; 
        $Faculty = $_POST['Faculty'];

        $sql = "INSERT INTO courses (CourseName, CourseCode, Faculty) VALUES ('$CourseName', '$CourseCode', '$Faculty')";
        
        if (mysqli_query($dbh,$sql)){
            $msg = "Course Created successfully";
        } else {
            $error = "Something went wrong. Please try again";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Create Course</title>
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
    <style>
        .errorWrap { padding: 10px; background: #fff; border-left: 4px solid #dd3d36; }
        .succWrap { padding: 10px; background: #fff; border-left: 4px solid #5cb85c; }
    </style>
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
                            <div class="col-md-6">
                                <h2 class="title">Create Student Course</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li><a href="#">Courses</a></li>
                                    <li class="active">Create Course</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Create Student Course</h5>
                                            </div>
                                        </div>
                                        <?php if ($msg) { ?>
                                            <div class="alert alert-success left-icon-alert" role="alert">
                                                <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                            </div>
                                        <?php } else if ($error) { ?>
                                            <div class="alert alert-danger left-icon-alert" role="alert">
                                                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                            </div>
                                        <?php } ?>
                                        <div class="panel-body">
                                            <form method="post">
                                                <div class="form-group has-success">
                                                    <label for="success" class="control-label">CourseName</label>
                                                    <input type="text" name="CourseName" class="form-control" required="required" id="success">
                                                    <span class="help-block">Eg- Bachelor's In Statistics , Diploma In Computer Science  etc.</span>
                                                </div>
                                                <div class="form-group has-success">
                                                    <label for="success" class="control-label">CourseCode</label>
                                                    <input type="text" name="CourseCode" required="required" class="form-control" id="success">
                                                    <span class="help-block"> Eg - DIPCS , BSIT , BSCSetc.</span>
                                                </div>
                                                <div class="form-group has-success">
                                                    <label for="success" class="control-label">Faculty</label>
                                                    <input type="text" name="Faculty" class="form-control" required="required" id="success">
                                                    <span class="help-block">Eg - Science , Law , SASS etc.</span>
                                                </div>
                                                <button type="submit" name="submit" class="btn btn-success btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/jquery-ui/jquery-ui.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <script src="js/prism/prism.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
<?php ?>
