<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare statement to fetch user
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['message'] = "Successfully Logged In! Welcome, " . $user['username'];
            $_SESSION['alert_type'] = "success";
            $_SESSION['alert_icon'] = "bi-check-circle";
            
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $_SESSION['message'] = "Invalid password. Please try again.";
            $_SESSION['alert_type'] = "danger";
            $_SESSION['alert_icon'] = "bi-exclamation-triangle";
        }
    } else {
        $_SESSION['message'] = "User not found.";
        $_SESSION['alert_type'] = "danger";
        $_SESSION['alert_icon'] = "bi-exclamation-triangle";
    }

    $stmt->close();
    header("Location: index.php");
    exit();
}
?>
