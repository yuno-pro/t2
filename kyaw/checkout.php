<?php
session_start();
$cart_items = $_SESSION['cart_items'] ?? [];
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/checkout-style.css" />
</head>
<body>
    <section id="header">
        <a href="index.html"><img src="assets/img/logo1.png" class="logo" alt="Logo" /></a>
        <div>
            <ul id="navbar">
                <li><a href="index.html">Home</a></li>
                <li><a href="shop.html">Shop</a></li>
                <li><a href="blog.html">Blog</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="cart.php"><i class="fa-solid fa-bag-shopping"></i> Cart</a></li>
            </ul>
        </div>
    </section>

    <section id="checkout" class="section-p1">
        <h2>Checkout</h2>
        <?php if (empty($cart_items)): ?>
            <p>Your cart is empty. Please add items before checking out.</p>
            <a href="shop.html" class="normal">Continue Shopping</a>
        <?php else: ?>
            <form method="POST" action="process_checkout.php">
                <h3>Billing Details</h3>
                <label for="name">Full Name:</label><br />
                <input type="text" id="name" name="name" required /><br />

                <label for="email">Email:</label><br />
                <input type="email" id="email" name="email" required /><br />

                <label for="contact_number">Contact Number:</label><br />
                <input type="text" id="contact_number" name="contact_number" required /><br />

                <label for="address">Address:</label><br />
                <textarea id="address" name="address" required></textarea><br />

                <h3>Order Summary</h3>
                <ul>
                    <?php foreach ($cart_items as $item): ?>
                        <li><?php echo htmlspecialchars($item['name']); ?> x <?php echo intval($item['quantity']); ?> - ₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></li>
                    <?php endforeach; ?>
                </ul>
                <p><strong>Total: ₱<?php echo number_format($total, 2); ?></strong></p>

                <h3>Payment Method</h3>
                <label><input type="radio" name="payment_method" value="GCASH" required> GCASH</label><br>
                <label><input type="radio" name="payment_method" value="PAYMAYA" required> PAYMAYA</label><br>
                <label><input type="radio" name="payment_method" value="CASH ON DELIVERY" required> CASH ON DELIVERY</label><br><br>

                <button type="submit" class="normal">Place Order</button>
            </form>
        <?php endif; ?>
    </section>

    <footer class="section-p1">
        <p>© 2025, Tech2 etc - HTML CSS Ecommerce Template</p>
    </footer>
</body>
</html>
