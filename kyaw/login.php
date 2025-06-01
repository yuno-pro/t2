<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ecommers1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    header("Location: login.html");
    exit();
}

$email = $_POST['email'];
$password = $_POST['password'];
$stmt = $conn->prepare("SELECT * FROM userdata1 WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
if (password_verify($password, $row['password'])) {
    // Set session variable for logged-in user
    $_SESSION['username'] = $row['username'] ?? $row['email'];

    header("Location: index.html");
    exit();
} else {
        $error = urlencode("Invalid password.");
        header("Location: login.html?error=$error");
        exit();
    }
} else {
    $error = urlencode("No user found with that email.");
    header("Location: login.html?error=$error");
    exit();
}
$stmt->close();
$conn->close();
?>