<?php
// Simple admin dashboard to view orders
$ordersFile = 'orders.json';
$orders = [];
if (file_exists($ordersFile)) {
    $ordersJson = file_get_contents($ordersFile);
    $orders = json_decode($ordersJson, true) ?: [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard - Orders</title>
    <link rel="stylesheet" href="assets/css/checkout-style.css" />
    <style>
        body {
            background-color: #f9fafb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #00796b;
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        th {
            background-color: #00796b;
            color: #fff;
        }
        tr:hover {
            background-color: #f1f8f7;
        }
        .order-items {
            font-size: 0.9rem;
            color: #555;
        }
        .timestamp {
            font-size: 0.85rem;
            color: #999;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard - Orders</h1>
    <?php if (empty($orders)): ?>
        <p>No orders found.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Order Date</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Address</th>
                    <th>Items</th>
                    <th>Total (₱)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td class="timestamp"><?php echo htmlspecialchars($order['timestamp']); ?></td>
                        <td><?php echo htmlspecialchars($order['name']); ?></td>
                        <td><?php echo htmlspecialchars($order['email']); ?></td>
                        <td><?php echo htmlspecialchars($order['contact_number'] ?? ''); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($order['address'])); ?></td>
                        <td class="order-items">
                            <ul>
                                <?php foreach ($order['cart_items'] as $item): ?>
                                    <li><?php echo htmlspecialchars($item['name']); ?> x <?php echo intval($item['quantity']); ?> - ₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td><?php echo number_format($order['total'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
