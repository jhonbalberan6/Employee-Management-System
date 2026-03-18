<?php
session_start();
include 'connect.php';

// Session protection
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emp_id = $_POST['emp_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $address = $_POST['address'];
    $salary = $_POST['salary'];

    $email = $_POST['email'];

    // Prepare statement to insert new employee
    $stmt = $conn->prepare("INSERT INTO employees (emp_id, first_name, last_name, email, department, position, address, salary) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssd", $emp_id, $first_name, $last_name, $email, $department, $position, $address, $salary);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Employee added successfully!";
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
