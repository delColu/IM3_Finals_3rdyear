<?php
include 'db_connect.php';

$id = $_GET['id'] ?? null;
$service = null;
$providers = $conn->query("SELECT id, name FROM service_providers")->fetchAll(PDO::FETCH_ASSOC);

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->execute([$id]);
    $service = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("UPDATE services SET provider_id = ?, name = ?, description = ?, price = ? WHERE id = ?");
    $stmt->execute([$_POST['provider_id'], $_POST['name'], $_POST['description'], $_POST['price'], $id]);
    header('Location: index_services.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Service</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f6f9; }
        .container { max-width: 900px; margin: 20px auto; }
        h1 { text-align: center; }
        form { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        label { font-weight: bold; display: block; margin-top: 10px; }
        input, select, textarea { width: 97.5%; padding: 10px; margin-top: 5px; border-radius: 6px; border: 1px solid #ccc; }
        select { width: 100%; }
        textarea { resize: vertical; }
        button { margin-top: 15px; padding: 10px; width: 100%; background: #6f42c1; color: white; border: none; border-radius: 6px; cursor: pointer; }
        button:hover { background: #59359c; }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #6f42c1; text-decoration: none; }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">
    <h1>Edit Service</h1>
    <?php if ($service): ?>
    <form method="post">
        <label>Service Provider</label>
        <select name="provider_id" required>
            <?php foreach ($providers as $p): ?>
                <option value="<?= $p['id'] ?>" <?= $service['provider_id'] == $p['id'] ? 'selected' : '' ?>>
                    <?= $p['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Service Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($service['name']) ?>" required>

        <label>Description</label>
        <textarea name="description"><?= htmlspecialchars($service['description']) ?></textarea>

        <label>Price</label>
        <input type="number" step="0.01" name="price" value="<?= $service['price'] ?>" required>

        <button type="submit">Update Service</button>
    </form>
    <?php else: ?>
        <p>Service not found.</p>
    <?php endif; ?>
    <div class="back-link"><a href="index_services.php">Back to Services</a></div>
</div>

</body>
</html>
