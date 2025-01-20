<?php
// Set headers to prompt a file download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="student_results_template.csv"');

// Open output stream
$output = fopen('php://output', 'w');

// Add the header row to the CSV
fputcsv($output, ['RegistrationNumber','CourseId', 'CourseUnitId', 'CourseworkMarks','FinalAssessmentmarks','TotalMarks','Year']);

// Optionally, add some sample rows as examples
fputcsv($output, ['s13' , 16, 15, 40, 30 , 70 , 2]);

// Close the output stream
fclose($output);
exit;

?>