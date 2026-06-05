<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "budget_tracker";

// Create a connection to the database
$conn = mysqli_connect($host, $user, $password, $database);

// Check if the connection worked
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>