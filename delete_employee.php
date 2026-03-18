<?php
session_start();
include 'connect.php';

// Session protection
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare statement to delete employee
    $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Employee deleted successfully!";
        $_SESSION['alert_type'] = "success";
        $_SESSION['alert_icon'] = "bi-check-circle";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        $_SESSION['alert_type'] = "danger";
        $_SESSION['alert_icon'] = "bi-exclamation-triangle";
    }

    $stmt->close();
}

header("Location: admin_dashboard.php");
exit();
?>
