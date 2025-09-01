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
$stats['total_agents'] = $conn->query("SELECT COUNT(*) as count FROM Agents WHERE status = 'Active'")->fetch_assoc()['count'];
$stats['total_owners'] = $conn->query("SELECT COUNT(*) as count FROM Owners")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property List • Real Estate Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Real Estate Management System</h1>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?= $stats['total_properties'] ?></div>
                <div class="stat-label">Total Properties</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $stats['available_properties'] ?></div>
                <div class="stat-label">Available</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $stats['total_agents'] ?></div>
                <div class="stat-label">Active Agents</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $stats['total_owners'] ?></div>
                <div class="stat-label">Owners</div>
            </div>
        </div>
        
        <div class="actions">
            <a href="add_property.php" class="btn">➕ Add Property</a>
            <a href="add_agent.php" class="btn">➕ Add Agent</a>
            <a href="add_customer.php" class="btn">➕ Add Customer</a>
            <a href="add_owner.php" class="btn">➕ Add Owner</a>
            <a href="db_inspector.php" class="btn">🗄️ DB Inspector</a>
            <a href="index.php" class="btn secondary">⟳ Refresh</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Address</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Agent</th>
                    <th>Owner</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['property_id'] ?></td>
                            <td><?= htmlspecialchars($row['address']) ?></td>
                            <td><?= $row['property_type'] ?></td>
                            <td>$<?= number_format($row['price'], 2) ?></td>
                            <td><?= $row['agent_name'] ? htmlspecialchars($row['agent_name']) : 'Unassigned' ?></td>
                            <td><?= htmlspecialchars($row['owner_name']) ?></td>
                            <td class="center">
                                <div class="table-actions">
                                    <a href="edit_property.php?id=<?= $row['property_id'] ?>" class="edit-link">✏️ Edit</a>
                                    <a href="delete_property.php?id=<?= $row['property_id'] ?>" class="delete-link"
                                       onclick="return confirm('Delete this property?');">🗑️ Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="center">No properties found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>