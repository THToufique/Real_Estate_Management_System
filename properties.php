<?php
include 'db_connect.php';

$result = $conn->query("SELECT p.*, a.name AS agent_name, o.name AS owner_name 
                        FROM Properties p 
                        LEFT JOIN Agents a ON p.agent_id = a.agent_id 
                        LEFT JOIN Owners o ON p.owner_id = o.owner_id 
                        WHERE p.status = 'Available' 
                        ORDER BY p.property_id");

// Get statistics
$stats = [];
$stats['total_properties'] = $conn->query("SELECT COUNT(*) as count FROM Properties")->fetch_assoc()['count'];
$stats['available_properties'] = $conn->query("SELECT COUNT(*) as count FROM Properties WHERE status = 'Available'")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properties - Real Estate System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="main-nav">
        <div class="nav-brand">Real Estate System</div>
        <div class="nav-links">
            <a href="properties.php">Browse Properties</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </div>
    </nav>

    <div class="container">
        <h1>Available Properties</h1>
        <p class="subtitle">Browse our collection of <?= $stats['available_properties'] ?> available properties</p>
        
        <div class="login-prompt">
            <p>🔐 <a href="login.php">Login</a> or <a href="register.php">Register</a> to save favorites and access advanced search!</p>
        </div>

        <div class="properties-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="property-card">
                <div class="property-header">
                    <h3><?= $row['title'] ?></h3>
                    <span class="property-type"><?= $row['property_type'] ?></span>
                </div>
                
                <div class="property-details">
                    <p class="price">$<?= number_format($row['price']) ?></p>
                    <p class="location">📍 <?= $row['location'] ?></p>
                    <p class="specs">🏠 <?= $row['bedrooms'] ?> bed • 🚿 <?= $row['bathrooms'] ?> bath • 📐 <?= $row['area'] ?> sq ft</p>
                </div>
                
                <div class="property-info">
                    <p><strong>Agent:</strong> <?= $row['agent_name'] ?></p>
                    <p><strong>Owner:</strong> <?= $row['owner_name'] ?></p>
                </div>
                
                <div class="property-actions">
                    <a href="login.php" class="btn-primary">Login to Contact</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <style>
    .login-prompt {
        background: rgba(255, 193, 7, 0.2);
        border: 1px solid rgba(255, 193, 7, 0.5);
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        margin: 2rem 0;
    }
    .login-prompt a {
        color: #ffc107;
        font-weight: bold;
        text-decoration: none;
    }
    .login-prompt a:hover {
        text-decoration: underline;
    }
    </style>
</body>
</html>
