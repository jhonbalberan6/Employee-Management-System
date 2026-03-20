<?php
session_start();
include 'connect.php';

// Session protection - Module 4
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Get Total Employees - Module 5 & 6 logic
$sql_emp = "SELECT COUNT(*) AS total_employees FROM employees";
$result_emp = $conn->query($sql_emp);
$total_employees = ($result_emp && $row = $result_emp->fetch_assoc()) ? $row['total_employees'] : 0;

// Get Total Departments
$sql_dept = "SELECT COUNT(DISTINCT department) AS total_depts FROM employees";
$result_dept = $conn->query($sql_dept);
$total_departments = ($result_dept && $row = $result_dept->fetch_assoc()) ? $row['total_depts'] : 0;

// Get Total Salary
$sql_salary = "SELECT SUM(salary) AS total_salary FROM employees";
$result_salary = $conn->query($sql_salary);
$total_salary = ($result_salary && $row = $result_salary->fetch_assoc()) ? number_format($row['total_salary'], 2) : "0.00";

// Get System Users
$sql_users = "SELECT COUNT(*) AS total_users FROM users";
$result_users = $conn->query($sql_users);
$total_users = ($result_users && $row = $result_users->fetch_assoc()) ? $row['total_users'] : 0;

$search_query = trim($_GET['search'] ?? '');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EMS</title>
    <!-- Bootswatch Cerulean Theme -->
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.0/dist/cerulean/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<title>ValleyQuest Solutions - Admin Dashboard</title>

<!-- Offcanvas Sidebar - Module 5 & 6 (Responsive) -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
<div class="offcanvas-header shadow-sm bg-primary">
    <h5 class="offcanvas-title fw-bold text-white" id="offcanvasSidebarLabel">
        <i class="bi bi-rocket-takeoff-fill me-2"></i> ValleyQuest
    </h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <p class="small text-muted text-uppercase fw-bold mb-3 border-bottom pb-2">Admin Portal</p>
    <ul class="nav flex-column">
            <li class="nav-item">
                <a href="admin_dashboard.php" class="nav-link active">
                    <i class="bi bi-house-door"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-4 pt-3 border-top">
                <a href="logout.php" class="nav-link text-danger">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Top Navbar - Module 3 -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary border-bottom shadow-sm px-4">
    <div class="container-fluid dashboard-topbar">
        <div class="topbar-left">
            <button class="btn btn-outline-light me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                <i class="bi bi-list fs-5"></i>
            </button>
            <span class="navbar-brand d-none d-lg-block fw-bold mb-0"><i class="bi bi-rocket-takeoff-fill me-2"></i>ValleyQuest</span>
        </div>

        <div class="topbar-right ms-auto">
            <form class="navbar-search" role="search" action="admin_dashboard.php" method="GET" id="searchForm">
                <a href="admin_dashboard.php" class="btn btn-outline-light border-0 p-0 search-clear-btn <?php echo empty($search_query) ? 'is-hidden' : ''; ?>" title="Clear Search" aria-label="Clear Search" <?php echo empty($search_query) ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
                    <i class="bi bi-x-lg"></i>
                </a>
                <div class="input-group input-group-sm search-group">
                    <input class="form-control" type="search" name="search" placeholder="Search..." aria-label="Search" value="<?php echo htmlspecialchars($search_query); ?>">
                    <button class="btn btn-light text-primary border-0" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>

            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle navbar-user-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle navbar-user-icon"></i>
                    <strong class="navbar-user-name"><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content - Module 6 -->
