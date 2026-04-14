<?php 
include 'db_connect.php';

if (isset($_GET['id'])) {
    $appointmentId = $_GET['id'];

    try {
        // Prepare and execute the delete statement
        $stmt = $conn->prepare("DELETE FROM appointments WHERE id = :id");
        $stmt->bindParam(':id', $appointmentId, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to the appointments page after deletion
        header("Location: index_appointments.php");
        exit();
    } catch (PDOException $e) {
        // Handle any errors during deletion
        die("Error deleting appointment: " . $e->getMessage());
    }
} else {
// If no ID is provided, redirect back to the appointments page
    header("Location: index_appointments.php");
    exit();
}

?>