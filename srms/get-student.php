<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/config.php'); // Ensure this file establishes a MySQLi connection

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
}

// Get the student's registration number and email from session
$registration_number = $_SESSION['registration_number'];
$student_email = $_SESSION['student_email'];

// Fetch student details
$query = "SELECT Students.StudentName, Students.RegistrationNumber, Students.StudentEmail, courses.CourseName, courses.Faculty
          FROM Students
          JOIN courses ON courses.id = Students.CourseId
          WHERE Students.RegistrationNumber = ? AND Students.StudentEmail = ?";
$stmt = $dbh->prepare($query);
$stmt->bind_param('ss', $registration_number, $student_email);
$stmt->execute();
$studentResult = $stmt->get_result();
$studentInfo = $studentResult->fetch_object();

// Fetch student marks
$query = "SELECT CourseUnits.CourseUnitName, results.CourseWorkmarks, results.FinalAssesmentmarks
          FROM results
          JOIN CourseUnits ON CourseUnits.CourseUnitId = results.CourseUnitId
          WHERE results.RegistrationNumber = ?";
$stmt = $dbh->prepare($query);
$stmt->bind_param('s', $registration_number);
$stmt->execute();
$marksResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Result Management System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>
<body>
    <div class="main-wrapper">
        <div class="content-wrapper">
            <div class="content-container">

                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-12">
                                <h2 class="title" align="center">Result Management System</h2>
                            </div>
                        </div>
                    </div>

                    <section class="section" id="exampl">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h3 align="center">Student Result Details</h3>
                                                <hr />
                                                <?php
                                                // Initialize total marks
                                                $totlcount = 0;

                                                // Fetching student details
                                                $query = "SELECT Students.StudentName, Students.RegistrationNumber, courses.CourseName, courses.Faculty
                                                          FROM Students 
                                                          JOIN courses ON courses.id = Students.CourseId 
                                                          WHERE Students.RegistrationNumber = ? AND Students.StudentEmail = ?";
                                                $stmt = $dbh->prepare($query);
                                                $stmt->bind_param('ss', $registration_number, $student_email);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                ?>
                                                        <p><b>Student Name :</b> <?php echo htmlentities($row['StudentName']); ?></p>
                                                        <p><b>Student Registration Number :</b> <?php echo htmlentities($row['RegistrationNumber']); ?></p>
                                                        <p><b>Course Name :</b> <?php echo htmlentities($row['CourseName']); ?></p>
                                                        <p><b>Faculty :</b> <?php echo htmlentities($row['Faculty']); ?></p>
                                                <?php
                                                    }
                                                }

                                                // Fetching student marks
                                                $query = "SELECT CourseUnits.CourseUnitName, results.CourseWorkmarks, results.FinalAssesmentmarks
                                                          FROM results 
                                                          JOIN CourseUnits ON CourseUnits.CourseUnitId = results.CourseUnitId
                                                          WHERE results.RegistrationNumber = ?";
                                                $stmt = $dbh->prepare($query);
                                                $stmt->bind_param('s', $registration_number);
                                                $stmt->execute();
                                                $marksResult = $stmt->get_result();

                                                if ($marksResult->num_rows > 0) {
                                                    $cnt = 1;
                                                    while ($mark = $marksResult->fetch_assoc()) {
                                                ?>
                                                        <tr>
                                                            <th scope="row" style="text-align: center"><?php echo htmlentities($cnt); ?></th>
                                                            <td style="text-align: center"><?php echo htmlentities($mark['CourseUnitName']); ?></td>
                                                            <td style="text-align: center"><?php echo htmlentities($totalmarks = $mark['CourseWorkmarks'] + $mark['FinalAssesmentmarks']); ?></td>
                                                        </tr>
                                                <?php
                                                        $totlcount += $totalmarks;
                                                        $cnt++;
                                                    }
                                                ?>
                                                    <tr>
                                                        <th scope="row" colspan="2" style="text-align: center">Total Marks</th>
                                                        <td style="text-align: center"><b><?php echo htmlentities($totlcount); ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" colspan="2" style="text-align: center">Percentage</th>
                                                        <td style="text-align: center"><b><?php echo number_format($totlcount / ($cnt - 1), 2); ?>%</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" align="center"><i class="fa fa-print fa-2x" aria-hidden="true" style="cursor:pointer" OnClick="CallPrint()"></i></td>
                                                    </tr>
                                                <?php
                                                } else {
                                                    echo '<div class="alert alert-warning">No results found.</div>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <a href="index.php">Back to Home</a>
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

    <!-- Common JS files -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

</body>
</html>
