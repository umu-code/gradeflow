<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(!isset($_SESSION['alogin']) || strlen($_SESSION['alogin'])=="") {   
    header("Location: index.php"); 
} else {
    if(isset($_POST['submit'])) {
        $course = $_POST['course'];
        $courseunit = $_POST['courseunit'];
        $status = 1;

        // Prepare SQL query using MySQLi
        $sql = "INSERT INTO `course&courseunit_combination`(CourseId, CourseUnitId, status) VALUES (?, ?, ?)";
        $stmt = $dbh->prepare($sql);
        $stmt->bind_param("iii", $course, $courseunit, $status);

        if ($stmt->execute()) {
            $msg = "Combination added successfully";
        } else {
            $error = "Something went wrong. Please try again";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS Admin Courseunit Combination</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
	<link href="images/umu.png" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>
<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <?php include('includes/topbar.php');?> 
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/leftbar.php');?>  
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Add Courseunit Combination</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li>Courseunits</li>
                                    <li class="active">Add Courseunit Combination</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Add Courseunit Combination</h5>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <?php if($msg) { ?>
                                                <div class="alert alert-success left-icon-alert" role="alert">
                                                    <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                                </div>
                                            <?php } else if($error) { ?>
                                                <div class="alert alert-danger left-icon-alert" role="alert">
                                                    <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                                </div>
                                            <?php } ?>
                                            <form class="form-horizontal" method="post">
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Program</label>
                                                    <div class="col-sm-10">
                                                        <select name="course" class="form-control" id="default" required="required">
                                                            <option value="">Select Program</option>
                                                            <?php
                                                            $sql = "SELECT courses.id , courses.CourseName , courses.Faculty , faculties.faculty_id , faculties.faculty_name
                                                                    FROM courses
                                                                    LEFT JOIN faculties ON faculties.faculty_id = courses.Faculty";
                                                            $result = $dbh->query($sql);
                                                            if($result->num_rows > 0) {
                                                                while($row = $result->fetch_object()) {
                                                            ?>
                                                            <option value="<?php echo htmlentities($row->id); ?>">
                                                                <?php echo htmlentities($row->CourseName); ?>&nbsp; - <?php echo htmlentities($row->faculty_name); ?>
                                                            </option>
                                                            <?php 
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Courseunit</label>
                                                    <div class="col-sm-10">
                                                        <select name="courseunit" class="form-control" id="default" required="required">
                                                            <option value="">Select Courseunit</option>
                                                            <?php
                                                            $sql = "SELECT * FROM CourseUnits";
                                                            $result = $dbh->query($sql);
                                                            if($result->num_rows > 0) {
                                                                while($row = $result->fetch_object()) {
                                                            ?>
                                                            <option value="<?php echo htmlentities($row->CourseUnitId); ?>">
                                                                <?php echo htmlentities($row->CourseUnitName); ?>
                                                            </option>
                                                            <?php 
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit" name="submit" class="btn btn-primary">Add</button>
                                                    </div>
                                                </div>
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
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <script src="js/prism/prism.js"></script>
    <script src="js/select2/select2.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(function($) {
            $(".js-states").select2();
            $(".js-states-limit").select2({
                maximumSelectionLength: 2
            });
            $(".js-states-hide").select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
</body>
</html>
<?php ?>
