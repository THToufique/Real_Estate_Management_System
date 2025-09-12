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
    <div class="container" style="display: flex; justify-content: center; align-items: center; min-height: 100vh;">
        <div class="card" style="max-width: 450px; width: 100%; padding: 40px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="color: #fff; margin-bottom: 10px; white-space: nowrap;">Real Estate System</h1>
                <h2 style="color: rgba(255,255,255,0.9); font-weight: 400;">Create Account</h2>
            </div>
            
            <?php if (isset($error)): ?>
                <div style="background: rgba(255,0,0,0.1); border: 1px solid rgba(255,0,0,0.3); padding: 12px; border-radius: 8px; margin-bottom: 20px; color: #ff6b6b;">
                    <?= $error ?>
                </div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div style="background: rgba(0,255,0,0.1); border: 1px solid rgba(0,255,0,0.3); padding: 12px; border-radius: 8px; margin-bottom: 20px; color: #4caf50;">
                    <?= $success ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" style="margin-bottom: 30px;">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: rgba(255,255,255,0.9);">Username:</label>
                    <input type="text" name="username" required style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; background: rgba(255,255,255,0.1); color: #fff; font-size: 16px;">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: rgba(255,255,255,0.9);">Email:</label>
                    <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; background: rgba(255,255,255,0.1); color: #fff; font-size: 16px;">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: rgba(255,255,255,0.9);">Full Name:</label>
                    <input type="text" name="full_name" required style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; background: rgba(255,255,255,0.1); color: #fff; font-size: 16px;">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: rgba(255,255,255,0.9);">Phone:</label>
                    <input type="text" name="phone" style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; background: rgba(255,255,255,0.1); color: #fff; font-size: 16px;">
                </div>
                
                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; color: rgba(255,255,255,0.9);">Password:</label>
                    <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; background: rgba(255,255,255,0.1); color: #fff; font-size: 16px;">
                </div>
                
                <button type="submit" class="btn-primary" style="width: 100%; padding: 14px; font-size: 16px; font-weight: 600;">Register</button>
            </form>
            
            <div style="text-align: center; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
                <p style="margin-bottom: 10px;"><a href="login.php" style="color: #64b5f6; text-decoration: none;">Already have an account? Login</a></p>
                <p><a href="properties.php" style="color: rgba(255,255,255,0.7); text-decoration: none;">Browse Properties (No Login Required)</a></p>
            </div>
        </div>
    </div>
</body>
</html>
