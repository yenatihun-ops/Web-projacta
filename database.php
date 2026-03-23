<?php
$conn = mysqli_connect("localhost", "root", "Bye@2709");

if (!$conn) {
    die("Connection failed");
}

/* CREATE DATABASE */
$sql_db = "CREATE DATABASE IF NOT EXISTS drugmanagement";
mysqli_query($conn, $sql_db);

/* SELECT DATABASE */
mysqli_select_db($conn, "drugmanagement");
/* DRUGS TABLE */
$sql_drugs = "CREATE TABLE IF NOT EXISTS drugs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    drug_name VARCHAR(100),
    category VARCHAR(50),
    dosage VARCHAR(50),
    quantity INT,
   price DECIMAL(10,2) NOT NULL DEFAULT 0,
    manufacture_date DATE,
    expiry_date DATE,
    prescription VARCHAR(10),
    side_effects TEXT
)";
mysqli_query($conn, $sql_drugs);

/* SERVICES TABLE */
$sql_services = "CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(100),
    service VARCHAR(50),
    drug_name VARCHAR(100),
    service_date DATE,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $sql_services);

/* USERS TABLE */
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";
mysqli_query($conn, $sql_users);

/* ADMIN TABLE */
$sql_admin = "CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";
mysqli_query($conn, $sql_admin);

echo "✅ Database and tables created successfully";
?>
