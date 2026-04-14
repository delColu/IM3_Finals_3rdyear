<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO services (provider_id, name, description, price) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $_POST['provider_id'],
        $_POST['name'],
        $_POST['description'],
        $_POST['price']
    ]);
}

$services = $conn->query("
    SELECT s.*, sp.name AS provider_name
    FROM services s
    JOIN service_provider sp ON s.provider_id = sp.id
")->fetchAll(PDO::FETCH_ASSOC);

$providers = $conn->query("SELECT id, name FROM service_provider")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Services</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
        }

        h1, h2 {
            text-align: center;
        }

        form, table {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input, select, textarea {
            width: 97.5%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        textarea {
            resize: vertical;
        }

        button {
            margin-top: 15px;
            padding: 10px;
            width: 100%;
            background: #6f42c1;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #59359c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #6f42c1;
            color: white;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        tr:hover {
            background: #f3e8ff;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h1>Services</h1>

    <form method="post">
        <label>Service Provider</label>
        <select name="provider_id" required>
            <?php foreach ($providers as $p): ?>
                <option value="<?= $p['id'] ?>">
                    <?= $p['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Service Name</label>
        <input type="text" name="name" required>

        <label>Description</label>
        <textarea name="description"></textarea>

        <label>Price</label>
        <input type="number" step="0.01" name="price" required>

        <button type="submit">Add Service</button>
    </form>

    <h2>Service List</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Provider</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($services as $s): ?>
            <tr>
                <td><?= $s['id'] ?></td>
                <td><?= $s['provider_name'] ?></td>
                <td><?= $s['name'] ?></td>
                <td><?= $s['description'] ?></td>
                <td>₱<?= number_format($s['price'], 2) ?></td>
                <td><?= $s['created_at'] ?></td>
                <td>
                    <a href="edit_service.php?id=<?= $s['id'] ?>" style="color: green; text-decoration: none;">Edit | </a>
                    <a href="delete_service.php?id=<?= $s['id'] ?>" style="color: red; text-decoration: none;" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>