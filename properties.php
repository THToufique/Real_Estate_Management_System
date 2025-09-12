<?php
session_start();
include 'db_connect.php';

$isLoggedIn = isset($_SESSION['user_id']);

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="main-nav">
        <div class="nav-brand">Real Estate System</div>
        <div class="nav-links">
            <a href="properties.php">Browse Properties</a>
            <?php if ($isLoggedIn): ?>
                <a href="user/dashboard.php">Dashboard</a>
                <a href="includes/auth.php?logout=1">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">
        <h1>Available Properties</h1>
        <p class="subtitle">Browse our collection of <?= $stats['available_properties'] ?> available properties</p>
        
        <?php if (!$isLoggedIn): ?>
        <div class="login-prompt">
            <p>🔐 <a href="login.php">Login</a> or <a href="register.php">Register</a> to save favorites and access advanced search!</p>
        </div>
        <?php endif; ?>

        <div class="properties-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="property-card">
                <div class="property-header">
                    <h3><?= $row['title'] ?></h3>
                    <span class="property-type"><?= $row['property_type'] ?></span>
                </div>
                
                <div class="property-details">
                    <p class="price">$<?= number_format($row['price']) ?></p>
                    <p class="location">📍 <?= $row['location'] ?: 'Location not specified' ?></p>
                    <p class="specs">🏠 <?= $row['bedrooms'] ?> bed • 🚿 <?= $row['bathrooms'] ?> bath • 📐 <?= $row['area'] ? $row['area'] . ' sq ft' : 'Area not specified' ?></p>
                </div>
                
                <div class="property-info">
                    <p><strong>Agent:</strong> <?= $row['agent_name'] ?: 'N/A' ?></p>
                    <p><strong>Owner:</strong> <?= $row['owner_name'] ?: 'N/A' ?></p>
                </div>
                
                <div class="property-actions">
                    <a href="property_details.php?id=<?= $row['property_id'] ?>" class="btn-secondary">View Details</a>
                    <?php if ($isLoggedIn): ?>
                        <button class="btn-primary" onclick="quickContact(<?= $row['property_id'] ?>, '<?= addslashes($row['agent_name']) ?>')">Contact Agent</button>
                    <?php else: ?>
                        <a href="login.php" class="btn-primary">Login to Contact</a>
                    <?php endif; ?>
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

    <script>
    function quickContact(propertyId, agentName) {
        Swal.fire({
            title: 'Contact Agent',
            html: `<p style="color: #333;">Send a quick message to <strong>${agentName}</strong> about this property.</p>`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Send Message',
            cancelButtonText: 'View Details',
            confirmButtonColor: '#667eea',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Message Sent!',
                    text: 'Your interest has been sent to the agent. They will contact you soon.',
                    icon: 'success',
                    confirmButtonColor: '#667eea'
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                window.location.href = `property_details.php?id=${propertyId}`;
            }
        });
    }
    </script>
</body>
</html>
