<?php
require_once '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user_id'];

// Handle profile update
if ($_POST) {
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    
    $stmt = $conn->prepare("UPDATE Users SET full_name = ?, phone = ? WHERE user_id = ?");
    $stmt->bind_param("ssi", $full_name, $phone, $user_id);
    
    if ($stmt->execute()) {
        $success = "Profile updated successfully!";
    } else {
        $error = "Failed to update profile.";
    }
}

// Get user info
$user_info = $conn->query("SELECT * FROM Users WHERE user_id = $user_id")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Real Estate System</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="user-nav">
        <div class="nav-brand">Real Estate System</div>
        <div class="nav-links">
            <a href="dashboard.php">My Dashboard</a>
            <a href="search.php">Search Properties</a>
            <a href="favorites.php">My Favorites</a>
            <a href="profile.php">Profile</a>
            <a href="../properties.php">Browse Properties</a>
            <a href="../includes/auth.php?logout=1">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="profile-card">
            <h1>My Profile</h1>
            
            <?php if (isset($success)): ?>
                <div class="success-message"><?= $success ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" class="profile-form">
                <div class="form-group">
                    <label>Username:</label>
                    <input type="text" value="<?= $user_info['username'] ?>" disabled>
                    <small>Username cannot be changed</small>
                </div>

                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" value="<?= $user_info['email'] ?>" disabled>
                    <small>Email cannot be changed</small>
                </div>

                <div class="form-group">
                    <label>Full Name:</label>
                    <input type="text" name="full_name" value="<?= $user_info['full_name'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Phone:</label>
                    <input type="text" name="phone" value="<?= $user_info['phone'] ?>">
                </div>

                <div class="form-group">
                    <label>Account Type:</label>
                    <input type="text" value="<?= ucfirst($user_info['user_type']) ?>" disabled>
                </div>

                <div class="form-group">
                    <label>Member Since:</label>
                    <input type="text" value="<?= date('F j, Y', strtotime($user_info['created_at'])) ?>" disabled>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Update Profile</button>
                    <a href="dashboard.php" class="btn-secondary">Back to Dashboard</a>
                </div>
            </form>
        </div>
    </div>

    <style>
    .profile-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 40px;
        max-width: 600px;
        margin: 20px auto;
    }

    .profile-card h1 {
        color: #fff;
        text-align: center;
        margin-bottom: 30px;
    }

    .profile-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        color: rgba(255,255,255,0.9);
        margin-bottom: 8px;
        font-weight: 500;
    }

    .form-group input {
        padding: 12px;
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 8px;
        background: rgba(255,255,255,0.1);
        color: #fff;
        font-size: 16px;
    }

    .form-group input:disabled {
        background: rgba(255,255,255,0.05);
        color: rgba(255,255,255,0.6);
        cursor: not-allowed;
    }

    .form-group small {
        color: rgba(255,255,255,0.6);
        font-size: 12px;
        margin-top: 4px;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }

    .form-actions .btn-primary,
    .form-actions .btn-secondary {
        flex: 1;
        padding: 14px;
        text-align: center;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        cursor: pointer;
    }

    .success-message {
        background: rgba(76, 175, 80, 0.2);
        border: 1px solid rgba(76, 175, 80, 0.5);
        color: #4caf50;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
    }

    .error-message {
        background: rgba(244, 67, 54, 0.2);
        border: 1px solid rgba(244, 67, 54, 0.5);
        color: #f44336;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .profile-card {
            margin: 10px;
            padding: 20px;
        }
        
        .form-actions {
            flex-direction: column;
        }
    }
    </style>
</body>
</html>
