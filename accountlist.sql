CREATE DATABASE accountlist;
USE accountlist;
CREATE TABLE users
(
id INT AUTO_INCREMENT,
first_name VARCHAR(255) NOT NULL,
last_name VARCHAR(255) NOT NULL,
email VARCHAR(100) NOT NULL,
company_name VARCHAR(255),
position VARCHAR(255),
phone1 VARCHAR(50),
phone2 VARCHAR(50),
phone3 VARCHAR(50),
PRIMARY KEY(id)
);