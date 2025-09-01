<?php
include 'db_connect.php';

$name = $conn->real_escape_string($_POST['name']);
$phone = $conn->real_escape_string($_POST['phone']);
$email = $conn->real_escape_string($_POST['email']);
$address = $conn->real_escape_string($_POST['address']);

$sql = "INSERT INTO Owners (name, phone, email, address) 
        VALUES ('$name', '$phone', '$email', '$address')";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
    exit();
} else {
    echo "❌ Error: " . $conn->error;
}
?>