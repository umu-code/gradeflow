<?php
// Include the config file for database connection
include('includes/config.php');

// Check if courseId is set and fetch students
if (isset($_POST['courseId'])) {
    $courseId = $_POST['courseId'];

    // Query to fetch students based on the selected course
    $sql = "SELECT StudentId, RegistrationNumber, StudentName 
            FROM Students WHERE CourseId = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("i", $courseId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Output student options
    if ($result->num_rows > 0) {
        echo "<option value=''>Select Student</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['StudentId'] . "'>" . $row['RegistrationNumber'] . " - " . $row['StudentName'] . "</option>";
        }
    } else {
        echo "<option value=''>No students found for this course</option>";
    }
}
?>
