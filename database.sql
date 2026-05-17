CREATE DATABASE gods_grace_produce;
USE gods_grace_produce;

-- =========================
-- USERS TABLE
-- =========================

CREATE TABLE users (

    id INT AUTO_INCREMENT PRIMARY KEY,

    fullname VARCHAR(100) NOT NULL,

    email VARCHAR(100) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    role ENUM('customer','seller') DEFAULT 'customer',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

-- =========================
-- PRODUCTS TABLE
-- =========================

CREATE TABLE products (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL,

    description TEXT NOT NULL,

    price DECIMAL(10,2) NOT NULL,

    image VARCHAR(255) NOT NULL,

    seller_name VARCHAR(100) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

-- =========================
-- ORDERS TABLE
-- =========================

CREATE TABLE orders (

    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    customer_name VARCHAR(100) NOT NULL,

    seller_name VARCHAR(100) NOT NULL,

    product_name VARCHAR(100) NOT NULL,

    price DECIMAL(10,2) NOT NULL,

    quantity INT NOT NULL,

    total DECIMAL(10,2) NOT NULL,

    status ENUM('Pending','Completed') DEFAULT 'Pending',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id)

);

-- =========================
-- REVIEWS TABLE
-- =========================

CREATE TABLE reviews (

    id INT AUTO_INCREMENT PRIMARY KEY,

    customer_name VARCHAR(100) NOT NULL,

    seller_name VARCHAR(100) NOT NULL,

    rating INT NOT NULL CHECK (rating >=1 AND rating <=5),

    review TEXT NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);
