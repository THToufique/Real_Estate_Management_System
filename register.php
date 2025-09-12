<?php
require_once 'includes/auth.php';

if ($_POST) {
    if (register($_POST['username'], $_POST['email'], $_POST['password'], $_POST['full_name'], $_POST['phone'])) {
        $success = "Registration successful! You can now login.";
    } else {
        $error = "Registration failed. Username or email may already exist.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Real Estate System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="glass-card" style="max-width: 400px; margin: 50px auto;">
            <h2>Register</h2>
            <?php if (isset($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="success"><?= $success ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Username:</label>
                    <input type="text" name="username" required>
                </div>
                
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Full Name:</label>
                    <input type="text" name="full_name" required>
                </div>
                
                <div class="form-group">
                    <label>Phone:</label>
                    <input type="text" name="phone">
                </div>
                
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password" required>
                </div>
                
                <button type="submit" class="btn-primary">Register</button>
            </form>
            
            <p><a href="login.php">Already have an account? Login</a></p>
        </div>
    </div>
</body>
</html>
