<?php
include 'db_connect.php';

try {
    // Ensure PDO throws exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create clients table
    $sql = "CREATE TABLE IF NOT EXISTS clients (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        email VARCHAR(150) UNIQUE NOT NULL,
        phone VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB";
    $conn->exec($sql);
    echo "Table 'clients' created successfully.<br>";

    // Create service_providers table
    $sql = "CREATE TABLE IF NOT EXISTS service_providers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) UNIQUE NOT NULL,
        phone VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB";
    $conn->exec($sql);
    echo "Table 'service_providers' created successfully.<br>";

    // Create services table
    $sql = "CREATE TABLE IF NOT EXISTS services (
        id INT AUTO_INCREMENT PRIMARY KEY,
        provider_id INT NOT NULL,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        price DECIMAL(10, 2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (provider_id) REFERENCES service_providers(id) ON DELETE CASCADE
    ) ENGINE=InnoDB";
    $conn->exec($sql);
    echo "Table 'services' created successfully.<br>";

    // Create appointments table
    $sql = "CREATE TABLE IF NOT EXISTS appointments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        client_id INT NOT NULL,
        service_provider_id INT NOT NULL,
        service_type_id INT NOT NULL,
        appointment_date DATETIME NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
        FOREIGN KEY (service_provider_id) REFERENCES service_providers(id) ON DELETE CASCADE,
        FOREIGN KEY (service_type_id) REFERENCES services(id) ON DELETE CASCADE
    ) ENGINE=InnoDB";
    $conn->exec($sql);
    echo "Table 'appointments' created successfully.<br>";

    echo "All tables created successfully!<br>";

} catch (PDOException $e) {
    echo "Error creating tables: " . $e->getMessage();
}
?>

