<?php
session_start();
include 'db_connect.php';

$property_id = $_GET['id'] ?? 0;

$result = $conn->query("SELECT p.*, a.name AS agent_name, a.phone AS agent_phone, a.email AS agent_email, 
                               o.name AS owner_name, o.phone AS owner_phone 
                        FROM Properties p 
                        LEFT JOIN Agents a ON p.agent_id = a.agent_id 
                        LEFT JOIN Owners o ON p.owner_id = o.owner_id 
                        WHERE p.property_id = $property_id");

if ($result->num_rows == 0) {
    header("Location: properties.php");
    exit();
}

$property = $result->fetch_assoc();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $property['title'] ?> - Real Estate System</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <nav class="main-nav">
        <div class="nav-brand">Real Estate System</div>
        <div class="nav-links">
            <a href="properties.php">← Back to Properties</a>
            <?php if ($isLoggedIn): ?>
                <a href="user/dashboard.php">Dashboard</a>
                <a href="includes/auth.php?logout=1">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">
        <div class="property-detail-card">
            <div class="property-detail-header">
                <h1><?= $property['title'] ?></h1>
                <div class="property-badges">
                    <span class="property-type-badge"><?= $property['property_type'] ?></span>
                    <span class="status-badge status-<?= strtolower($property['status']) ?>"><?= $property['status'] ?></span>
                </div>
            </div>

            <div class="property-detail-content">
                <div class="property-main-info">
                    <div class="price-section">
                        <h2 class="price">$<?= number_format($property['price']) ?></h2>
                        <p class="location">📍 <?= $property['location'] ?></p>
                    </div>

                    <div class="property-specs">
                        <div class="spec-item">
                            <span class="spec-label">🏠 Bedrooms:</span>
                            <span class="spec-value"><?= $property['bedrooms'] ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">🚿 Bathrooms:</span>
                            <span class="spec-value"><?= $property['bathrooms'] ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">📐 Area:</span>
                            <span class="spec-value"><?= $property['area'] ? $property['area'] . ' sq ft' : 'N/A' ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">🏗️ Year Built:</span>
                            <span class="spec-value"><?= $property['year_built'] ?: 'N/A' ?></span>
                        </div>
                    </div>

                    <?php if ($property['description']): ?>
                    <div class="description-section">
                        <h3>Description</h3>
                        <p><?= nl2br(htmlspecialchars($property['description'])) ?></p>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="contact-section">
                    <h3>Contact Information</h3>
                    
                    <?php if ($property['agent_name']): ?>
                    <div class="contact-card">
                        <h4>Agent</h4>
                        <p><strong><?= $property['agent_name'] ?></strong></p>
                        <?php if ($property['agent_phone']): ?>
                            <p>📞 <?= $property['agent_phone'] ?></p>
                        <?php endif; ?>
                        <?php if ($property['agent_email']): ?>
                            <p>✉️ <?= $property['agent_email'] ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($property['owner_name']): ?>
                    <div class="contact-card">
                        <h4>Owner</h4>
                        <p><strong><?= $property['owner_name'] ?></strong></p>
                        <?php if ($property['owner_phone']): ?>
                            <p>📞 <?= $property['owner_phone'] ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <div class="action-buttons">
                        <a href="properties.php" class="btn-secondary">← Back to Properties</a>
                        <?php if ($isLoggedIn): ?>
                            <button class="btn-primary" onclick="contactAgent()">Contact Agent</button>
                        <?php else: ?>
                            <a href="login.php" class="btn-primary">Login to Contact</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .property-detail-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 40px;
        margin: 20px 0;
    }

    .property-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .property-detail-header h1 {
        color: #fff;
        margin: 0;
        font-size: 2.5em;
    }

    .property-badges {
        display: flex;
        gap: 10px;
        flex-direction: column;
        align-items: flex-end;
    }

    .property-detail-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
    }

    .price-section .price {
        font-size: 3em;
        font-weight: 700;
        color: #66bb6a;
        margin: 0 0 10px 0;
    }

    .price-section .location {
        font-size: 1.2em;
        color: rgba(255,255,255,0.8);
        margin: 0;
    }

    .property-specs {
        margin: 30px 0;
    }

    .spec-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .spec-label {
        color: rgba(255,255,255,0.8);
    }

    .spec-value {
        color: #fff;
        font-weight: 600;
    }

    .description-section {
        margin: 30px 0;
    }

    .description-section h3 {
        color: #fff;
        margin-bottom: 15px;
    }

    .description-section p {
        color: rgba(255,255,255,0.9);
        line-height: 1.6;
    }

    .contact-section {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 25px;
    }

    .contact-section h3 {
        color: #fff;
        margin-bottom: 20px;
        text-align: center;
    }

    .contact-card {
        background: rgba(255, 255, 255, 0.08);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
    }

    .contact-card h4 {
        color: #64b5f6;
        margin: 0 0 10px 0;
    }

    .contact-card p {
        color: rgba(255,255,255,0.9);
        margin: 5px 0;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }

    .action-buttons a {
        flex: 1;
        text-align: center;
        padding: 12px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .property-detail-content {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .property-detail-header {
            flex-direction: column;
            gap: 15px;
        }
        
        .property-badges {
            align-items: flex-start;
        }
        
        .property-detail-header h1 {
            font-size: 2em;
        }
        
        .price-section .price {
            font-size: 2.5em;
        }
        
        .action-buttons {
            flex-direction: column;
        }
    }
    </style>

    <script>
    function contactAgent() {
        Swal.fire({
            title: 'Contact Agent',
            html: `
                <div style="text-align: left; color: #333;">
                    <p style="color: #333;"><strong>Agent:</strong> <?= $property['agent_name'] ?: 'N/A' ?></p>
                    <?php if ($property['agent_phone']): ?>
                    <p style="color: #333;"><strong>Phone:</strong> <a href="tel:<?= $property['agent_phone'] ?>" style="color: #667eea;"><?= $property['agent_phone'] ?></a></p>
                    <?php endif; ?>
                    <?php if ($property['agent_email']): ?>
                    <p style="color: #333;"><strong>Email:</strong> <a href="mailto:<?= $property['agent_email'] ?>" style="color: #667eea;"><?= $property['agent_email'] ?></a></p>
                    <?php endif; ?>
                </div>
            `,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Send Message',
            cancelButtonText: 'Close',
            confirmButtonColor: '#667eea',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                sendMessage();
            }
        });
    }

    function sendMessage() {
        Swal.fire({
            title: 'Send Message to Agent',
            html: `
                <textarea id="message" class="swal2-textarea" placeholder="Type your message here..." style="width: 100%; height: 120px; margin: 10px 0; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"></textarea>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Send',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#667eea',
            preConfirm: () => {
                const message = document.getElementById('message').value;
                if (!message.trim()) {
                    Swal.showValidationMessage('Please enter a message');
                    return false;
                }
                return message;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Message Sent!',
                    text: 'Your message has been sent to the agent. They will contact you soon.',
                    icon: 'success',
                    confirmButtonColor: '#667eea'
                });
            }
        });
    }
    </script>
</body>
</html>
