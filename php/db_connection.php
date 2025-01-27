<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "webhive";

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>