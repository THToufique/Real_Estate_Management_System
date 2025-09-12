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
$budget_min = empty($_POST['budget_min']) ? 'NULL' : floatval($_POST['budget_min']);
$budget_max = empty($_POST['budget_max']) ? 'NULL' : floatval($_POST['budget_max']);
$preferred_location = $conn->real_escape_string($_POST['preferred_location']);
$customer_type = $conn->real_escape_string($_POST['customer_type']);

$sql = "INSERT INTO Customers (name, phone, email, budget_min, budget_max, preferred_location, customer_type)
        VALUES ('$name', '$phone', '$email', $budget_min, $budget_max, '$preferred_location', '$customer_type')";

if ($conn->query($sql) === TRUE) {
    header("Location: admin/dashboard.php");
    exit();
} else {
    echo "❌ Error: " . $conn->error;
}
?>