<?php
require_once '../includes/auth.php';
requireLogin();

$search_query = "SELECT p.*, a.name as agent_name FROM Properties p LEFT JOIN Agents a ON p.agent_id = a.agent_id WHERE 1=1";
$params = [];

if ($_GET) {
    if (!empty($_GET['location'])) {
        $search_query .= " AND p.location LIKE ?";
        $params[] = "%" . $_GET['location'] . "%";
    }
    if (!empty($_GET['min_price'])) {
        $search_query .= " AND p.price >= ?";
        $params[] = $_GET['min_price'];
    }
    if (!empty($_GET['max_price'])) {
        $search_query .= " AND p.price <= ?";
        $params[] = $_GET['max_price'];
    }
    if (!empty($_GET['property_type'])) {
        $search_query .= " AND p.property_type = ?";
        $params[] = $_GET['property_type'];
    }
    if (!empty($_GET['bedrooms'])) {
        $search_query .= " AND p.bedrooms >= ?";
        $params[] = $_GET['bedrooms'];
    }
}

$search_query .= " AND p.status = 'Available' ORDER BY p.property_id DESC";

$stmt = $conn->prepare($search_query);
if (!empty($params)) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$properties = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Properties - Real Estate System</title>
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
        <h1>Search Properties</h1>
        
        <div class="search-form glass-card">
            <form method="GET">
                <div class="form-row">
                    <div class="form-group">
                        <label>Location:</label>
                        <input type="text" name="location" value="<?= $_GET['location'] ?? '' ?>" placeholder="Enter location">
                    </div>
                    
                    <div class="form-group">
                        <label>Property Type:</label>
                        <select name="property_type">
                            <option value="">Any Type</option>
                            <option value="House" <?= ($_GET['property_type'] ?? '') == 'House' ? 'selected' : '' ?>>House</option>
                            <option value="Apartment" <?= ($_GET['property_type'] ?? '') == 'Apartment' ? 'selected' : '' ?>>Apartment</option>
                            <option value="Condo" <?= ($_GET['property_type'] ?? '') == 'Condo' ? 'selected' : '' ?>>Condo</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Min Price:</label>
                        <input type="number" name="min_price" value="<?= $_GET['min_price'] ?? '' ?>" placeholder="0">
                    </div>
                    
                    <div class="form-group">
                        <label>Max Price:</label>
                        <input type="number" name="max_price" value="<?= $_GET['max_price'] ?? '' ?>" placeholder="1000000">
                    </div>
                    
                    <div class="form-group">
                        <label>Min Bedrooms:</label>
                        <select name="bedrooms">
                            <option value="">Any</option>
                            <option value="1" <?= ($_GET['bedrooms'] ?? '') == '1' ? 'selected' : '' ?>>1+</option>
                            <option value="2" <?= ($_GET['bedrooms'] ?? '') == '2' ? 'selected' : '' ?>>2+</option>
                            <option value="3" <?= ($_GET['bedrooms'] ?? '') == '3' ? 'selected' : '' ?>>3+</option>
                            <option value="4" <?= ($_GET['bedrooms'] ?? '') == '4' ? 'selected' : '' ?>>4+</option>
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="btn-primary">Search</button>
                <a href="search.php" class="btn-secondary">Clear</a>
            </form>
        </div>

        <div class="search-results">
            <h2>Search Results (<?= $properties->num_rows ?> properties found)</h2>
            <div class="properties-grid">
                <?php while ($property = $properties->fetch_assoc()): ?>
                <div class="property-card">
                    <h3><?= $property['title'] ?></h3>
                    <p class="price">$<?= number_format($property['price']) ?></p>
                    <p><?= $property['location'] ?></p>
                    <p><?= $property['bedrooms'] ?> bed, <?= $property['bathrooms'] ?> bath</p>
                    <p>Agent: <?= $property['agent_name'] ?></p>
                    
                    <div class="property-actions">
                        <form method="POST" action="add_favorite.php" style="display:inline;">
                            <input type="hidden" name="property_id" value="<?= $property['property_id'] ?>">
                            <button type="submit" class="btn-small">♥ Add to Favorites</button>
                        </form>
                        <a href="../property_details.php?id=<?= $property['property_id'] ?>" class="btn-small">View Details</a>
                    </div>
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
    .search-form { margin: 2rem 0; padding: 2rem; }
    .form-row { display: flex; gap: 1rem; margin-bottom: 1rem; }
    .form-group { flex: 1; }
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
    .price { font-size: 1.2rem; font-weight: bold; color: #2ecc71; }
    .property-actions { margin-top: 1rem; }
    .btn-small { padding: 0.5rem 1rem; font-size: 0.9rem; margin-right: 0.5rem; }
    </style>
</body>
</html>
