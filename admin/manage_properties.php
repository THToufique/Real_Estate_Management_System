<?php
require_once '../includes/auth.php';
requireAdmin();

// Handle property status updates
if ($_POST && isset($_POST['action'])) {
    $property_id = $_POST['property_id'];
    if ($_POST['action'] == 'toggle_status') {
        $conn->query("UPDATE Properties SET status = IF(status = 'Available', 'Sold', 'Available') WHERE property_id = $property_id");
    } elseif ($_POST['action'] == 'delete') {
        $conn->query("DELETE FROM Properties WHERE property_id = $property_id");
    }
}

$properties = $conn->query("SELECT p.*, a.name as agent_name, o.name as owner_name 
                           FROM Properties p 
                           LEFT JOIN Agents a ON p.agent_id = a.agent_id 
                           LEFT JOIN Owners o ON p.owner_id = o.owner_id 
                           ORDER BY p.property_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Properties - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <nav class="admin-nav">
        <div class="nav-brand">Admin Panel</div>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="manage_properties.php">Properties</a>
            <a href="manage_users.php">Users</a>
            <a href="../properties.php" target="_blank">Visit Site</a>
            <a href="../includes/auth.php?logout=1">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1>Manage Properties</h1>
            <a href="../add_property.php" class="btn-primary">➕ Add New Property</a>
        </div>
        
        <div class="properties-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Agent</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($property = $properties->fetch_assoc()): ?>
                    <tr>
                        <td><?= $property['property_id'] ?></td>
                        <td class="property-title"><?= $property['title'] ?></td>
                        <td><span class="property-type-badge"><?= $property['property_type'] ?></span></td>
                        <td class="price">$<?= number_format($property['price']) ?></td>
                        <td>
                            <span class="status-badge status-<?= strtolower($property['status']) ?>">
                                <?= $property['status'] ?>
                            </span>
                        </td>
                        <td><?= $property['agent_name'] ?: 'N/A' ?></td>
                        <td class="actions">
                            <a href="../edit_property.php?id=<?= $property['property_id'] ?>" class="btn-small btn-edit">✏️ Edit</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="property_id" value="<?= $property['property_id'] ?>">
                                <button type="submit" name="action" value="toggle_status" class="btn-small btn-toggle">
                                    <?= $property['status'] == 'Available' ? '✅ Mark Sold' : '🔄 Mark Available' ?>
                                </button>
                                <button type="button" class="btn-small btn-danger" 
                                        onclick="confirmDelete(<?= $property['property_id'] ?>, '<?= addslashes($property['title']) ?>')">🗑️ Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    function confirmDelete(propertyId, propertyTitle) {
        Swal.fire({
            title: 'Delete Property?',
            html: `Are you sure you want to delete:<br><strong>${propertyTitle}</strong>?<br><br>This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create and submit form
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="property_id" value="${propertyId}">
                    <input type="hidden" name="action" value="delete">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    </script>

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
    .properties-table { margin: 2rem 0; }
    table { width: 100%; border-collapse: collapse; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 10px; }
    th, td { padding: 1rem; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); }
    th { background: rgba(255,255,255,0.2); }
    .btn-small { padding: 0.3rem 0.6rem; font-size: 0.8rem; margin-right: 0.5rem; }
    .btn-danger { background: #ff4757; }
    </style>
</body>
</html>
