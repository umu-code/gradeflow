<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == "") {   
    header("Location: index.php"); 
} else {
    $stid = intval($_GET['stid']);

    if (isset($_POST['submit'])) {
        $studentname = $_POST['fullanme'];
        $registration_number = $_POST['registration_number'];
        $studentemail = $_POST['emailid'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $courseid = $_POST['course'];
        $status = $_POST['status'];

        // Update query using MySQLi
        $sql = "UPDATE Students SET StudentName=?, RegistrationNumber=?, StudentEmail=?, Gender=?, DOB=?, Status=? WHERE StudentId=?";
        $stmt = $dbh->prepare($sql);
        $stmt->bind_param('ssssssi', $studentname, $registration_number, $studentemail, $gender, $dob, $status, $stid);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $msg = "Student info updated successfully";
        } else {
            $error = "Error updating student info";
        }
        $stmt->close();
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>SMS Admin| Edit Student</title>
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
                                        <h2 class="title">Student Admission</h2>
                                    </div>
                                </div>
                                <div class="row breadcrumb-div">
                                    <div class="col-md-6">
                                        <ul class="breadcrumb">
                                            <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                            <li class="active">Student Admission</li>
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
                                                    <h5>Fill the Student info</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <?php if ($msg) { ?>
                                                    <div class="alert alert-success left-icon-alert" role="alert">
                                                        <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                                    </div>
                                                <?php } else if ($error) { ?>
                                                    <div class="alert alert-danger left-icon-alert" role="alert">
                                                        <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                                    </div>
                                                <?php } ?>

                                                <form class="form-horizontal" method="post">
                                                    <?php 
                                                    $sql = "SELECT Students.StudentName, Students.RegistrationNumber, Students.RegistrationDate, Students.StudentId, Students.Status, Students.StudentEmail, Students.Gender, Students.DOB, courses.CourseName, courses.Faculty 
                                                            FROM Students
                                                            JOIN courses ON courses.id = Students.CourseId 
                                                            WHERE Students.StudentId = ?";
                                                    $stmt = $dbh->prepare($sql);
                                                    $stmt->bind_param('i', $stid);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();

                                                    if ($result->num_rows > 0) {
                                                        $row = $result->fetch_assoc();
                                                    ?>

                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Full Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="fullanme" class="form-control" id="fullanme" value="<?php echo htmlentities($row['StudentName']) ?>" required="required" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Registration Number</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="registration_number" class="form-control" id="registration_number" value="<?php echo htmlentities($row['RegistrationNumber']) ?>" maxlength="25" required="required" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Email Id</label>
                                                        <div class="col-sm-10">
                                                            <input type="email" name="emailid" class="form-control" id="email" value="<?php echo htmlentities($row['StudentEmail']) ?>" required="required" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Gender</label>
                                                        <div class="col-sm-10">
                                                            <?php $gndr = $row['Gender'];
                                                            if ($gndr == "Male") { ?>
                                                                <input type="radio" name="gender" value="Male" required="required" checked>Male 
                                                                <input type="radio" name="gender" value="Female" required="required">Female 
                                                                <input type="radio" name="gender" value="Other" required="required">Other
                                                            <?php } ?>
                                                            <?php if ($gndr == "Female") { ?>
                                                                <input type="radio" name="gender" value="Male" required="required">Male 
                                                                <input type="radio" name="gender" value="Female" required="required" checked>Female 
                                                                <input type="radio" name="gender" value="Other" required="required">Other
                                                            <?php } ?>
                                                            <?php if ($gndr == "Other") { ?>
                                                                <input type="radio" name="gender" value="Male" required="required">Male 
                                                                <input type="radio" name="gender" value="Female" required="required">Female 
                                                                <input type="radio" name="gender" value="Other" required="required" checked>Other
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Course</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="course" class="form-control" id="coursename" value="<?php echo htmlentities($row['CourseName']) ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="date" class="col-sm-2 control-label">DOB</label>
                                                        <div class="col-sm-10">
                                                            <input type="date" name="dob" class="form-control" value="<?php echo htmlentities($row['DOB']) ?>" id="date">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Registration Date: </label>
                                                        <div class="col-sm-10">
                                                            <?php echo htmlentities($row['RegistrationDate']) ?>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Status</label>
                                                        <div class="col-sm-10">
                                                            <?php $stats = $row['Status'];
                                                            if ($stats == "1") { ?>
                                                                <input type="radio" name="status" value="1" required="required" checked>Active 
                                                                <input type="radio" name="status" value="0" required="required">Block 
                                                            <?php } ?>
                                                            <?php if ($stats == "0") { ?>
                                                                <input type="radio" name="status" value="1" required="required">Active 
                                                                <input type="radio" name="status" value="0" required="required" checked>Block 
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-10 col-sm-offset-2">
                                                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </div>
                                                    <?php 
                                                    } 
                                                    ?>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ========== FOOTER ========== -->
                <?php include('includes/footer.php');?>
            </div>
        </body>
    </html>
    <?php
}

