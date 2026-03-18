# ValleyQuest Solutions - Employee Management System (EMS)

A secure, responsive, and localized web application for managing employee records, specifically designed as a prototype for **ValleyQuest Solutions** a placeholder company.

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![PHP](https://img.shields.io/badge/PHP-8.x-777BB4.svg)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3.svg)
![MySQL](https://img.shields.io/badge/MySQL-Data-4479A1.svg)

## Overview

ValleyQuest Solutions EMS is a specialized HR tool built to handle the lifecycle of employee data. It features a modern, mobile-first interface using **Bootswatch Cerulean** and provides full CRUD (Create, Read, Update, Delete) capabilities through an intuitive, modal-driven dashboard.

### Key Features
- **Secure Authentication:** Admin login/registration with BCRYPT password hashing.
- **Dynamic Dashboard:** Real-time metrics for total employees, departments, and payroll.
- **Offcanvas Navigation:** Modern, responsive sidebar that works seamlessly on mobile and desktop.
- **Advanced Data Grid:** Searchable employee table with localized currency (₱ PHP).
- **Modal-Driven CRUD:** Manage records without leaving the dashboard page.
- **Search Engine:** Filter records by Name, ID, Department, or Position using SQL prepared statements.

## Technical Stack
- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5 (Bootswatch Cerulean), Bootstrap Icons.
- **Backend:** PHP 8.x.
- **Database:** MySQL.
- **Security:** Prepared Statements (SQLi protection), Session Management, Password Hashing (XSS/Auth protection).

## 📂 Project Structure
```text
ems-project1/
├── assets/
│   └── style.css       # Custom UI refinements & offcanvas logic
├── add_employee.php    # Logic: Secure record insertion
├── edit_employee.php   # Logic: Secure record updates
├── delete_employee.php # Logic: Secure record deletion
├── admin_dashboard.php # UI: Main dashboard, metrics & data grid
├── connect.php         # Database: Centralized MySQLi connection
├── index.php           # UI: Branded Login & Registration
├── login.php           # Logic: Authentication & Session start
├── register.php        # Logic: Admin account creation
├── logout.php          # Logic: Secure session termination
├── database.sql        # Database: Schema & localized sample data
└── STUDY_GUIDE.md      # Documentation: Defense & technical walkthrough
```

## Installation & Setup

1.  **Prerequisites:** Ensure you have a local server environment like **XAMPP**, **WAMP**, or **Laragon**.
2.  **Clone the Repository:**
    ```bash
    git clone https://github.com/yourusername/valleyquest-ems.git
    ```
3.  **Database Setup:**
    - Open **phpMyAdmin**.
    - Create a new database named `employee_db`.
    - Import the `database.sql` file provided in the root folder.
4.  **Configuration:**
    - Open `connect.php` and verify the database credentials (default is `root` with no password).
5.  **Run the App:**
    - Move the folder to your `htdocs` or `www` directory.
    - Navigate to `http://localhost/ems-project1/index.php`.


---
*Developed as a prototype for Web System and Technologies 2 Course*
