<?php
require_once 'includes/auth.php';

// Redirect if already logged in
if (isLoggedIn()) {
    if (isAdmin()) {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: user/dashboard.php");
    }
    exit();
}

if ($_POST) {
    if (login($_POST['username'], $_POST['password'])) {
        if (isAdmin()) {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: user/dashboard.php");
        }
        exit();
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Real Estate System</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container" style="display: flex; justify-content: center; align-items: center; min-height: 100vh;">
        <div class="card" style="max-width: 450px; width: 100%; padding: 40px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="color: #fff; margin-bottom: 10px; white-space: nowrap;">Real Estate System</h1>
                <h2 style="color: rgba(255,255,255,0.9); font-weight: 400;">Welcome Back</h2>
            </div>
            
            <?php if (isset($error)): ?>
                <script>
                Swal.fire({
                    title: 'Login Failed',
                    text: '<?= $error ?>',
                    icon: 'error',
                    confirmButtonColor: '#667eea'
                });
                </script>
            <?php endif; ?>
            
            <form method="POST" style="margin-bottom: 30px;">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: rgba(255,255,255,0.9);">Username/Email:</label>
                    <input type="text" name="username" required style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; background: rgba(255,255,255,0.1); color: #fff; font-size: 16px;">
                </div>
                
                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; color: rgba(255,255,255,0.9);">Password:</label>
                    <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; background: rgba(255,255,255,0.1); color: #fff; font-size: 16px;">
                </div>
                
                <button type="submit" class="btn-primary" style="width: 100%; padding: 14px; font-size: 16px; font-weight: 600;">Login</button>
            </form>
            
            <div style="text-align: center; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
                <p style="margin-bottom: 10px;"><a href="register.php" style="color: #64b5f6; text-decoration: none;">Don't have an account? Register</a></p>
                <p><a href="properties.php" style="color: rgba(255,255,255,0.7); text-decoration: none;">Browse Properties (No Login Required)</a></p>
            </div>
        </div>
    </div>
</body>
</html>
