<?php
include('includes/config.php');

if (isset($_POST['courseId'])) {
    $courseId = $_POST['courseId'];

    $sql = "SELECT c.CourseUnitId, c.CourseUnitName 
            FROM CourseUnits c
            JOIN `course&courseunit_combination` ca 
            ON c.CourseUnitId = ca.CourseUnitId
            WHERE ca.CourseId = ?";  

    $stmt = $dbh->prepare($sql);
    if ($stmt === false) {
        echo "Error preparing the statement.";
        exit;
    }

    $stmt->bind_param("i", $courseId);  

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<option value=''>Select Course Unit</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['CourseUnitId'] . "'>" . $row['CourseUnitName'] . "</option>";
        }
    } else {
        echo "<option value=''>No course units found</option>";
    }

    $stmt->close();
}
?>
