<?php
session_start();

$conn = new mysqli("localhost", "root", "", "ecommers1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO userdata1 (fullname, email, password) VALUES (?, ?, ?)");
if ($stmt === false) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
}
$stmt->bind_param("sss", $fullname, $email, $password);

if ($stmt->execute()) {
    $_SESSION['username'] = $fullname; 
    header("Location: login.html");
    exit();
} else {
    echo "Error: " . htmlspecialchars($stmt->error);
}   

$stmt->close();
$conn->close();
?>
