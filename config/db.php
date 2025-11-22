<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname   = "campus_crave";


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //helps debugging

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>