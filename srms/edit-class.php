<?php
session_start();
error_reporting(E_ALL); // Enable all error reporting for development
include('includes/config.php');

// Check if the user is logged in
if (!isset($_SESSION['alogin']) || strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
    exit(); // Ensure no further script execution after redirect
}

// Initialize variables for messages
$msg = '';
$error = '';

if (isset($_POST['update'])) {
    $classname = trim($_POST['classname']);
    $classnamenumeric = intval($_POST['classnamenumeric']);
    $section = trim($_POST['section']);

    // Basic validation
    if (empty($classname) || empty($section) || $classnamenumeric <= 0) {
        $error = "Please fill all fields with valid data.";
    } else {
        $cid = intval($_GET['classid']);
        // Prepare the update statement
        $sql = "UPDATE tblclasses SET ClassName = ?, ClassNameNumeric = ?, Section = ? WHERE id = ?";
        $stmt = $dbh->prepare($sql);
        $stmt->bind_param("sisi", $classname, $classnamenumeric, $section, $cid);

        // Execute the statement
        if ($stmt->execute()) {
            $msg = "Data has been updated successfully";
        } else {
            $error = "Error updating data: " . $dbh->error;
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
    <title>SMS Admin Update Class</title>
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>
<body class="top-navbar-fixed">
    <div class="main-wrapper">

        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php');?>

        <div class="content-wrapper">
            <div class="content-container">

                <!-- ========== LEFT SIDEBAR ========== -->
                <?php include('includes/leftbar.php');?>                   

                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Update Student Class</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li><a href="#">Classes</a></li>
                                    <li class="active">Update Class</li>
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
                                                <h5>Update Student Class info</h5>
                                            </div>
                                        </div>

                                        <?php if ($msg) { ?>
                                            <div class="alert alert-success left-icon-alert" role="alert">
                                                <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                            </div>
                                        <?php } elseif ($error) { ?>
                                            <div class="alert alert-danger left-icon-alert" role="alert">
                                                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                            </div>
                                        <?php } ?>

                                        <form method="post">
                                            <?php 
                                            $cid = intval($_GET['classid']);
                                            $sql = "SELECT * FROM tblclasses WHERE id = ?";
                                            $stmt = $dbh->prepare($sql);
                                            $stmt->bind_param("i", $cid);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc(); 
                                            ?>
                                                <div class="form-group has-success">
                                                    <label for="classname" class="control-label">Class Name</label>
                                                    <input type="text" name="classname" value="<?php echo htmlentities($row['ClassName']); ?>" required="required" class="form-control" id="classname">
                                                    <span class="help-block">Eg- Third, Fourth, Sixth etc</span>
                                                </div>
                                                <div class="form-group has-success">
                                                    <label for="classnamenumeric" class="control-label">Class Name in Numeric</label>
                                                    <input type="number" name="classnamenumeric" value="<?php echo htmlentities($row['ClassNameNumeric']); ?>" required="required" class="form-control" id="classnamenumeric">
                                                    <span class="help-block">Eg- 1, 2, 4, 5 etc</span>
                                                </div>
                                                <div class="form-group has-success">
                                                    <label for="section" class="control-label">Section</label>
                                                    <input type="text" name="section" value="<?php echo htmlentities($row['Section']); ?>" class="form-control" required="required" id="section">
                                                    <span class="help-block">Eg- A, B, C etc</span>
                                                </div>
                                            <?php 
                                            } 
                                            $stmt->close();
                                            ?>
                                            <div class="form-group has-success">
                                                <button type="submit" name="update" class="btn btn-success btn-labeled">Update<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.col-md-8 col-md-offset-2 -->
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
    <script src="js/jquery-ui/jquery-ui.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
</body>
</html>
