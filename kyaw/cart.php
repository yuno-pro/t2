<?php
session_start();
$cart_items = $_SESSION['cart_items'] ?? [];
$total = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <link rel="icon" href="assets/img/logo1.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <section id="header">
        <a href="index.html"><img src="assets/img/logo1.png" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li><a href="index.html">Home</a></li>
                <li><a href="shop.html">Shop</a></li>
                <li><a href="blog.html">Blog</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li id="lg-bag"><a class="active" href="cart.php"><i class="fa-solid fa-bag-shopping" style="color: white; -webkit-text-stroke: 1px black;"></i></a></li>
                <a href="#" id="close"><i class="fa-solid fa-times"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="fa-solid fa-bag-shopping" style="color: white; -webkit-text-stroke: 1px black;"></i></a>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    <section id="page-header" class="about-header">
        <h2>#Lets_Talk</h2>
        <p>LEAVE A MESSAGE, We love to hear from you!</p>
    </section>

    <section id="cart" class="section-p1">
        <table width="100%">
            <thead>
                <tr>
                    <td>Remove</td>
                    <td>Image</td>
                    <td>Product</td>
                    <td>Size</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Subtotal</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($cart_items)): ?>
                    <tr><td colspan="7" style="text-align:center;">Your cart is empty.</td></tr>
                <?php else: ?>
                    <?php foreach ($cart_items as $index => $item): ?>
                        <?php
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                        ?>
                        <tr>
                            <td>
                                <form method="POST" action="remove_from_cart.php" onsubmit="return confirm('Remove this item?');">
                                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                                    <button type="submit" style="background:none; border:none; color:red; cursor:pointer;">X</button>
                                </form>
                            </td>
                            <td><img src="<?php echo htmlspecialchars($item['image'] ?? 'assets/img/products/1.jpg'); ?>" alt="Product Image" width="50"></td>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo htmlspecialchars($item['size'] ?? 'N/A'); ?></td>
                            <td>₱<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo intval($item['quantity']); ?></td>
                            <td>₱<?php echo number_format($subtotal, 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <section id="cart-add" class="section-p1">
        <div id="coupon">
            <h3>Apply Coupon</h3>
            <div>
                <input type="text" placeholder="Enter Your Coupon">
                <button class="normal">Apply</button>
            </div>
        </div>

        <div id="subtotal">
            <h3>Cart Totals</h3>
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td id="total-price">₱<?php echo number_format($total, 2); ?></td>
                </tr>
                <tr>
                    <td>Shipping</td>
                    <td>Free</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td id="grand-total"><strong>₱<?php echo number_format($total, 2); ?></strong></td>
                </tr>
            </table>
<button id="proceed-checkout-btn" class="normal" onclick="window.location.href='checkout.php';">Proceed to Checkout</button>
        </div>
    </section>

    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="assets/img/logo1.png" alt="">
            <h4>Contact</h4>
            <p><strong>Address: </strong>Sinsuat Ave, Cotabato City, 9600 Maguindanao</p>
            <p><strong>Phone: </strong>09942498562 / +639657057285</p>
            <p><strong>Hours: </strong>: </strong>09:00 - 19:00, Mon - Sat</p>
            <div class="follow">
                <h4>Follow Us</h4>
                <div class="icon">
                    <a href="https://www.facebook.com/michaelandres24" target=""><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/micss__" target=""><i class="fab fa-instagram"></i></a>
                    <a href="https://www.x.com/Maxxxs0" target=""><i class="fab fa-twitter"></i></a>
                    <a href="https://www.youtube.com/MrBeast" target=""><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>

        <div class="col">
            <h4>About</h4>
            <a href="about.html">About Us</a>
            <a href="#">Delivery Information</a>
            <a href="privacy-policy.html">Privacy Policy</a>
            <a href="terms-and-conditions.html">Terms & Conditions</a>
            <a href="contact.html">Contact Us</a>
        </div>
        
        <div class="col">
            <h4>My Account</h4>
            <a href="login.html">Sign in</a>
            <a href="cart.php">View Cart</a>
            <a href="help.html">Help</a>
        </div>
        
        <div class="col install">
            <h4>Install App</h4>
            <p>From App Store or Google Play</p>
            <div class="row">
                <img src="assets/img/pay/app.jpg" alt="">
                <img src="assets/img/pay/play.jpg" alt="">
            </div>
            <p>Secured Payment Gateways</p>
            <img src="assets/img/pay/pay.png" alt="">
        </div>

        <div class="copyright">
            <p>© 2025, Tech2 etc - HTML CSS Ecommerce Template</p>
        </div> 

    </footer>

    <script src="assets/js/script.js"></script>
</body>
