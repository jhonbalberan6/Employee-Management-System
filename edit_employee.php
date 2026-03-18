<?php
session_start();
include 'connect.php';

// Session protection
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $emp_id = $_POST['emp_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $address = $_POST['address'];
    $salary = $_POST['salary'];

    $email = $_POST['email'];

    // Prepare statement to update employee
    $stmt = $conn->prepare("UPDATE employees SET emp_id = ?, first_name = ?, last_name = ?, email = ?, department = ?, position = ?, address = ?, salary = ? WHERE id = ?");
    $stmt->bind_param("sssssssdi", $emp_id, $first_name, $last_name, $email, $department, $position, $address, $salary, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Employee updated successfully!";
        $_SESSION['alert_type'] = "success";
        $_SESSION['alert_icon'] = "bi-check-circle";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        $_SESSION['alert_type'] = "danger";
        $_SESSION['alert_icon'] = "bi-exclamation-triangle";
    }

    $stmt->close();
    header("Location: admin_dashboard.php");
    exit();
}
?>
