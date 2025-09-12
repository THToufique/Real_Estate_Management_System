<?php
session_start();
require_once __DIR__ . '/../db_connect.php';

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    // Check if we're in admin/user directory or root
    $redirect_path = (strpos($_SERVER['HTTP_REFERER'], '/admin/') !== false || strpos($_SERVER['HTTP_REFERER'], '/user/') !== false) ? '../login.php' : 'login.php';
    header("Location: $redirect_path");
    exit();
}

function login($username, $password) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT user_id, username, password_hash, user_type, status FROM Users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        if ($user['status'] == 'active' && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];
            
            // Update last login
            $update_stmt = $conn->prepare("UPDATE Users SET last_login = NOW() WHERE user_id = ?");
            $update_stmt->bind_param("i", $user['user_id']);
            $update_stmt->execute();
            
            return true;
        }
    }
    return false;
}

function register($username, $email, $password, $full_name, $phone = '') {
    global $conn;
    
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO Users (username, email, password_hash, full_name, phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $password_hash, $full_name, $phone);
    
    return $stmt->execute();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin';
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: ../login.php");
        exit();
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        header("Location: ../index.php");
        exit();
    }
}

function logout() {
    session_destroy();
    header("Location: ../login.php");
    exit();
}
?>
