<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO service_providers (name, email, phone) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['name'], $_POST['email'], $_POST['phone']]);
}

$providers = $conn->query("SELECT * FROM service_providers")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Service Providers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
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
        input {
            width: 97.5%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 15px;
            padding: 10px;
            width: 100%;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #28a745;
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
            background: #e9f7ef;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">
    <h1>Service Providers</h1>

    <form method="post">
        <label>Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Phone</label>
        <input type="text" name="phone">

        <button type="submit">Add Provider</button>
    </form>

    <h2>Provider List</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($providers as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= $p['name'] ?></td>
                <td><?= $p['email'] ?></td>
                <td><?= $p['phone'] ?></td>
                <td><?= $p['created_at'] ?></td>
                <td>
                    <a href="edit_service_provider.php?id=<?= $p['id'] ?>" style="color: green; text-decoration: none;">Edit | </a>
                    <a href="delete_service_provider.php?id=<?= $p['id'] ?>" style="color: red; text-decoration: none;" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>