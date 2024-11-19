<?php
session_start();
error_reporting(0);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include('includes/config.php');

// Check if the user is logged in
if (!isset($_SESSION['alogin']) || strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
    exit(); // Ensure no further script execution after redirect
}

// Initialize variables for messages
$msg = '';
$error = '';

$cid = intval($_GET['id']);


if (isset($_POST['update'])) {
    $CourseName= $_POST['CourseName'];
    $CourseCode = $_POST['CourseCode'];
    $Faculty = $_POST['Faculty'];
   
    // Basic validation
    if (empty($CourseName) || empty($Faculty) || empty($CourseCode)) {
        $error = "Please fill all fields with valid data.";
    } else {
        // Prepare the update statement
        $sql = "UPDATE courses SET CourseName = ?, CourseCode = ?, Faculty = ? WHERE id = ?";
        $stmt = $dbh->prepare($sql);
        $stmt->bind_param("ssii", $CourseName, $CourseCode, $Faculty, $cid);

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
    <title>SMS Admin Update Course</title>
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
                                <h2 class="title">Update Student course</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li><a href="manage-courses.php">Courses</a></li>
                                    <li class="active">Update course</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <section class="Faculty">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Update Student Course info</h5>
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
                                            $cid = intval($_GET['id']);
                                            $sql = "SELECT c.id , c.CourseName , c.CourseCode , c.Faculty , c.CreationDate , c.UpdationDate , f.faculty_name as Faculty
                                                            FROM courses c
                                                            LEFT JOIN faculties f ON f.faculty_id = c.Faculty
                                                            WHERE id = ?";
                                            $stmt = $dbh->prepare($sql);
                                            $stmt->bind_param("i", $cid);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc(); 
                                            ?>
                                                <div class="form-group has-success">
                                                    <label for="coursename" class="control-label">CourseName</label>
                                                    <input type="text" name="CourseName" value="<?php echo htmlentities($row['CourseName']); ?>" required="required" class="form-control" id="courseName">
                                                    <span class="help-block">Eg- Third, Fourth, Sixth etc</span>
                                                </div>
                                                <div class="form-group has-success">
                                                    <label for="course_code" class="control-label">CourseCode</label>
                                                    <input type="text" name="CourseCode" value="<?php echo htmlentities($row['CourseCode']); ?>" required="required" class="form-control" id="course_code">
                                                    <span class="help-block">Eg - DIPCS , BSIT , BSCS etc.</span>
                                                </div>
                                                <div class="form-group has-success">
                                                    <label for="Faculty" class="control-label">Faculty</label>
                                                        <select name="Faculty" class="form-control" id="default" required="required">
                                                                <option value=""><?php echo htmlentities($row['Facullty']); ?></option>
                                                                <?php
                                                                $sql = "SELECT * FROM faculties";
                                                                $result = mysqli_query($dbh, $sql);
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    echo "<option value='" . $row['faculty_id'] . "'>" . $row['faculty_name'] . "</option>";
                                                                }
                                                                ?>
                                                        </select>
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
