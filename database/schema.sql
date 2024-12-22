-- Drop existing tables in correct order
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS user_courses;
DROP TABLE IF EXISTS courses;
DROP TABLE IF EXISTS subscriptions;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS auth_logs;
DROP TABLE IF EXISTS remember_me_tokens;
SET FOREIGN_KEY_CHECKS = 1;

-- Create products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    monthly_price DECIMAL(10,2) NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Create customers table
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Create orders table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    product_id INT NOT NULL,
    plan VARCHAR(50) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'completed', 'failed', 'cancelled') DEFAULT 'pending',
    payment_id VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB;

-- Create courses table
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    duration VARCHAR(50),
    status ENUM('active', 'inactive') DEFAULT 'active',
    students_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Create user_courses table
CREATE TABLE user_courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    progress INT DEFAULT 0,
    status ENUM('active', 'completed', 'cancelled') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES customers(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
) ENGINE=InnoDB;

-- Create subscriptions table
CREATE TABLE subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    status ENUM('active', 'cancelled', 'expired') DEFAULT 'active',
    renewal_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES customers(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB;

-- Create auth_logs table
CREATE TABLE auth_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_type ENUM('customer', 'admin', 'unknown') NOT NULL,
    user_id INT,
    action VARCHAR(50) NOT NULL,
    details JSON,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Create remember_me_tokens table
CREATE TABLE remember_me_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_type ENUM('customer', 'admin') NOT NULL,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insert sample products
INSERT INTO products (id, name, description, monthly_price, status) VALUES
-- EduManager LMS Products
(1, 'EduManager LMS - Starter', 'For Small Institutions - Up to 500 students, Basic LMS features, Virtual classrooms, Basic analytics', 2499.00, 'active'),
(2, 'EduManager LMS - Professional', 'For Medium Institutions - Up to 2000 students, Advanced LMS features, Interactive virtual classrooms, Advanced analytics', 4999.00, 'active'),
(3, 'EduManager LMS - Enterprise', 'For Large Institutions - Unlimited students, Full LMS suite, Advanced virtual classrooms, Enterprise analytics', 9999.00, 'active'),

-- HR System Products
(4, 'HR System - Basic', 'Essential HR management for small teams - Up to 50 employees, Employee management, Leave management, Basic reporting', 1999.00, 'active'),
(5, 'HR System - Professional', 'Advanced HR solutions for growing organizations - Up to 200 employees, Full HR management, Payroll processing, Performance management', 3999.00, 'active'),
(6, 'HR System - Enterprise', 'Complete HR suite for large organizations - Unlimited employees, Advanced HR analytics, Custom workflows, API access', 7999.00, 'active'),

-- Financial System Products
(7, 'Financial System - Basic', 'Essential financial tools for small businesses - Basic accounting, Invoice management, Expense tracking', 2999.00, 'active'),
(8, 'Financial System - Professional', 'Advanced financial management - Full accounting suite, Financial reporting, Budgeting tools', 5999.00, 'active'),
(9, 'Financial System - Enterprise', 'Enterprise financial solutions - Advanced analytics, Multi-entity management, Custom integrations', 11999.00, 'active'),

-- Analytics Suite Products
(10, 'Analytics Suite - Basic', 'Essential analytics tools - Basic reporting, Data visualization, Standard dashboards', 1499.00, 'active'),
(11, 'Analytics Suite - Professional', 'Advanced analytics platform - Custom reports, Advanced visualizations, Data integration', 3499.00, 'active'),
(12, 'Analytics Suite - Enterprise', 'Enterprise analytics solution - AI-powered insights, Predictive analytics, Custom solutions', 6999.00, 'active');

-- Insert sample courses
INSERT INTO courses (name, description, duration, status, students_count) VALUES
('Introduction to Educational Technology', 'Learn the basics of EdTech', '6 weeks', 'active', 150),
('Advanced Learning Management', 'Master LMS administration', '8 weeks', 'active', 75),
('Digital Classroom Strategies', 'Modern teaching techniques', '4 weeks', 'active', 200);

-- Insert test user (password: Test@123)
INSERT INTO customers (first_name, last_name, email, password_hash, is_active) VALUES
('Test', 'User', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);