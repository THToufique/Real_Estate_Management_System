<?php
include 'db_connect.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Owner • Real Estate Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Owner</h1>
        <form action="insert_owner.php" method="POST" class="form">
            <label>Name</label>
            <input type="text" name="name" required>
            <label>Phone</label>
            <input type="text" name="phone" required>
            <label>Email</label>
            <input type="email" name="email">
            <label>Address</label>
            <textarea name="address" placeholder="Full address (optional)"></textarea>
            <div class="form-actions">
                <button type="submit" class="btn success">Add Owner</button>
            </div>
        </form>
        <a href="index.php" class="back-link">← Back to List</a>
    </div>
</body>
</html>