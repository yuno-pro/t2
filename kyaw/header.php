<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Website</title>
    <link rel="icon" href="assets/img/logo1.png" type="image/png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <style>
        #user-info {
            position: absolute;
            top: 15px;
            right: 20px;
            color: white;
            font-weight: bold;
            font-size: 16px;
            z-index: 1000;
        }
        #user-info a {
            color: white;
            text-decoration: none;
            margin-left: 10px;
        }
        #user-info a:hover {
            text-decoration: underline;
        }
        #header {
            position: relative;
        }
    </style>
</head>
<body>
    <form id="logoutForm" action="logout.php" method="post" style="display:none;"></form>
    <section id="header">
        <a href="index.php"><img src="assets/img/logo1.png" class="logo" alt="Logo" /></a>
        <div>
            <ul id="navbar">
                <li><a class="active" href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="blog.html">Blog</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li id="lg-bag"><a href="cart.php"><i class="fa-solid fa-bag-shopping" style="color: white; -webkit-text-stroke: 1px black;"></i></a></li>
                <a href="#" id="close"><i class="fa-solid fa-times"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="fa-solid fa-bag-shopping" style="color: white; -webkit-text-stroke: 1px black;"></i></a>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
        <div id="user-info">
            <?php if (isset($_SESSION['username'])): ?>
                Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> |
                <a href="#" id="logout-link">Log Out</a>
            <?php else: ?>
                <a href="login.html">Sign In</a>
            <?php endif; ?>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var logoutLink = document.getElementById('logout-link');
            if (logoutLink) {
                logoutLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    var logoutForm = document.getElementById('logoutForm');
                    if (logoutForm) {
                        logoutForm.submit();
                    }
                });
            }
        });
