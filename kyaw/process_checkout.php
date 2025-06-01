<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic validation
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $payment_method = trim($_POST['payment_method'] ?? '');
    $contact_number = trim($_POST['contact_number'] ?? '');

    if (empty($name) || empty($email) || empty($address) || empty($payment_method) || empty($contact_number)) {
        $error = "Please fill in all required fields including payment method and contact number.";
    } elseif (
        in_array($payment_method, ['CASH ON DELIVERY', 'GCASH', 'PAYMAYA']) 
        && !preg_match('/^09\d{9}$/', $contact_number)
    ) {
        $error = "For CASH ON DELIVERY, GCASH, or PAYMAYA, contact number must be exactly 11 digits and start with '09'. Please enter a valid contact number.";
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8" />
            <title>Checkout Error</title>
            <link rel="stylesheet" href="assets/css/checkout-style.css" />
            <style>
                #error-container {
                    max-width: 500px;
                    margin: 100px auto;
                    background: #fff;
                    padding: 30px 40px;
                    border-radius: 10px;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                    text-align: center;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                }
                #error-container h2 {
                    color: #d32f2f;
                    margin-bottom: 20px;
                }
                #error-container p {
                    font-size: 1.1rem;
                    margin-bottom: 30px;
                    color: #555;
                }
                #error-container a.normal {
                    background-color: #d32f2f;
                    padding: 12px 30px;
                    border-radius: 6px;
                    color: #fff !important;
                    font-weight: 600;
                    text-decoration: none;
                    transition: background-color 0.3s ease;
                }
                #error-container a.normal:hover {
                    background-color: #9a0007;
                }
            </style>
        </head>
        <body>
            <section id="error-container">
                <h2>ERROR</h2>
                <p><?php echo $error; ?></p>
                <a href="checkout.php" class="normal">Back to Checkout</a>
            </section>
        </body>
        </html>
        <?php
        exit;
    } else {
        // Validate payment method
        $valid_methods = ['GCASH', 'PAYMAYA', 'CASH ON DELIVERY'];
        if (!in_array($payment_method, $valid_methods)) {
            $error = "Invalid payment method selected.";
        } else {
            // Save order to orders.json file
            $order = [
                'name' => $name,
                'email' => $email,
                'contact_number' => $contact_number,
                'address' => $address,
                'payment_method' => $payment_method,
                'cart_items' => $_SESSION['cart_items'],
                'total' => 0,
                'timestamp' => date('Y-m-d H:i:s')
            ];
            foreach ($order['cart_items'] as $item) {
                $order['total'] += $item['price'] * $item['quantity'];
            }

            $ordersFile = 'orders.json';
            $orders = [];
            if (file_exists($ordersFile)) {
                $ordersJson = file_get_contents($ordersFile);
                $orders = json_decode($ordersJson, true) ?: [];
            }
            $orders[] = $order;
            file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT));

            // Clear cart
            $_SESSION['cart_items'] = [];

            // Show confirmation page with payment instructions
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <title>Order Confirmation</title>
                <link rel="stylesheet" href="assets/css/checkout-style.css" />
                <style>
                    #confirmation {
                        max-width: 600px;
                        margin: 80px auto;
                        background: #fff;
                        padding: 40px;
                        border-radius: 10px;
                        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                        text-align: center;
                    }
                    #confirmation h2 {
                        color: #00796b;
                        margin-bottom: 20px;
                    }
                    #confirmation p {
                        font-size: 1.1rem;
                        margin-bottom: 30px;
                    }
                    #confirmation a {
                        background-color: #00796b;
                        color: #fff;
                        padding: 12px 30px;
                        border-radius: 6px;
                        text-decoration: none;
                        font-weight: 600;
                        transition: background-color 0.3s ease;
                    }
                    #confirmation a:hover {
                        background-color: #004d40;
                    }
                    .payment-info {
                        text-align: left;
                        margin-top: 20px;
                        font-size: 1rem;
                        background: #e0f2f1;
                        padding: 20px;
                        border-radius: 8px;
                    }
                    .payment-info img {
                        max-width: 200px;
                        margin-top: 10px;
                    }
                </style>
            </head>
            <body>
                <section id="confirmation">
                    <h2>Thank you for your order, <?php echo htmlspecialchars($name); ?>!</h2>
                    <p>Your order has been successfully placed. We will contact you shortly at <strong><?php echo htmlspecialchars($email); ?></strong>.</p>
                    <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment_method); ?></p>
                    <?php if ($payment_method === 'GCASH'): ?>
                        <div class="payment-info">
                            <p>Please send your payment to the following GCASH number:</p>
                            <p><strong>0994-249-8562</strong></p>
                            <p>Scan the QR code below to pay via GCASH:</p>
                            <img src="assets/img/qr.jpeg" alt="GCASH QR Code" />
                        </div>
                    <?php elseif ($payment_method === 'PAYMAYA'): ?>
                        <div class="payment-info">
                            <p>Please send your payment to the following PAYMAYA number:</p>
                            <p><strong>0965-705-7285</strong></p>
                            <p>Scan the QR code below to pay via PAYMAYA:</p>
                            <img src="assets/img/pay/paymaya-qr.png" alt="PAYMAYA QR Code" />
                        </div>
                    <?php else: ?>
                        <div class="payment-info">
                            <p>Please prepare the exact amount in cash upon delivery.</p>
                        </div>
                    <?php endif; ?>
                    <a href="shop.html">Continue Shopping</a>
                </section>
            </body>
            </html>
            <?php
            exit;
        }
    }
} else {
    header('Location: checkout.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Checkout Error</title>
</head>
<body>
    <p><?php echo $error ?? 'Invalid request.'; ?></p>
    <a href="checkout.php">Back to Checkout</a>
</body>
</html>
