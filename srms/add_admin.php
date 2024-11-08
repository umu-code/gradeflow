<?php
session_start();
error_reporting(0);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $name = $_POST['fullname'];
        $password = md5($_POST['password']);
        $email = $_POST['adminEmail'];
        $role = $_POST['role'];
        $contacts = $_POST['contacts'];

        function isValidUniversityEmail($email)
        {
            $pattern = "/^[a-zA-Z0-9._%+-]+@umu\.ac\.ug$/";
            return preg_match($pattern, $email);
        }

        if (isValidUniversityEmail($email)) {

            $sql = "INSERT INTO admins (UserName, Password, adminEmail, role, contacts) VALUES ('$name','$password','$email','$role','$contacts')";

            if (mysqli_query($dbh, $sql)) {
                $msg = "Admin info added successfully";
            } else {
                $error = "Something went wrong. Please try again";
            }
        }else{
            $error = "Invalid Email. Please enter the university email for the administrator.";
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SMS Admin | Add Admin</title>
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
            <?php include('includes/topbar.php'); ?>
            <div class="content-wrapper">
                <div class="content-container">
                    <?php include('includes/leftbar.php'); ?>
                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Add Admin</h2>
                                </div>
                            </div>
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li class="active">add_admin</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid" style="margin-top: 1rem;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Fill the admin info</h5>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <?php if ($msg) { ?>
                                                <div class="alert alert-success left-icon-alert" role="alert">
                                                    <strong>Well done!&nbsp;</strong><?php echo htmlentities($msg); ?>
                                                </div><?php } else if ($error) { ?>
                                                <div class="alert alert-danger left-icon-alert" role="alert">
                                                    <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                                </div>
                                            <?php } ?>
                                            <form class="form-horizontal" method="post">
                                                <!-- admin Name -->
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Full Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="fullname" class="form-control" id="fullname" required="required" autocomplete="off">
                                                    </div>
                                                </div>

                                                <!-- email -->
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="adminEmail" class="form-control" id="adminEmail" maxlength="35" required="required" autocomplete="off">
                                                    </div>
                                                </div>

                                                <!-- password -->
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" name="password" class="form-control" id="password" required="required" autocomplete="off">
                                                    </div>
                                                </div>

                                                <!-- contacts -->
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Contacts</label>
                                                    <div class="col-sm-10">
                                                        <input type="int" name="contacts" class="form-control" id="contacts" required="required" autocomplete="off">
                                                    </div>
                                                </div>

                                                <!--role-->
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Role</label>
                                                    <div class="col-sm-10">
                                                        <select name="role" class="form-control" id="default" required="required">
                                                            <option value="">select role</option>
                                                            <?php
                                                            $sql = "SELECT * FROM roles";
                                                            $result = mysqli_query($dbh, $sql);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                echo "<option value='" . $row['role'] . "'>" . $row['role']  . " > " . $row['faculty'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Submit Button -->
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
<?php } ?>