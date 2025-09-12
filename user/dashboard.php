<?php
require_once '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user_id'];

// Get user's favorites
$favorites = $conn->query("SELECT p.*, uf.created_at as favorited_at 
                          FROM User_Favorites uf 
                          JOIN Properties p ON uf.property_id = p.property_id 
                          WHERE uf.user_id = $user_id 
                          ORDER BY uf.created_at DESC");

// Get user info
$user_info = $conn->query("SELECT * FROM Users WHERE user_id = $user_id")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - Real Estate System</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="user-nav">
        <div class="nav-brand">Real Estate System</div>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="search.php">Search Properties</a>
            <a href="favorites.php">My Favorites</a>
            <a href="../index.php">All Properties</a>
            <a href="../includes/auth.php?logout=1">Logout</a>
        </div>
    </nav>

    <div class="container">
        <h1>Welcome, <?= $user_info['full_name'] ?>!</h1>
        
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>My Favorites</h3>
                <p><?= $favorites->num_rows ?> properties saved</p>
                <a href="favorites.php" class="btn-primary">View All</a>
            </div>
            
            <div class="dashboard-card">
                <h3>Search Properties</h3>
                <p>Find your dream home</p>
                <a href="search.php" class="btn-primary">Start Search</a>
            </div>
            
            <div class="dashboard-card">
                <h3>Profile</h3>
                <p>Manage your account</p>
                <a href="profile.php" class="btn-primary">Edit Profile</a>
            </div>
        </div>

        <div class="recent-favorites">
            <h2>Recent Favorites</h2>
            <div class="properties-grid">
                <?php while ($property = $favorites->fetch_assoc()): ?>
                <div class="property-card">
                    <h3><?= $property['title'] ?></h3>
                    <p>$<?= number_format($property['price']) ?></p>
                    <p><?= $property['location'] ?></p>
                    <p>Added: <?= date('M j, Y', strtotime($property['favorited_at'])) ?></p>
                    <a href="../property_details.php?id=<?= $property['property_id'] ?>" class="btn-secondary">View Details</a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <style>
    .user-nav {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .nav-brand { font-weight: bold; font-size: 1.2rem; }
    .nav-links a { margin-left: 1rem; text-decoration: none; color: inherit; }
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin: 2rem 0;
    }
    .dashboard-card {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        padding: 2rem;
        border-radius: 15px;
        text-align: center;
    }
    .properties-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
        margin: 1rem 0;
    }
    .property-card {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        padding: 1rem;
        border-radius: 10px;
    }
    </style>
</body>
</html>
