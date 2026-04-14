<?php 
include 'db_connect.php';

if (isset($_GET['id'])) {
    $service = $_GET['id'];

    try {
        // Prepare and execute the delete statement
        $stmt = $conn->prepare("DELETE FROM services WHERE id = :id");
        $stmt->bindParam(':id', $service, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to the services page after deletion
        header("Location: index_services.php");
        exit();
    } catch (PDOException $e) {
        // Handle any errors during deletion
        die("Error deleting service: " . $e->getMessage());
    }
} else {
    // If no ID is provided, redirect back to the services page
    header("Location: index_services.php");
    exit();
}

?>