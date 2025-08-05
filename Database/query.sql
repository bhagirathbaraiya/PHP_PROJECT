CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(255),
    lname VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    status ENUM('active', 'inactive'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (email),
    INDEX (status)
) ENGINE=InnoDB;

CREATE TABLE students (
    grno INT PRIMARY KEY,
    erno INT UNIQUE,
    fname VARCHAR(255),
    lname VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    mobile BIGINT,
    telegram BIGINT,
    status ENUM('active', 'inactive'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (erno),
    INDEX (email),
    INDEX (mobile),
    INDEX (status)
) ENGINE=InnoDB;

CREATE TABLE faculty (
    erno INT PRIMARY KEY,
    fname VARCHAR(255),
    lname VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    mobile BIGINT,
    telegram BIGINT,
    status ENUM('active', 'inactive'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (email),
    INDEX (mobile),
    INDEX (status)
) ENGINE=InnoDB;

CREATE TABLE class (
    id INT AUTO_INCREMENT PRIMARY KEY,
    host_id INT,
    name VARCHAR(255),
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (host_id),
    INDEX (name),
    FOREIGN KEY (host_id) REFERENCES faculty(erno) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE student_to_class (
    id INT AUTO_INCREMENT PRIMARY KEY,
    grno INT,
    class_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (grno),
    INDEX (class_id),
    FOREIGN KEY (grno) REFERENCES students(grno) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES class(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description VARCHAR(255),
    due_date DATE,
    class_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (name),
    INDEX (due_date),
    INDEX (class_id),
    FOREIGN KEY (class_id) REFERENCES class(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE notebook (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (class_id),
    FOREIGN KEY (class_id) REFERENCES class(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE assignment_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    assignment_id INT,
    grno INT,
    submission_file VARCHAR(255),
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    graded_by INT,
    grade VARCHAR(50),
    feedback TEXT,
    status ENUM('submitted', 'graded', 'pending'),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (assignment_id),
    INDEX (grno),
    INDEX (submitted_at),
    INDEX (graded_by),
    INDEX (grade),
    INDEX (status),
    FOREIGN KEY (assignment_id) REFERENCES assignments(id) ON DELETE CASCADE,
    FOREIGN KEY (grno) REFERENCES students(grno) ON DELETE CASCADE,
    FOREIGN KEY (graded_by) REFERENCES faculty(erno) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE notebook_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    notebook_id INT,
    grno INT,
    submission_file VARCHAR(255),
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    graded_by INT,
    grade VARCHAR(50),
    feedback TEXT,
    status ENUM('submitted', 'graded', 'pending'),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (notebook_id),
    INDEX (grno),
    INDEX (submitted_at),
    INDEX (graded_by),
    INDEX (grade),
    INDEX (status),
    FOREIGN KEY (notebook_id) REFERENCES notebook(id) ON DELETE CASCADE,
    FOREIGN KEY (grno) REFERENCES students(grno) ON DELETE CASCADE,
    FOREIGN KEY (graded_by) REFERENCES faculty(erno) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    role ENUM('admin', 'faculty', 'student'),
    message VARCHAR(255),
    status ENUM('unread', 'read'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (user_id),
    INDEX (role),
    INDEX (status)
) ENGINE=InnoDB;

CREATE TABLE common_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    user_role ENUM('admin', 'faculty', 'student'),
    action ENUM('login', 'logout', 'update', 'create', 'delete'),
    description VARCHAR(255),
    status ENUM('success', 'failed'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (user_id),
    INDEX (user_role),
    INDEX (action),
    INDEX (status),
    INDEX (created_at)
) ENGINE=InnoDB;
