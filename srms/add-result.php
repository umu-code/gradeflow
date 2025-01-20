<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Redirect to login if not authenticated
if (!isset($_SESSION['alogin']) || strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
    exit;
}

if (isset($_POST['submit'])) {
    $studentid = $_POST['registration_number'];
    $course = $_POST['course'];
    $courseunit = $_POST['courseunit'];
    $coursemarks = $_POST['coursemarks'];
    $finalmarks = $_POST['finalmarks'];
    $totalMarks = $coursemarks + $finalmarks; // Calculate total marks
    $year = $_POST['year'];

    // Insert data into the results table
    $sql = "INSERT INTO results(RegistrationNumber, CourseId, CourseUnitId, CourseworkMarks, FinalAssesmentmarks, TotalMarks, Year) 
            VALUES(?, ?, ?, ?, ?, ?, ?)";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("siiiiii", $studentid, $course, $courseunit, $coursemarks, $finalmarks, $totalMarks, $year);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $msg = "Result info added successfully";
    } else {
        $error = "Something went wrong. Please try again";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS Admin | Add Result</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
	<link href="images/umu.png" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script>
        // Fetch students based on course
        function getStudents(courseId) {
            $.ajax({
                type: "POST",
                url: "get_student.php",
                data: { courseId: courseId },
                success: function(data) {
                    $("#registration_number").html(data);
                }
            });
        }

        // Fetch course units based on course
        function getCourseUnits(courseId) {
            $.ajax({
                type: "POST",
                url: "get_courseunits.php",
                data: { courseId: courseId },
                success: function(data) {
                    $("#courseunit").html(data);
                }
            });
        }
    </script>
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
                                <h2 class="title">Declare Result</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li class="active">Student Result</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid" style="margin-top: 1rem;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <?php if ($msg) { ?>
                                            <div class="alert alert-success" role="alert">
                                                <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                            </div>
                                        <?php } elseif ($error) { ?>
                                            <div class="alert alert-danger" role="alert">
                                                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                            </div>
                                        <?php } ?>
                                        <form class="form-horizontal" method="post">
                                            <div class="form-group">
                                                <label for="course" class="col-sm-2 control-label">Program</label>
                                                <div class="col-sm-10">
                                                    <select name="course" id="course" class="form-control" required onChange="getStudents(this.value); getCourseUnits(this.value);">
                                                        <option value="">Select Course</option>
                                                        <?php
                                                        $sql = "SELECT id, CourseName FROM courses";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->get_result();
                                                        while ($row = $results->fetch_assoc()) {
                                                            echo "<option value='" . $row['id'] . "'>" . $row['CourseName'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="registration_number" class="col-sm-2 control-label">Student</label>
                                                <div class="col-sm-10">
                                                    <select name="registration_number" id="registration_number" class="form-control" required>
                                                        <option value="">Select Student</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="courseunit" class="col-sm-2 control-label">Course Unit</label>
                                                <div class="col-sm-10">
                                                    <select name="courseunit" id="courseunit" class="form-control" required>
                                                        <option value="">Select Course Unit</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="coursemarks" class="col-sm-2 control-label">Coursework Marks</label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="coursemarks" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="finalmarks" class="col-sm-2 control-label">Final Assessment Marks</label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="finalmarks" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="year" class="col-sm-2 control-label">Year</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="year" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" name="submit" class="btn btn-primary">Declare Result</button>
                                                </div>
                                            </div>

                                        </form>

                                        <div class="form-group">
                                                <label for="multiple_results" class="col-sm-2 control-label">Add Multiple Results</label>
                                                <div style="display: flex;">
                                                    <form action="generate_csv_template.php" method="get">
                                                        <div class="col-sm-10">
                                                            <button class="btn btn-primary">Download CSV Template</button>
                                                        </div>
                                                    </form>
                                            
                                                    <form action="upload_csv_results.php" method="post">
                                                        <div class="col-sm-10">
                                                            <button class="btn btn-success">Upload Multiple Results</button>
                                                        </div>
                                                    </form>
                                                    
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
