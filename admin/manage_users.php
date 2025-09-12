<?php
require_once '../includes/auth.php';
requireAdmin();

// Handle user actions
if ($_POST && isset($_POST['action'])) {
    $user_id = $_POST['user_id'];
    if ($_POST['action'] == 'toggle_status') {
        $conn->query("UPDATE Users SET status = IF(status = 'active', 'inactive', 'active') WHERE user_id = $user_id");
    } elseif ($_POST['action'] == 'delete') {
        $conn->query("DELETE FROM Users WHERE user_id = $user_id");
    }
}

$users = $conn->query("SELECT * FROM Users ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin</title>
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
        <h1>Manage Users</h1>
        
        <div class="users-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= $user['user_id'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['full_name'] ?></td>
                        <td><?= ucfirst($user['user_type']) ?></td>
                        <td><?= ucfirst($user['status']) ?></td>
                        <td><?= date('M j, Y', strtotime($user['created_at'])) ?></td>
                        <td><?= $user['last_login'] ? date('M j, Y', strtotime($user['last_login'])) : 'Never' ?></td>
                        <td>
                            <?php if ($user['user_id'] != $_SESSION['user_id']): ?>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                <button type="submit" name="action" value="toggle_status" class="btn-small">
                                    <?= $user['status'] == 'active' ? 'Deactivate' : 'Activate' ?>
                                </button>
                                <button type="submit" name="action" value="delete" class="btn-small btn-danger" 
                                        onclick="return confirm('Delete this user?')">Delete</button>
                            </form>
                            <?php else: ?>
                                <span class="current-user">Current User</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
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
    .users-table { margin: 2rem 0; }
    table { width: 100%; border-collapse: collapse; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 10px; }
    th, td { padding: 1rem; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); }
    th { background: rgba(255,255,255,0.2); }
    .btn-small { padding: 0.3rem 0.6rem; font-size: 0.8rem; margin-right: 0.5rem; }
    .btn-danger { background: #ff4757; }
    .current-user { font-style: italic; color: #ffd700; }
    </style>
</body>
</html>
