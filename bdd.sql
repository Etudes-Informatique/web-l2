CREATE DATABASE task_manager;
USE task_manager;

CREATE TABLE accounts (
    identifiant VARCHAR(100) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tasks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    identifiant VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deadline TIMESTAMP NULL DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    priority VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    status VARCHAR(100) NOT NULL DEFAULT "Non Commencé",
    finished TINYINT(1) DEFAULT 0
);