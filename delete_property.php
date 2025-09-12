<?php
session_start();
include 'db_connect.php';

// Require admin access
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header("Location: login.php");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    die("Invalid property ID.");
}

// Delete related records first to avoid foreign key constraint errors
$conn->query("DELETE FROM Property_Viewings WHERE property_id = $id");
$conn->query("DELETE FROM Property_Features WHERE property_id = $id");
$conn->query("DELETE FROM Property_Images WHERE property_id = $id");
$conn->query("DELETE FROM Property_Maintenance WHERE property_id = $id");
$conn->query("DELETE FROM Property_Documents WHERE property_id = $id");
$conn->query("DELETE FROM Offers WHERE property_id = $id");
$conn->query("DELETE FROM Transactions WHERE property_id = $id");

// Now delete the property
$sql = "DELETE FROM Properties WHERE property_id = $id";
if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
    exit();
} else {
    echo "❌ Error deleting record: " . $conn->error;
}
?>