<div id="content">
    <div class="container-fluid pt-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h2 style="font-size: clamp(1.5rem, 4vw, 2rem); margin-bottom: 0;">Dashboard Overview</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['alert_type'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
                <i class="bi <?php echo $_SESSION['alert_icon'] ?? 'bi-info-circle'; ?>"></i> <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['alert_type'], $_SESSION['alert_icon']); ?>
        <?php endif; ?>

        <!-- Cardboxes - Module 6 -->
        <div class="row g-4">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card bg-primary text-white h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="flex-grow-1">
                                <h6 class="text-uppercase mb-1 small">Total Employees</h6>
                                <h2 class="fw-bold mb-0" style="font-size: clamp(1.25rem, 4vw, 2rem); word-break: break-word;"><?php echo $total_employees; ?></h2>
                            </div>
                            <i class="bi bi-people-fill opacity-50" style="font-size: clamp(1.25rem, 4vw, 2rem); flex-shrink: 0; margin-left: 0.5rem;"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <small>Active in Database</small>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card bg-success text-white h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="flex-grow-1">
                                <h6 class="text-uppercase mb-1 small">Departments</h6>
                                <h2 class="fw-bold mb-0" style="font-size: clamp(1.25rem, 4vw, 2rem); word-break: break-word;"><?php echo $total_departments; ?></h2>
                            </div>
                            <i class="bi bi-building opacity-50" style="font-size: clamp(1.25rem, 4vw, 2rem); flex-shrink: 0; margin-left: 0.5rem;"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <small>Organization Units</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="card bg-info text-white h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="flex-grow-1">
                                <h6 class="text-uppercase mb-1 small">Total Salary</h6>
                                <h2 class="fw-bold mb-0" style="font-size: clamp(1.25rem, 4vw, 2rem); word-break: break-word; overflow-wrap: break-word;">₱<?php echo $total_salary; ?></h2>
                            </div>
                            <i class="bi bi-cash-stack opacity-50" style="font-size: clamp(1.25rem, 4vw, 2rem); flex-shrink: 0; margin-left: 0.5rem;"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <small>Monthly Payroll</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="card bg-warning text-white h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="flex-grow-1">
                                <h6 class="text-uppercase mb-1 small">System Users</h6>
                                <h2 class="fw-bold mb-0" style="font-size: clamp(1.25rem, 4vw, 2rem); word-break: break-word;"><?php echo $total_users; ?></h2>
                            </div>
                            <i class="bi bi-shield-lock opacity-50" style="font-size: clamp(1.25rem, 4vw, 2rem); flex-shrink: 0; margin-left: 0.5rem;"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <small>Admin Accounts</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Grid View - Module 6 -->
        <div class="mt-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold text-primary">Employee Records</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                        <i class="bi bi-person-plus me-1"></i> Add New Employee
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Emp ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Position</th>
                                    <th>Salary</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $search = $_GET['search'] ?? '';
                                if (!empty($search)) {
                                    $search_term = "%$search%";
                                    $sql = "SELECT * FROM employees WHERE 
                                            emp_id LIKE ? OR 
                                            first_name LIKE ? OR 
                                            last_name LIKE ? OR 
                                            email LIKE ? OR 
                                            department LIKE ? OR 
                                            position LIKE ?
                                            ORDER BY id DESC";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("ssssss", $search_term, $search_term, $search_term, $search_term, $search_term, $search_term);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                } else {
                                    $sql = "SELECT * FROM employees ORDER BY id DESC";
                                    $result = $conn->query($sql);
                                }
                                
                                if ($result && $result->num_rows > 0):
                                    while($row = $result->fetch_assoc()):
                                ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-secondary"><?php echo htmlspecialchars($row['emp_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email'] ?? 'N/A'); ?></td>
                                    <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars($row['department']); ?></span></td>
                                    <td><?php echo htmlspecialchars($row['position']); ?></td>
                                    <td>₱<?php echo number_format($row['salary'], 2); ?></td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $row['id']; ?>" title="View">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['id']; ?>" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- View Modal -->
                                <div class="modal fade" id="viewModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-fullscreen-sm-down">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title"><i class="bi bi-person-vcard me-2"></i> Employee Details</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- P ERSONAL INFO SECTION -->
                                                <div class="mb-4 pb-4 border-bottom">
                                                    <h6 class="text-uppercase fw-bold text-primary mb-3"><i class="bi bi-person me-2"></i>Personal Information</h6>
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label small text-muted">First Name</label>
                                                            <p class="fw-bold"><?php echo htmlspecialchars($row['first_name']); ?></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small text-muted">Last Name</label>
                                                            <p class="fw-bold"><?php echo htmlspecialchars($row['last_name']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- EMPLOYMENT INFO SECTION -->
                                                <div class="mb-4 pb-4 border-bottom">
                                                    <h6 class="text-uppercase fw-bold text-primary mb-3"><i class="bi bi-briefcase me-2"></i>Employment Information</h6>
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label small text-muted"><i class="bi bi-person-badge me-1"></i>Employee ID</label>
                                                            <p class="fw-bold"><?php echo htmlspecialchars($row['emp_id']); ?></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small text-muted"><i class="bi bi-envelope me-1"></i>Email Address</label>
                                                            <p class="fw-bold"><?php echo htmlspecialchars($row['email'] ?? 'N/A'); ?></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small text-muted"><i class="bi bi-diagram-3 me-1"></i>Department</label>
                                                            <p class="fw-bold"><?php echo htmlspecialchars($row['department']); ?></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small text-muted">Position</label>
                                                            <p class="fw-bold"><?php echo htmlspecialchars($row['position']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- LOCATION INFO SECTION -->
                                                <div class="mb-4 pb-4 border-bottom">
                                                    <h6 class="text-uppercase fw-bold text-primary mb-3"><i class="bi bi-geo-alt me-2"></i>Location Information</h6>
                                                    <label class="form-label small text-muted">Address</label>
                                                    <p class="fw-bold"><?php echo nl2br(htmlspecialchars($row['address'])); ?></p>
                                                </div>

                                                <!-- COMPENSATION SECTION -->
                                                <div class="mb-4">
                                                    <h6 class="text-uppercase fw-bold text-primary mb-3"></i>₱ Compensation</h6>
                                                    <label class="form-label small text-muted">Monthly Salary</label>
                                                    <p class="fw-bold text-success fs-5">₱<?php echo number_format($row['salary'], 2); ?></p>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-fullscreen-sm-down">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i> Edit Employee</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="edit_employee.php" method="POST">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold"><i class="bi bi-person-badge me-1"></i> Employee ID</label>
                                                            <input type="text" class="form-control" name="emp_id" value="<?php echo htmlspecialchars($row['emp_id'] ?? ''); ?>" placeholder="e.g. EMP-001" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold"><i class="bi bi-envelope me-1"></i> Email Address</label>
                                                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($row['email'] ?? ''); ?>" placeholder="email@valleyquest.com" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">First Name</label>
                                                            <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($row['first_name']); ?>" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Last Name</label>
                                                            <input type="text" class="form-control" name="last_name" value="<?php echo htmlspecialchars($row['last_name']); ?>" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold"><i class="bi bi-diagram-3 me-1"></i> Department</label>
                                                            <input type="text" class="form-control" name="department" value="<?php echo htmlspecialchars($row['department']); ?>" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold"><i class="bi bi-briefcase me-1"></i> Position</label>
                                                            <input type="text" class="form-control" name="position" value="<?php echo htmlspecialchars($row['position']); ?>" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold"><i class="bi bi-geo-alt me-1"></i> Address</label>
                                                            <textarea class="form-control" name="address" rows="2" required><?php echo htmlspecialchars($row['address']); ?></textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold"><i class="bi bi-currency-dollar me-1"></i> Salary</label>
                                                            <input type="number" step="0.01" class="form-control" name="salary" value="<?php echo $row['salary']; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update Employee</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header border-0">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center pb-4">
                                                <i class="bi bi-exclamation-circle text-danger display-4 mb-3 d-block"></i>
                                                <h5>Are you sure?</h5>
                                                <p class="text-muted small">You are about to delete <strong><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></strong>. This action cannot be undone.</p>
                                            </div>
                                            <div class="modal-footer border-0 justify-content-center">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                <a href="delete_employee.php?id=<?php echo $row['id']; ?>" class="btn btn-danger px-4">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php 
                                    endwhile;
                                else:
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-info-circle fs-2 d-block mb-2"></i>
                                        No employee records found.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Employee Modal -->
        <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen-sm-down">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="addEmployeeModalLabel"><i class="bi bi-person-plus me-2"></i> Add New Employee</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="add_employee.php" method="POST">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"><i class="bi bi-person-badge me-1"></i> Employee ID</label>
                                    <input type="text" class="form-control" name="emp_id" placeholder="e.g. EMP-001" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"><i class="bi bi-envelope me-1"></i> Email Address</label>
                                    <input type="email" class="form-control" name="email" placeholder="email@valleyquest.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">First Name</label>
                                    <input type="text" class="form-control" name="first_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"><i class="bi bi-diagram-3 me-1"></i> Department</label>
                                    <input type="text" class="form-control" name="department" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"><i class="bi bi-briefcase me-1"></i> Position</label>
                                    <input type="text" class="form-control" name="position" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold"><i class="bi bi-geo-alt me-1"></i> Address</label>
                                    <textarea class="form-control" name="address" rows="2" required></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold"><i class="bi bi-currency-dollar me-1"></i> Salary</label>
                                    <input type="number" step="0.01" class="form-control" name="salary" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Employee</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <footer class="mt-5 pt-4 border-top text-center text-muted small">
            <p>&copy; 2026 ValleyQuest Solutions. All rights reserved. | <i class="bi bi-geo-alt-fill me-1"></i> Tuguegarao City, Philippines</p>
        </footer>

    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
