<?php 
session_start();

$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "gym";

// Create connection
$conn = mysqli_connect($servername, $db_username, $db_password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>