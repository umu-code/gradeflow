<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database configuration file
include('includes/config.php'); // Ensure the file establishes a connection to the database

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trim user inputs to avoid leading/trailing spaces
    $registration_number = trim($_POST['registration_number']);
    $student_email = trim($_POST['student_email']);

    // Validate if both fields are not empty
    if (!empty($registration_number) && !empty($student_email)) {
        // Prepare SQL statement to prevent SQL injection
        $query = "SELECT * FROM Students WHERE RegistrationNumber = '$registration_number' AND StudentEmail = '$student_email'";
        $stmt = $dbh->prepare($query);
        $stmt->bind_param('ss', $registration_number, $student_email); // Bind the parameters
        $stmt->execute(); // Execute the query
        $result = $stmt->get_result(); // Get the result

        // Check if there is exactly one row (meaning valid credentials)
        if ($result->num_rows === 1) {
            // Fetch the student's data
            $row = $result->fetch_assoc();


            // Store session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['registration_number'] = $row['RegistrationNumber'];
            $_SESSION['student_email'] = $row['StudentEmail'];

            // Redirect to results page
            header("location: get-student.php");
            exit();
        } else {
            // Invalid login credentials
            $error = "Invalid registration number or email.";
        }
    } else {
        // Prompt to enter both fields
        $error = "Please enter both your registration number and email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Student Result Management System</title>

    <!-- Local Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/icheck/skins/flat/blue.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
	<link href="images/umu.png" rel="shortcut icon" type="image/x-icon">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>
<body>

<div class="main-wrapper">
    <div class="login-bg-color bg-black-300">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel login-box">
                    <div class="panel-heading">
                        <div class="panel-title text-center">
                            <h4>School Result Management System</h4>
                        </div>
                    </div>
                    <div class="panel-body p-20">
                        <!-- Display error message if set -->
                        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

                        <!-- Login form -->
                        <form method="post" action="get-student.php">
                            <div class="form-group">
                                <label for="registration_number">Registration Number</label>
                                <input type="text" class="form-control" id="registration_number" name="registration_number" placeholder="Enter Your Registration Number" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="student_email">Email</label>
                                <input type="email" class="form-control" id="student_email" name="student_email" placeholder="Enter Your student's email" autocomplete="off" required>
                            </div>
                            <div class="form-group mt-20">
                                <button type="submit" class="btn btn-success btn-labeled pull-right">
                                    Login
                                    <span class="btn-label btn-label-right">
                                        <i class="fa fa-check"></i>
                                    </span>
                                </button>
                            </div>
                            <div class="col-sm-6">
                                <a href="index.php">Back to Home</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript dependencies -->
<script src="js/jquery/jquery-2.2.4.min.js"></script>
<script src="js/jquery-ui/jquery-ui.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/pace/pace.min.js"></script>
<script src="js/lobipanel/lobipanel.min.js"></script>
<script src="js/iscroll/iscroll.js"></script>
<script src="js/icheck/icheck.min.js"></script>
<script src="js/main.js"></script>
<script>
    $(function() {
        $('input.flat-blue-style').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        });
    });
</script>

</body>
</html>
