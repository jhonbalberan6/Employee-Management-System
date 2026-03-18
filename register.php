<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['reg_username'];
    $password = $_POST['reg_password'];

    // Securely hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepare statement to insert new admin into 'users' table
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Successfully Registered! You can now log in.";
        $_SESSION['alert_type'] = "success";
        $_SESSION['alert_icon'] = "bi-check-circle";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        $_SESSION['alert_type'] = "danger";
        $_SESSION['alert_icon'] = "bi-exclamation-triangle";
    }

    $stmt->close();
    header("Location: index.php");
    exit();
}
?>
