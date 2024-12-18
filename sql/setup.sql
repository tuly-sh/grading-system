-- Create Transport Table
CREATE TABLE transport (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transport_name VARCHAR(255) NOT NULL,
    tracking_number VARCHAR(255) NOT NULL,
    latitude FLOAT NOT NULL, -- Added latitude column
    longitude FLOAT NOT NULL -- Added longitude column
);

-- Insert Transport Records with Latitude and Longitude
INSERT INTO transport (transport_name, tracking_number, latitude, longitude)
VALUES 
    ('Truck A', 'TRK12345', -34.397, 150.644),
    ('Truck B', 'TRK67890', -34.500, 150.700);

-- Create Packages Table
CREATE TABLE packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    package_name VARCHAR(255) NOT NULL,
    package_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Packages Data
INSERT INTO packages (package_name, package_description) 
VALUES 
    ('Package 1', 'Description for Package 1'),
    ('Package 2', 'Description for Package 2');

-- Create Grading Table
CREATE TABLE grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    crop_name VARCHAR(255) NOT NULL,
    grade VARCHAR(50) NOT NULL,
    inspector_id INT NOT NULL,
    inspection_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'inspector') NOT NULL
);

-- Insert Example Admin User
INSERT INTO users (username, password, role) 
VALUES ('admin', MD5('adminpassword'), 'admin');
