<?php
session_start();
error_reporting(0);
include('includes/config.php'); // Ensure this includes mysqli connection setup
if(strlen($_SESSION['alogin']) == "") {   
    header("Location: index.php"); 
} else {
    if(isset($_POST['submit'])) {
        $password = md5($_POST['password']);
        $newpassword = md5($_POST['newpassword']);
        $username = $_SESSION['alogin'];

        // Check if current password is correct
        $sql = "SELECT Password FROM admin WHERE UserName = '$username' AND Password = '$password'";
        $result = mysqli_query($dbh, $sql);

        if(mysqli_num_rows($result) > 0) {
            // Update password
            $con = "UPDATE admin SET Password = '$newpassword' WHERE UserName = '$username'";
            if(mysqli_query($dbh, $con)) {
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
    <title>Admin change password</title>
    <!-- CSS and JavaScript files -->
    <script type="text/javascript">
        function valid() {
            if(document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
                alert("New Password and Confirm Password do not match!");
                document.chngpwd.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <!-- Content and form HTML here -->
    <?php if($msg) { ?>
        <div class="alert alert-success" role="alert">
            <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
        </div>
    <?php } else if($error) { ?>
        <div class="alert alert-danger" role="alert">
            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
        </div>
    <?php } ?>
    
    <form name="chngpwd" method="post" onSubmit="return valid();">
        <!-- Form fields for password, new password, and confirm password -->
    </form>
</body>
</html>
<?php  ?>
