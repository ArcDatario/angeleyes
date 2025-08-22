<?php
$host = 'localhost';
$db   = 'angeleyes'; // Change this to your database name
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);
     
 


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset($charset);
?>
