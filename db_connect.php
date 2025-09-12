<?php
$host = "localhost";
$user = "webapp";
$password = "password123";
$database = "RealEstateDB";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>