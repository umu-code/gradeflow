<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (!isset($_SESSION['alogin']) || strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    $stid = intval($_GET['id']);

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
        // Update query using MySQLi
        $sql = "UPDATE admins SET UserName=?, Password=?, adminEmail=?, role=?, contacts=? WHERE id=?";
        $stmt = $dbh->prepare($sql);
        $stmt->bind_param('sssssi', $name, $password, $email, $role, $contacts, $stid);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $msg = "Admin info updated successfully";
        } else {
            $error = "Error updating admin info";
        }
        $stmt->close();
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
        <title>Gradeflow Technical Team | Edit Admin</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/prism/prism.css" media="screen">
        <link rel="stylesheet" href="css/select2/select2.min.css">
        <link rel="stylesheet" href="css/main.css" media="screen">
	    <link href="images/umu.png" rel="shortcut icon" type="image/x-icon">
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>

    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
            <?php include('includes/topbar.php'); ?>
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

                    <!-- ========== LEFT SIDEBAR ========== -->
                    <?php include('includes/leftbar.php'); ?>
                    <!-- /.left-sidebar -->

                    <div class="main-page">

                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Edit Admin Profile</h2>
                                </div>
                            </div>
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li class="active"><a href="manage-admin.php">Manage Admin</a></li>
                                        <li class="active">Admin Profile</li>
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
                                                <h5>Fill the Admin info</h5>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <?php if ($msg) { ?>
                                                <div class="alert alert-success left-icon-alert" role="alert">
                                                    <strong>Well done! &nbsp;</strong><?php echo htmlentities($msg); ?>
                                                </div>
                                            <?php } else if ($error) { ?>
                                                <div class="alert alert-danger left-icon-alert" role="alert">
                                                    <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                                </div>
                                            <?php } ?>

                                            <form class="form-horizontal" method="post">
                                                <?php
                                                $sql = "SELECT admins.UserName, admins.Password, admins.adminEmail, admins.role, admins.contacts, roles.role
                                                            FROM admins
                                                            LEFT JOIN roles ON roles.id = admins.id 
                                                            WHERE admins.id = ?";
                                                $stmt = $dbh->prepare($sql);
                                                $stmt->bind_param('i', $stid);
                                                $stmt->execute();
                                                $result = $stmt->get_result();

                                                if ($result->num_rows > 0) {
                                                    $row = $result->fetch_assoc();
                                                ?>

                                                    <!-- admin Name -->
                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Full Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="fullname" class="form-control" id="fullname"  value="<?php echo htmlentities($row['UserName']) ?>" required="required" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <!-- email -->
                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Email</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="adminEmail" class="form-control" id="adminEmail" maxlength="35"  value="<?php echo htmlentities($row['adminEmail']) ?>" required="required" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <!-- password -->
                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Password</label>
                                                        <div class="col-sm-10">
                                                            <input type="password" name="password" class="form-control" id="password" value="<?php echo htmlentities($row['Password']) ?>" required="required" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <!-- contacts -->
                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Contacts</label>
                                                        <div class="col-sm-10">
                                                            <input type="int" name="contacts" class="form-control" id="contacts" value="<?php echo htmlentities($row['contacts']) ?>" required="required" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <!--role-->
                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Role</label>
                                                        <div class="col-sm-10">
                                                            <select name="role" class="form-control" id="default" required="required">
                                                                <option value=""><?php echo htmlentities($row['role']) ?></option>
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
            <?php include('includes/footer.php'); ?>
        </div>
    </body>

    </html>
<?php
}
