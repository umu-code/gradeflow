<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == "") {   
    header("Location: index.php"); 
} else {
    $stid = intval($_GET['stid']);
    if(isset($_POST['submit'])) {
        $rowid = $_POST['id'];
        $marks = $_POST['marks']; 

        foreach($_POST['id'] as $count => $id) {
            $mrks = $marks[$count];
            $iid = $rowid[$count];

            // Using MySQLi to execute the update query
            $sql = "UPDATE tblresult SET marks=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $mrks, $iid);
            $stmt->execute();
        }
        
        $msg = "Result info updated successfully";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS Admin | Student Result Info</title>
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

        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php');?> 

        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">

                <!-- ========== LEFT SIDEBAR ========== -->
                <?php include('includes/leftbar.php');?>  
                <!-- /.left-sidebar -->

                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Student Result Info</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li class="active">Result Info</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5>Update the Result Info</h5>
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
                                            <?php 
                                            // Using MySQLi for fetching student details
                                            $ret = "SELECT tblstudents.StudentName, tblclasses.ClassName, tblclasses.Section 
                                                    FROM tblresult 
                                                    JOIN tblstudents ON tblresult.StudentId=tblstudents.StudentId 
                                                    JOIN tblsubjects ON tblsubjects.id=tblresult.SubjectId 
                                                    JOIN tblclasses ON tblclasses.id=tblstudents.ClassId 
                                                    WHERE tblstudents.StudentId=? LIMIT 1";
                                            $stmt = $conn->prepare($ret);
                                            $stmt->bind_param("i", $stid);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            
                                            if($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) { 
                                            ?>
                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Class</label>
                                                        <div class="col-sm-10">
                                                            <?php echo htmlentities($row['ClassName']) . " (" . htmlentities($row['Section']) . ")"; ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Full Name</label>
                                                        <div class="col-sm-10">
                                                            <?php echo htmlentities($row['StudentName']); ?>
                                                        </div>
                                                    </div>
                                            <?php 
                                                }
                                            } 
                                            ?>

                                            <?php 
                                            // Fetching marks
                                            $sql = "SELECT DISTINCT tblstudents.StudentName, tblstudents.StudentId, tblclasses.ClassName, tblclasses.Section, 
                                                            tblsubjects.SubjectName, tblresult.marks, tblresult.id AS resultid 
                                                    FROM tblresult 
                                                    JOIN tblstudents ON tblstudents.StudentId=tblresult.StudentId 
                                                    JOIN tblsubjects ON tblsubjects.id=tblresult.SubjectId 
                                                    JOIN tblclasses ON tblclasses.id=tblstudents.ClassId 
                                                    WHERE tblstudents.StudentId=?";
                                            $query = $conn->prepare($sql);
                                            $query->bind_param("i", $stid);
                                            $query->execute();
                                            $results = $query->get_result();
                                            
                                            if($results->num_rows > 0) {
                                                while($result = $results->fetch_assoc()) {  
                                            ?>
                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label"><?php echo htmlentities($result['SubjectName']) ?></label>
                                                        <div class="col-sm-10">
                                                            <input type="hidden" name="id[]" value="<?php echo htmlentities($result['resultid']) ?>">
                                                            <input type="text" name="marks[]" class="form-control" id="marks" value="<?php echo htmlentities($result['marks']) ?>" maxlength="5" required="required" autocomplete="off">
                                                        </div>
                                                    </div>
                                            <?php 
                                                }
                                            } 
                                            ?>                                                    

                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
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
<?php ?>
