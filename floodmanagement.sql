CREATE DATABASE Flood_relief_db;

CREATE TABLE Users(
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(100),
    Email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('user','admin') DEFAULT 'user',
    contact VARCHAR(20),
   	district VARCHAR (50),  
    divisional_secretariat VARCHAR (100),
    gn_division VARCHAR (100),
    address TEXT,
    family_members INT); 

CREATE TABLE Relief_requests(
    request_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    relief_type ENUM('food','water','shelter'),
    district VARCHAR(50),
    divisional_secretariat VARCHAR(100),
    gn_division VARCHAR(100),
    severity ENUM('Low', 'Medium', 'High'),
    status ENUM('pending','in_progress','completed','rejected') DEFAULT 'pending',
    description TEXT,
    FOREIGN KEY (user_id) REFERENCES Users(user_id));

CREATE TABLE admin_logins(
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(100),
    Email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    contact VARCHAR(20),
    district VARCHAR(50));

  

