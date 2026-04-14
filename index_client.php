<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO clients (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone']]);
}

$clients = $conn->query("SELECT * FROM clients")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Clients</title>
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
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #007bff;
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
            background: #e9f2ff;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>



<div class="container">
    <h1>Clients</h1>

    <form method="post">
        <label>First Name</label>
        <input type="text" name="first_name" required>

        <label>Last Name</label>
        <input type="text" name="last_name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Phone</label>
        <input type="text" name="phone">

        <button type="submit">Add Client</button>
    </form>

    <h2>Client List</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Created</th>
            <th>Actions </th>
        </tr>
        <?php foreach ($clients as $c): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= $c['first_name'] . " " . $c['last_name'] ?></td>
                <td><?= $c['email'] ?></td>
                <td><?= $c['phone'] ?></td>
                <td><?= $c['created_at'] ?></td>
                <td>
                    <a href="edit_client.php?id=<?= $c['id'] ?>" style="color: green; text-decoration: none;">Edit | </a>
                    <a href="delete_client.php?id=<?= $c['id'] ?>" style="color: red; text-decoration: none;" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>