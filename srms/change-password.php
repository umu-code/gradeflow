<?php
session_start();
error_reporting(0);
include('includes/config.php'); // Ensure this includes mysqli connection setup

if (!isset($_SESSION['alogin']) || strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $password = md5($_POST['password']);
        $newpassword = md5($_POST['newpassword']);
        $username = $_SESSION['alogin'];

        // Check if current password is correct
        $sql = "SELECT Password FROM admin WHERE UserName = '$username' AND Password = '$password'";
        $result = mysqli_query($dbh, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Update password
            $con = "UPDATE admin SET Password = '$newpassword' WHERE UserName = '$username'";
            if (mysqli_query($dbh, $con)) {
                $msg = "Your Password successfully changed";
            } else {
                $error = "Error updating password. Please try again.";
            }
        } else {
            $error = "Your current password is incorrect";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Change Password</title>
    <!-- CSS and JavaScript files -->
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script type="text/javascript">
        function valid() {
            if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
                alert("New Password and Confirm Password do not match!");
                document.chngpwd.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <div class="container">
        <h2 class="text-center">Change Password</h2>
        <?php if (isset($msg)) { ?>
            <div class="alert alert-success" role="alert">
                <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
            </div>
        <?php } else if (isset($error)) { ?>
            <div class="alert alert-danger" role="alert">
                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
            </div>
        <?php } ?>

        <form name="chngpwd" method="post" onSubmit="return valid();">
            <div class="form-group">
                <label for="current-password" class="control-label">Current Password</label>
                <input type="password" name="password" class="form-control" required="required" id="current-password">
            </div>
            <div class="form-group">
                <label for="new-password" class="control-label">New Password</label>
                <input type="password" name="newpassword" required="required" class="form-control" id="new-password">
            </div>
            <div class="form-group">
                <label for="confirm-password" class="control-label">Confirm Password</label>
                <input type="password" name="confirmpassword" class="form-control" required="required" id="confirm-password">
            </div>
            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-success btn-labeled">Change
                    <span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                </button>
            </div>
        </form>
    </div>

    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
</body>

</html>
<?php  ?>
