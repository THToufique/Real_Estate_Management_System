<?php
require_once '../includes/auth.php';
requireLogin();

if ($_POST && isset($_POST['property_id'])) {
    $user_id = $_SESSION['user_id'];
    $property_id = $_POST['property_id'];
    
    // Check if already favorited
    $check = $conn->prepare("SELECT * FROM User_Favorites WHERE user_id = ? AND property_id = ?");
    $check->bind_param("ii", $user_id, $property_id);
    $check->execute();
    
    if ($check->get_result()->num_rows == 0) {
        // Add to favorites
        $stmt = $conn->prepare("INSERT INTO User_Favorites (user_id, property_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $property_id);
        $stmt->execute();
        $message = "Property added to favorites!";
    } else {
        $message = "Property already in favorites!";
    }
}

header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'search.php') . "?message=" . urlencode($message));
exit();
?>
