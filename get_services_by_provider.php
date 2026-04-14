<?php
include 'db_connect.php';

header('Content-Type: application/json');

$provider_id = $_GET['provider_id'] ?? null;

if (!$provider_id || !is_numeric($provider_id)) {
    echo json_encode([]);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT id, name FROM services WHERE provider_id = ?");
    $stmt->execute([$provider_id]);
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($services);
} catch (PDOException $e) {
    echo json_encode([]);
}
?>

