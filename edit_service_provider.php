<?php
include 'db_connect.php';

$id = $_GET['id'] ?? null;
$provider = null;

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM service_provider WHERE id = ?");
    $stmt->execute([$id]);
    $provider = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("UPDATE service_provider SET name = ?, email = ?, phone = ? WHERE id = ?");
    $stmt->execute([$_POST['name'], $_POST['email'], $_POST['phone'], $id]);
    header('Location: index_service_provider.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Service Provider</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 900px; margin: auto; }
        h1 { text-align: center; }
        form { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        label { font-weight: bold; display: block; margin-top: 10px; }
        input { width: 97.5%; padding: 10px; margin-top: 5px; border-radius: 6px; border: 1px solid #ccc; }
        button { margin-top: 15px; padding: 10px; width: 100%; background: #28a745; color: white; border: none; border-radius: 6px; cursor: pointer; }
        button:hover { background: #218838; }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #28a745; text-decoration: none; }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">
    <h1>Edit Service Provider</h1>
    <?php if ($provider): ?>
    <form method="post">
        <label>Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($provider['name']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($provider['email']) ?>" required>

        <label>Phone</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($provider['phone']) ?>">

        <button type="submit">Update Provider</button>
    </form>
    <?php else: ?>
        <p>Provider not found.</p>
    <?php endif; ?>
    <div class="back-link"><a href="index_service_provider.php">Back to Providers</a></div>
</div>

</body>
</html>
