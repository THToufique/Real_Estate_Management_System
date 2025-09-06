<?php
include 'db_connect.php';

// Test functions with fallback queries
$available_result = $conn->query("SELECT COUNT(*) as count FROM Properties WHERE status = 'Available'");
$available_count = $available_result ? $available_result->fetch_assoc()['count'] : 0;

$sold_result = $conn->query("SELECT COUNT(*) as count FROM Properties WHERE status = 'Sold'");
$sold_count = $sold_result ? $sold_result->fetch_assoc()['count'] : 0;

$rented_result = $conn->query("SELECT COUNT(*) as count FROM Properties WHERE status = 'Rented'");
$rented_count = $rented_result ? $rented_result->fetch_assoc()['count'] : 0;

$house_result = $conn->query("SELECT AVG(price) as avg_price FROM Properties WHERE property_type = 'House' AND status = 'Available'");
$house_avg = $house_result ? ($house_result->fetch_assoc()['avg_price'] ?? 0) : 0;

$apartment_result = $conn->query("SELECT AVG(price) as avg_price FROM Properties WHERE property_type = 'Apartment' AND status = 'Available'");
$apartment_avg = $apartment_result ? ($apartment_result->fetch_assoc()['avg_price'] ?? 0) : 0;

// Check if price history table exists
$price_history = $conn->query("SHOW TABLES LIKE 'Property_Price_History'");
if ($price_history && $price_history->num_rows > 0) {
    $price_history = $conn->query("SELECT ph.*, p.address FROM Property_Price_History ph 
                                   JOIN Properties p ON ph.property_id = p.property_id 
                                   ORDER BY ph.change_date DESC LIMIT 10");
} else {
    $price_history = false;
}

// Calculate commission example (manual calculation)
$commission_example = 300000 * 3.0 / 100;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Functions & Reports • Real Estate Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>📊 Functions & Reports</h1>
        
        <div class="actions-left">
            <a href="index.php" class="btn secondary">← Back to Dashboard</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?= $available_count ?></div>
                <div class="stat-label">Available Properties</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $sold_count ?></div>
                <div class="stat-label">Sold Properties</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $rented_count ?></div>
                <div class="stat-label">Rented Properties</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">$<?= number_format($commission_example, 2) ?></div>
                <div class="stat-label">Commission Example (3%)</div>
            </div>
        </div>

        <div class="card">
            <h2>📈 Average Property Prices by Type</h2>
            <table>
                <thead>
                    <tr>
                        <th>Property Type</th>
                        <th>Average Price</th>
                        <th>Function Used</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>House</td>
                        <td>$<?= number_format($house_avg, 2) ?></td>
                        <td><code>GetAveragePropertyPrice('House')</code></td>
                    </tr>
                    <tr>
                        <td>Apartment</td>
                        <td>$<?= number_format($apartment_avg, 2) ?></td>
                        <td><code>GetAveragePropertyPrice('Apartment')</code></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h2>💰 Commission Calculator</h2>
            <form method="POST" class="form" style="max-width: 400px;">
                <label>Sale Price ($)</label>
                <input type="number" name="sale_price" step="0.01" required>
                <label>Commission Rate (%)</label>
                <input type="number" name="commission_rate" step="0.1" required>
                <div class="form-actions">
                    <button type="submit" name="calculate" class="btn">Calculate Commission</button>
                </div>
            </form>
            
            <?php if (isset($_POST['calculate'])): ?>
                <?php 
                $price = floatval($_POST['sale_price']);
                $rate = floatval($_POST['commission_rate']);
                $calc_commission = $price * $rate / 100;
                ?>
                <div class="success">
                    💰 Commission: $<?= number_format($calc_commission, 2) ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($price_history && $price_history->num_rows > 0): ?>
        <div class="card">
            <h2>📊 Recent Price Changes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Old Price</th>
                        <th>New Price</th>
                        <th>Change</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $price_history->fetch_assoc()): ?>
                        <?php $change = $row['new_price'] - $row['old_price']; ?>
                        <tr>
                            <td><?= htmlspecialchars($row['address']) ?></td>
                            <td>$<?= number_format($row['old_price'], 2) ?></td>
                            <td>$<?= number_format($row['new_price'], 2) ?></td>
                            <td style="color: <?= $change >= 0 ? '#86efac' : '#fca5a5' ?>">
                                <?= $change >= 0 ? '+' : '' ?>$<?= number_format($change, 2) ?>
                            </td>
                            <td><?= date('M j, Y', strtotime($row['change_date'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <div class="card">
            <h2>⚡ Active Functions & Triggers</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                <div>
                    <h3>📊 Functions</h3>
                    <ul style="color: rgba(255,255,255,0.8); line-height: 1.8;">
                        <li><strong>CalculateCommission()</strong> - Auto commission calculation</li>
                        <li><strong>GetPropertyStatusCount()</strong> - Property counts by status</li>
                        <li><strong>GetAveragePropertyPrice()</strong> - Average prices by type</li>
                    </ul>
                </div>
                <div>
                    <h3>⚡ Triggers</h3>
                    <ul style="color: rgba(255,255,255,0.8); line-height: 1.8;">
                        <li><strong>CalculateTransactionCommission</strong> - Auto-calc on transactions</li>
                        <li><strong>UpdatePropertyStatusOnTransaction</strong> - Status updates</li>
                        <li><strong>LogPropertyPriceChange</strong> - Price change logging</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>