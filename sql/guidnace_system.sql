-- Create Database
CREATE DATABASE guidance_system;

-- Use the newly created database
USE guidance_system;

-- Admin Table
CREATE TABLE admins (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Store hashed passwords
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Counselor Table
CREATE TABLE counselors (
    counselor_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Store hashed passwords
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Students Table
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    parent_name VARCHAR(100),
    parent_contact_number VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Counseling Sessions Table
CREATE TABLE counseling_sessions (
    session_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    counselor_id INT NOT NULL,
    session_date DATE NOT NULL,
    session_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (counselor_id) REFERENCES counselors(counselor_id) ON DELETE CASCADE
);

-- Appointments Table
CREATE TABLE appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    counselor_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    reason VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (counselor_id) REFERENCES counselors(counselor_id) ON DELETE CASCADE
);

-- Referral Reasons Table
CREATE TABLE referral_reasons (
    reason_id INT AUTO_INCREMENT PRIMARY KEY,
    counselor_id INT NOT NULL,
    reason_description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (counselor_id) REFERENCES counselors(counselor_id) ON DELETE CASCADE
);
