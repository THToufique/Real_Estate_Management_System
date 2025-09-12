<?php
require_once '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user_id'];

// Handle remove from favorites
if ($_POST && isset($_POST['remove_favorite'])) {
    $property_id = $_POST['property_id'];
    $stmt = $conn->prepare("DELETE FROM User_Favorites WHERE user_id = ? AND property_id = ?");
    $stmt->bind_param("ii", $user_id, $property_id);
    $stmt->execute();
}

// Get user's favorites
$favorites = $conn->query("SELECT p.*, uf.created_at as favorited_at, a.name as agent_name 
                          FROM User_Favorites uf 
                          JOIN Properties p ON uf.property_id = p.property_id 
                          LEFT JOIN Agents a ON p.agent_id = a.agent_id
                          WHERE uf.user_id = $user_id 
                          ORDER BY uf.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Favorites - Real Estate System</title>
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
        <h1>My Favorite Properties</h1>
        
        <?php if ($favorites->num_rows == 0): ?>
            <div class="empty-state">
                <h3>No favorites yet!</h3>
                <p>Start browsing properties and add them to your favorites.</p>
                <a href="search.php" class="btn-primary">Search Properties</a>
            </div>
        <?php else: ?>
            <div class="favorites-grid">
                <?php while ($property = $favorites->fetch_assoc()): ?>
                <div class="property-card">
                    <div class="property-header">
                        <h3><?= $property['title'] ?></h3>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="property_id" value="<?= $property['property_id'] ?>">
                            <button type="submit" name="remove_favorite" class="remove-btn" title="Remove from favorites">×</button>
                        </form>
                    </div>
                    
                    <p class="price">$<?= number_format($property['price']) ?></p>
                    <p class="location"><?= $property['location'] ?></p>
                    <p class="details"><?= $property['bedrooms'] ?> bed, <?= $property['bathrooms'] ?> bath</p>
                    <p class="agent">Agent: <?= $property['agent_name'] ?></p>
                    <p class="favorited">Added: <?= date('M j, Y', strtotime($property['favorited_at'])) ?></p>
                    
                    <div class="property-actions">
                        <a href="../property_details.php?id=<?= $property['property_id'] ?>" class="btn-primary">View Details</a>
                        <span class="status <?= strtolower($property['status']) ?>"><?= $property['status'] ?></span>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
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
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        margin: 2rem 0;
    }
    
    .favorites-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 1.5rem;
        margin: 2rem 0;
    }
    
    .property-card {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 15px;
        border: 1px solid rgba(255,255,255,0.2);
        transition: transform 0.3s ease;
    }
    
    .property-card:hover {
        transform: translateY(-5px);
    }
    
    .property-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    
    .property-header h3 {
        margin: 0;
        flex: 1;
    }
    
    .remove-btn {
        background: #ff4757;
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        cursor: pointer;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .price { 
        font-size: 1.3rem; 
        font-weight: bold; 
        color: #2ecc71; 
        margin-bottom: 0.5rem;
    }
    
    .location { 
        color: #ecf0f1; 
        margin-bottom: 0.5rem;
    }
    
    .details, .agent, .favorited { 
        color: #bdc3c7; 
        font-size: 0.9rem; 
        margin-bottom: 0.3rem;
    }
    
    .property-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(255,255,255,0.1);
    }
    
    .status {
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .status.available {
        background: #27ae60;
        color: white;
    }
    
    .status.sold {
        background: #e74c3c;
        color: white;
    }
    </style>
</body>
</html>
