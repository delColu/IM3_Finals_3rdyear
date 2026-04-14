<?php
$servername = "localhost";
$username = "root";   // change if you use a different MySQL user
$password = "";       // set your MySQL password if you have one
$dbname = "appointments_system"; // name of the database you want to create

try {
    // Connect to MySQL without specifying a database
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // drop database if it already exists (optional, be careful with this in production)
    $sql = "DROP DATABASE IF EXISTS $dbname";
    $conn->exec($sql);
    echo "Database '$dbname' dropped successfully.<br>";

    // Create database if it doesn’t exist
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $conn->exec($sql);

    echo "Database '$dbname' created successfully.";
} catch (PDOException $e) {
    echo "Error creating database: " . $e->getMessage();
}
?>