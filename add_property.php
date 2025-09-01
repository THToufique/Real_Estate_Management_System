<?php
include 'db_connect.php';
$owners = $conn->query("SELECT owner_id, name FROM Owners");
$agents = $conn->query("SELECT agent_id, name FROM Agents WHERE status = 'Active'");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Property • Real Estate Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Property</h1>
        <form action="insert_property.php" method="POST" class="form">
            <label>Owner</label>
            <select name="owner_id" required>
                <option value="">Select Owner</option>
                <?php while ($owner = $owners->fetch_assoc()): ?>
                    <option value="<?= $owner['owner_id'] ?>"><?= htmlspecialchars($owner['name']) ?></option>
                <?php endwhile; ?>
            </select>
            <label>Agent</label>
            <select name="agent_id">
                <option value="">Select Agent (Optional)</option>
                <?php while ($agent = $agents->fetch_assoc()): ?>
                    <option value="<?= $agent['agent_id'] ?>"><?= htmlspecialchars($agent['name']) ?></option>
                <?php endwhile; ?>
            </select>
            <label>Address</label>
            <input type="text" name="address" required>
            <label>City</label>
            <input type="text" name="city" required>
            <label>State</label>
            <input type="text" name="state" required>
            <label>Zipcode</label>
            <input type="text" name="zipcode">
            <label>Property Type</label>
            <select name="property_type" required>
                <option value="House">House</option>
                <option value="Apartment">Apartment</option>
                <option value="Commercial">Commercial</option>
                <option value="Land">Land</option>
            </select>
            <label>Bedrooms</label>
            <input type="number" name="bedrooms" required>
            <label>Bathrooms</label>
            <input type="number" name="bathrooms" required>
            <label>Area (sqft)</label>
            <input type="number" step="0.01" name="area_sqft" required>
            <label>Price</label>
            <input type="number" step="0.01" name="price" required>
            <label>Description</label>
            <textarea name="description" placeholder="Property description (optional)"></textarea>
            <div class="form-actions">
                <button type="submit" class="btn success">Add Property</button>
            </div>
        </form>
        <a href="index.php" class="back-link">← Back to List</a>
    </div>
</body>
</html>