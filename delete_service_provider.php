<?php 
include 'db_connect.php';

if (isset($_GET['id'])) {
    $service_provider = $_GET['id'];

    try {
        // Prepare and execute the delete statement
        $stmt = $conn->prepare("DELETE FROM service_provider WHERE id = :id");
        $stmt->bindParam(':id', $service_providers, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to the service_provider page after deletion
        header("Location: index_service_provider.php");
        exit();
    } catch (PDOException $e) {
        // Handle any errors during deletion
        die("Error deleting service provider: " . $e->getMessage());
    }
} else {
    // If no ID is provided, redirect back to the service_provider page
    header("Location: index_service_provider.php");
    exit();
}

?>