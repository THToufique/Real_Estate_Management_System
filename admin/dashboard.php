<?php
require_once '../includes/auth.php';
requireAdmin();

// Get statistics
$stats = [];
$stats['properties'] = $conn->query("SELECT COUNT(*) as count FROM Properties")->fetch_assoc()['count'];
$stats['agents'] = $conn->query("SELECT COUNT(*) as count FROM Agents")->fetch_assoc()['count'];
$stats['customers'] = $conn->query("SELECT COUNT(*) as count FROM Customers")->fetch_assoc()['count'];
$stats['users'] = $conn->query("SELECT COUNT(*) as count FROM Users WHERE user_type = 'user'")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Real Estate System</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="admin-nav">
        <div class="nav-brand">Admin Panel</div>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="manage_properties.php">Properties</a>
            <a href="manage_users.php">Users</a>
            <a href="../index.php">View Site</a>
            <a href="../includes/auth.php?logout=1">Logout</a>
        </div>
    </nav>

    <div class="container">
        <h1>Admin Dashboard</h1>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3><?= $stats['properties'] ?></h3>
                <p>Total Properties</p>
            </div>
            <div class="stat-card">
                <h3><?= $stats['agents'] ?></h3>
                <p>Total Agents</p>
            </div>
            <div class="stat-card">
                <h3><?= $stats['customers'] ?></h3>
                <p>Total Customers</p>
            </div>
            <div class="stat-card">
                <h3><?= $stats['users'] ?></h3>
                <p>Registered Users</p>
            </div>
        </div>

        <div class="admin-actions">
            <a href="../add_property.php" class="btn-primary">Add Property</a>
            <a href="../add_agent.php" class="btn-primary">Add Agent</a>
            <a href="../add_customer.php" class="btn-primary">Add Customer</a>
            <a href="../db_inspector.php" class="btn-secondary">Database Inspector</a>
        </div>
    </div>

    <style>
    .admin-nav {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .nav-brand { font-weight: bold; font-size: 1.2rem; }
    .nav-links a { margin-left: 1rem; text-decoration: none; color: inherit; }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin: 2rem 0;
    }
    .stat-card {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        padding: 2rem;
        border-radius: 15px;
        text-align: center;
    }
    .stat-card h3 { font-size: 2rem; margin: 0; }
    .admin-actions { margin: 2rem 0; }
    .admin-actions a { margin-right: 1rem; }
    </style>
</body>
</html>
