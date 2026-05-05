mysql - u root - p /*psw:root*/ create DATABASE safety_system;

USE safety_system;

CREATE TABLE departments (
    department_id VARCHAR(10) PRIMARY KEY,
    department_name VARCHAR(50) NOT NULL
);

CREATE TABLE employees (
    employee_id VARCHAR(10) PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    department_id VARCHAR(10),
    role VARCHAR(10) NOT NULL,
    FOREIGN KEY (department_id) REFERENCES departments(department_id)
);

CREATE TABLE safety_reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(10),
    status VARCHAR(20) NOT NULL,
    comment TEXT,
    report_time DATETIME NOT NULL,
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id)
);

INSERT INTO departments VALUES 
('TIT', 'IT'),
('THR', 'HR');

INSERT INTO employees VALUES 
('TIT001', 'Aye', 'tit001@test.com', 'test123', 'TIT', 'user'),
('THR001', 'Pyone', 'thr001@test.com', 'test123', 'THR', 'admin');

INSERT INTO safety_reports (employee_id, status, comment, report_time)
VALUES 
('TIT001', '怪我', 'Minor injury', NOW()),
('THR001', '無事', 'Safe at home', NOW());

SELECT e.name, d.department_name
FROM employees e
JOIN departments d
ON e.department_id = d.department_id;

INSERT INTO employees VALUES 
('TIT002', 'Kou', 'tit002@test.com', 'test123', 'TIT', 'user'),
('TIT003', 'Thar', 'tit003@test.com', 'test123', 'TIT', 'user'),
('THR002', 'Thin', 'thr002@test.com', 'test123', 'THR', 'user');