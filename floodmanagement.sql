CREATE DATABASE Flood_relief_db;
CREATE TABLE Users(
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100),
    Email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('user','admin') DEFAULT 'user',
    contact_number VARCHAR(10),
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
    description TEXT,
    status ENUM('pending','in_progress','completed','rejected') DEFAULT 'pending',
    description TEXT,
    FOREIGN KEY (user_id) REFERENCES Users(user_id));

CREATE TABLE admin_logins(
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    admin_name VARCHAR(100),
    Email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    target_id INT,
    details TEXT);

#the tables needed some fixing to do so I have edited the code and added some missing fields and also changed the relief type to match the options in the form.
SHOW TABLES;


DROP TABLE IF EXISTS Relief_requests;

CREATE TABLE Relief_requests(
    request_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    relief_type ENUM('food','water','medicine','shelter'),
    district VARCHAR(50),
    divisional_secretariat VARCHAR(100),
    gn_division VARCHAR(100),
    severity ENUM('Low', 'Medium', 'High'),
    description TEXT,
    status ENUM('pending','in_progress','completed','rejected') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);


DESCRIBE Users;


ALTER TABLE Users 
CHANGE full_name fullname VARCHAR(100),
CHANGE contact_number contact VARCHAR(20), 


ALTER TABLE admin_logins
CHANGE admin_name fullname VARCHAR(100),
CHANGE target_id contact VARCHAR(20), 
CHANGE details district VARCHAR(50);
