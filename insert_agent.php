<?php
session_start();
include 'db_connect.php';

// Require admin access
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header("Location: login.php");
    exit();
}

$name = $conn->real_escape_string($_POST['name']);
$phone = $conn->real_escape_string($_POST['phone']);
$email = $conn->real_escape_string($_POST['email']);
$commission_rate = floatval($_POST['commission_rate']);
$hire_date = $conn->real_escape_string($_POST['hire_date']);
$experience_years = intval($_POST['experience_years']);

$sql = "INSERT INTO Agents (name, phone, email, commission_rate, hire_date, experience_years)
        VALUES ('$name', '$phone', '$email', $commission_rate, '$hire_date', $experience_years)";

if ($conn->query($sql) === TRUE) {
    header("Location: admin/dashboard.php");
    exit();
} else {
    echo "❌ Error: " . $conn->error;
}
?>