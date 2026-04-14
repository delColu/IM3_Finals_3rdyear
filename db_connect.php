<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "appointments_system";

try {
    // Create PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // echo "Connection successful"; 
} catch (PDOException $e) {
    // Handle connection error
    die("Connection failed: " . $e->getMessage());
}
?>