<?php
include 'db_connect.php';

try {
    // Ensure PDO throws exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create client table
    $sql = "CREATE TABLE IF NOT EXISTS client (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        email VARCHAR(150) UNIQUE NOT NULL,
        phone VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB";
    $conn->exec($sql);
    echo "Table 'client' created successfully.<br>";

    // Create service_provider table
    $sql = "CREATE TABLE IF NOT EXISTS service_provider (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) UNIQUE NOT NULL,
        phone VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB";
    $conn->exec($sql);
    echo "Table 'service_provider' created successfully.<br>";

    // Create appointment table
    $sql = "CREATE TABLE IF NOT EXISTS appointment (
        id INT AUTO_INCREMENT PRIMARY KEY,
        client_id INT NOT NULL,
        service_provider_id INT NOT NULL,
        appointment_date DATETIME NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (client_id) REFERENCES client(id) ON DELETE CASCADE,
        FOREIGN KEY (service_provider_id) REFERENCES service_provider(id) ON DELETE CASCADE
    ) ENGINE=InnoDB";
    $conn->exec($sql);
    echo "Table 'appointment' created successfully.<br>";

    // create services table
    $sql = "CREATE TABLE IF NOT EXISTS services (
        id INT AUTO_INCREMENT PRIMARY KEY,
        provider_id INT NOT NULL,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        price DECIMAL(10, 2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (provider_id) REFERENCES service_provider(id) ON DELETE CASCADE
    ) ENGINE=InnoDB";
    $conn->exec($sql);
    echo "Table 'services' created successfully.<br>";

} catch (PDOException $e) {
    echo "Error creating tables: " . $e->getMessage();
}
?>