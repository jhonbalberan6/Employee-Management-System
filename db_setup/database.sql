-- Employee Management System (EMS) Database Initialization
-- Database Name: `employee_db`

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+08:00"; -- Philippine Time

-- --------------------------------------------------------

--
-- Table structure for table `users` (For Admin Authentication)
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sample User: admin / password123 (hashed)
--
INSERT INTO `users` (`username`, `password`) VALUES
('admin', '$2y$10$8WvSgH.p0HhXfJj1R8lFyeM1lS7M1o1X9h6z8G.VlS7M1o1X9h6z8'); 

-- This is just a placeholder, just register another one for admin.

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(50) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `department` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping sample data for table `employees` (Cagayan Valley Focus)
--

INSERT INTO `employees` (`emp_id`, `first_name`, `last_name`, `email`, `department`, `position`, `address`, `salary`) VALUES
('EMP-2026-001', 'Juan', 'Dela Cruz', 'juan.delacruz@valleyquest.com', 'IT', 'Web Developer', 'Caritan Sur, Tuguegarao City, Cagayan', 45000.00),
('EMP-2026-002', 'Maria', 'Santos', 'maria.santos@valleyquest.com', 'HR', 'HR Specialist', 'Centro 1, Aparri, Cagayan', 38000.00),
('EMP-2026-003', 'Ricardo', 'Dizon', 'ricardo.dizon@valleyquest.com', 'Finance', 'Chief Accountant', 'Baligatan, Ilagan City, Isabela', 55000.00),
('EMP-2026-004', 'Elena', 'Bautista', 'elena.bautista@valleyquest.com', 'Sales', 'Sales Manager', 'Santiago City, Isabela', 42000.00),
('EMP-2026-005', 'Ferdinand', 'Guzman', 'f.guzman@valleyquest.com', 'IT', 'Network Engineer', 'Bayombong, Nueva Vizcaya', 48000.00),
('EMP-2026-006', 'Carmela', 'Reyes', 'c.reyes@valleyquest.com', 'Marketing', 'Creative Designer', 'Cabarroguis, Quirino', 35000.00),
('EMP-2026-007', 'Antonio', 'Pascua', 'a.pascua@valleyquest.com', 'Operations', 'Project Coordinator', 'Solano, Nueva Vizcaya', 40000.00),
('EMP-2026-008', 'Liza', 'Aquino', 'liza.aquino@valleyquest.com', 'IT', 'Database Admin', 'Tuao, Cagayan', 46000.00);

COMMIT;
