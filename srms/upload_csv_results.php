<?php

// Database connection
include('includes/config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['csv_file']['tmp_name'];
        $fileName = $_FILES['csv_file']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        if ($fileExtension === 'csv') {
            // Open the CSV file
            $file = fopen($fileTmpPath, 'r');

            // Skip the header row
            fgetcsv($file);

            // Insert data into the database
            while (($row = fgetcsv($file)) !== false) {
                // Example CSV columns: StudentID, Name, Subject, Marks
                $studentID = $row[0];
                $course = $row[1];
                $courseunit = $row[2];
                $coursemarks = $row[3];
                $finalmarks = $row[4];
                $totalMarks = $row[5];
                $year = $row[6];

                $stmt = $dbh->prepare("INSERT INTO results (RegistrationNumber, CourseId, CourseUnitId, CourseworkMarks, FinalAssesmentmarks, TotalMarks, Year) 
                                       VALUES (:student_id, :course, :courseunit, :coursemarks,:finalmarks, :totalMarks , :year)");
                $stmt->execute([
                    ':student_id' => $studentID,
                    ':course' => $course,
                    ':courseunit' => $courseunit,
                    ':coursemarks' => $coursemarks,
                    ':finalmarks' => $finalmarks,
                    ':totalMarks' => $totalMarks,
                    ':year' => $year,
                ]);
            }

            fclose($file);
            echo "CSV file processed successfully!";
        } else {
            echo "Invalid file format. Please upload a CSV file.";
        }
    } else {
        echo "Error uploading file.";
    }
}
?>
<!-- upload_form.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Upload Student Results</title>
	<link href="images/umu.png" rel="shortcut icon" type="image/x-icon">
</head>
<body>
    <h1>Upload CSV</h1>
    <form action="upload_csv_results.php" method="post" enctype="multipart/form-data">
        <label for="file">Choose CSV File:</label>
        <input type="file" name="csv_file" id="file" accept=".csv" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>

