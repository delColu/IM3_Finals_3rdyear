<?php
include 'db_connect.php';

$id = $_GET['id'] ?? null;
$client = null;

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM client WHERE id = ?");
    $stmt->execute([$id]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("UPDATE client SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?");
    $stmt->execute([$_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone'], $id]);
    header('Location: index_client.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Client</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 900px; margin: auto; }
        h1 { text-align: center; }
        form { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        label { font-weight: bold; display: block; margin-top: 10px; }
        input { width: 97.5%; padding: 10px; margin-top: 5px; border-radius: 6px; border: 1px solid #ccc; }
        button { margin-top: 15px; padding: 10px; width: 100%; background: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">
    <h1>Edit Client</h1>
    <?php if ($client): ?>
    <form method="post">
        <label>First Name</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($client['first_name']) ?>" required>

        <label>Last Name</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($client['last_name']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($client['email']) ?>" required>

        <label>Phone</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($client['phone']) ?>">

        <button type="submit">Update Client</button>
    </form>
    <?php else: ?>
        <p>Client not found.</p>
    <?php endif; ?>
    <div class="back-link"><a href="index_client.php">Back to Clients</a></div>
</div>

</body>
</html>
