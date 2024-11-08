<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (!isset($_SESSION['alogin']) || strlen($_SESSION['alogin']) == "") {   
    header("Location: index.php"); 
} else {


    if (isset($_POST['Update'])) {
        $sid = intval($_GET['CourseUnitId']);
        $courseunitname = $_POST['courseunitname'];
        $courseunitcode = $_POST['courseunitcode']; 

        // Using MySQLi to update subject
        $sql = "UPDATE CourseUnits SET CourseUnitName=? , CourseUnitCode=? WHERE CourseUnitId=?";
        $query= $dbh->prepare($sql);
        $query->bind_param('ssi', $courseunitname, $courseunitcode, $sid);
        $query->execute();

        if ($query->affected_rows > 0) {
            $msg = "Courseunit Info updated successfully";
        } else {
            $error = "Error updating Courseunit: ";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS Admin Update CourseUnits</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
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
                                <h2 class="title">Update CourseUnits</h2>
                            </div>
                        </div>
                        <div class="container-fluid" style="margin-top: 1rem;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Update CourseUnit</h5>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <?php if (isset($msg)) { ?>
                                                <div class="alert alert-success left-icon-alert" role="alert">
                                                    <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                                </div>
                                            <?php } elseif (isset($error)) { ?>
                                                <div class="alert alert-danger left-icon-alert" role="alert">
                                                    <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                                </div>
                                            <?php } ?>
                                            <form class="form-horizontal" method="post">
                                                <?php
                                                $sid = intval($_GET['CourseUnitId']);
                                                $sql = "SELECT * FROM CourseUnits WHERE CourseUnitId='$sid'";
                                                $result = mysqli_query($dbh, $sql);
                                                
                                                if (mysqli_num_rows($result) > 0) {
                                                    $result = mysqli_fetch_assoc($result); // Fetch once instead of in a loop
                                                    ?>                                               
                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">CourseUnit Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="courseunitname" value="<?php echo htmlentities($result['CourseUnitName']); ?>" class="form-control" id="default" placeholder="Course UnitName Name" required="required">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">CourseUnit Code</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="courseunitcode" class="form-control" value="<?php echo htmlentities($result['CourseUnitCode']); ?>" id="default" placeholder="Course Unit Code" required="required">
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="alert alert-warning left-icon-alert" role="alert">
                                                        <strong>Warning!</strong> Course Unit not found.
                                                    </div>
                                                <?php } ?>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit" name="Update" class="btn btn-primary">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-md-12 -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
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
<?php } ?>
