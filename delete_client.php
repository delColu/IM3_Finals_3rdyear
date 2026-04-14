<?php 
include 'db_connect.php';

if (isset($_GET['id'])) {
$clientId = $_GET['id'];

    try {
        // Prepare and execute the delete statement
        $stmt = $conn->prepare("DELETE FROM client WHERE id = :id");
$stmt->bindParam(':id', $clientId, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to the clients page after deletion
        header("Location: index_client.php");
        exit();
    } catch (PDOException $e) {
        // Handle any errors during deletion
        die("Error deleting client: " . $e->getMessage());
    }
} else {
    // If no ID is provided, redirect back to the clients page
    header("Location: index_client.php");
    exit();
}

?>