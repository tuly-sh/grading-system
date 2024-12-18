<?php
$host = 'localhost'; // Database host
$db = 'grading-system'; // Database name
$user = 'root'; // Database username
$pass = ''; // Database password

// Create connection
$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
