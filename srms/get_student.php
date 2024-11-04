<?php
include('includes/config.php');

if (!empty($_POST["classid"])) {
    $cid = intval($_POST['classid']);
    if (!is_numeric($cid)) {
        echo htmlentities("invalid Class");
        exit;
    } else {
        $stmt = mysqli_prepare($dbh, "SELECT StudentName, StudentId FROM tblstudents WHERE ClassId = ? ORDER BY StudentName");
        mysqli_stmt_bind_param($stmt, 'i', $cid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        echo "<option value=''>Select Student</option>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . htmlentities($row['StudentId']) . "'>" . htmlentities($row['StudentName']) . "</option>";
        }
        mysqli_stmt_close($stmt);
    }
}

// Code for Subjects
if (!empty($_POST["classid1"])) {
    $cid1 = intval($_POST['classid1']);
    if (!is_numeric($cid1)) {
        echo htmlentities("invalid Class");
        exit;
    } else {
        $status = 0;
        $stmt = mysqli_prepare($dbh, "SELECT tblsubjects.SubjectName, tblsubjects.id 
                                      FROM tblsubjectcombination 
                                      JOIN tblsubjects ON tblsubjects.id = tblsubjectcombination.SubjectId 
                                      WHERE tblsubjectcombination.ClassId = ? AND tblsubjectcombination.status != ? 
                                      ORDER BY tblsubjects.SubjectName");
        mysqli_stmt_bind_param($stmt, 'ii', $cid1, $status);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<p>" . htmlentities($row['SubjectName']) . "<input type='text' name='marks[]' value='' class='form-control' required='' placeholder='Enter marks out of 100' autocomplete='off'></p>";
        }
        mysqli_stmt_close($stmt);
    }
}

if (!empty($_POST["studclass"])) {
    $id = $_POST['studclass'];
    $dta = explode("$", $id);
    $id = $dta[0];
    $id1 = $dta[1];

    $stmt = mysqli_prepare($dbh, "SELECT StudentId, ClassId FROM tblresult WHERE StudentId = ? AND ClassId = ?");
    mysqli_stmt_bind_param($stmt, 'ii', $id1, $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "<p><span style='color:red'> Result Already Declared.</span>";
        echo "<script>$('#submit').prop('disabled', true);</script></p>";
    }
    mysqli_stmt_close($stmt);
}
?>
