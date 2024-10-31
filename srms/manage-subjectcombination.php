<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Redirect to login page if not logged in
if(strlen($_SESSION['alogin']) == "") {   
    header("Location: index.php"); 
    exit; // Always use exit after header redirection
} else {
    // Activate Subject
    if(isset($_GET['acid'])) {
        $acid = intval($_GET['acid']);
        $status = 1;
        $sql = "UPDATE tblsubjectcombination SET status = :status WHERE id = :acid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':acid', $acid, PDO::PARAM_INT);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        
        if($query->execute()) {
            $msg = "Subject activated successfully.";
        } else {
            $error = "Failed to activate subject.";
        }
    }

    // Deactivate Subject
    if(isset($_GET['did'])) {
        $did = intval($_GET['did']);
        $status = 0;
        $sql = "UPDATE tblsubjectcombination SET status = :status WHERE id = :did";
        $query = $dbh->prepare($sql);
        $query->bindParam(':did', $did, PDO::PARAM_INT);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        
        if($query->execute()) {
            $msg = "Subject deactivated successfully.";
        } else {
            $error = "Failed to deactivate subject.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Manage Subjects Combination</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen"> 
    <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>
</head>
<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php');?> 
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/leftbar.php');?>  

                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Manage Subjects Combination</h2>
                            </div>
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li>Subjects</li>
                                    <li class="active">Manage Subjects Combination</li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->

                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>View Subjects Combination Info</h5>
                                            </div>
                                        </div>
                                        <?php if(isset($msg)) { ?>
                                            <div class="alert alert-success left-icon-alert" role="alert">
                                                <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                            </div>
                                        <?php } elseif(isset($error)) { ?>
                                            <div class="alert alert-danger left-icon-alert" role="alert">
                                                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                            </div>
                                        <?php } ?>
                                        <div class="panel-body p-20">
                                            <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Class and Section</th>
                                                        <th>Subject</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Class and Section</th>
                                                        <th>Subject</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                <?php 
                                                    $sql = "SELECT tblclasses.ClassName, tblclasses.Section, tblsubjects.SubjectName, tblsubjectcombination.id as scid, tblsubjectcombination.status 
                                                            FROM tblsubjectcombination 
                                                            JOIN tblclasses ON tblclasses.id = tblsubjectcombination.ClassId  
                                                            JOIN tblsubjects ON tblsubjects.id = tblsubjectcombination.SubjectId";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    $cnt = 1;
                                                    if($query->rowCount() > 0) {
                                                        foreach($results as $result) { ?>
                                                            <tr>
                                                                <td><?php echo htmlentities($cnt); ?></td>
                                                                <td><?php echo htmlentities($result->ClassName); ?> &nbsp; Section - <?php echo htmlentities($result->Section); ?></td>
                                                                <td><?php echo htmlentities($result->SubjectName); ?></td>
                                                                <td><?php echo $result->status == '0' ? htmlentities('Inactive') : htmlentities('Active'); ?></td>
                                                                <td>
                                                                    <?php if($result->status == '0') { ?>
                                                                        <a href="manage-subjectcombination.php?acid=<?php echo htmlentities($result->scid); ?>" onclick="return confirm('Do you really want to activate this subject?');">
                                                                            <i class="fa fa-check" title="Activate Record"></i>
                                                                        </a>
                                                                    <?php } else { ?>
                                                                        <a href="manage-subjectcombination.php?did=<?php echo htmlentities($result->scid); ?>" onclick="return confirm('Do you really want to deactivate this subject?');">
                                                                            <i class="fa fa-times" title="Deactivate Record"></i>
                                                                        </a>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                            <?php $cnt++; 
                                                        } 
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-md-12 -->
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
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <script src="js/prism/prism.js"></script>
    <script src="js/DataTables/datatables.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(function($) {
            $('#example').DataTable();
        });
    </script>
</body>
</html>
<?php } ?>
