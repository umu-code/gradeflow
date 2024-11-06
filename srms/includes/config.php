<?php 
// DB credentials.
$servername = 'localhost';
$username = 'root';
$password = 'p@ss1234';
$db_name = 'srms_version_1';

$dbh = mysqli_connect($servername, $username, $password, $db_name);


// Check the connection
if (!$dbh) {
    exit("Error: " . mysqli_connect_error());
}
?>