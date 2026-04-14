<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO appointment (client_id, service_provider_id, service_type_id, appointment_date) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['client_id'], $_POST['service_provider_id'], $_POST['service_type_id'], $_POST['appointment_date']]);
}

$appointments = $conn->query("
    SELECT a.id, c.first_name, c.last_name, sp.name AS provider, a.appointment_date, a.created_at
    FROM appointment a
    JOIN client c ON a.client_id = c.id
    JOIN service_provider sp ON a.service_provider_id = sp.id
")->fetchAll(PDO::FETCH_ASSOC);


// $services removed - loaded dynamically via AJAX

$clients = $conn->query("SELECT id, first_name, last_name FROM client")->fetchAll(PDO::FETCH_ASSOC);
$providers = $conn->query("SELECT id, name FROM service_provider")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Appointments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        form {
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

        select, input {
            width: 100%;
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
            font-size: 16px;
        }

        button:hover {
            background: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background: #007bff;
            color: white;
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
    <h1>Appointments</h1>

<form method="post" id="appointmentForm">
        <label>Client</label>
        <select name="client_id" id="client_id" required>
            <?php foreach ($clients as $c): ?>
                <option value="<?= $c['id'] ?>">
                    <?= $c['first_name'] . " " . $c['last_name'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Service Provider</label>
        <select name="service_provider_id" id="service_provider_id" required>
            <option value="">Select Provider</option>
            <?php foreach ($providers as $p): ?>
                <option value="<?= $p['id'] ?>">
                    <?= $p['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Service Type</label>
        <select name="service_type_id" id="service_type_id" required disabled>
            <option value="">Select Provider first</option>
        </select>

        <label>Appointment Date</label>
        <input style="width: 97.5%;" type="datetime-local" name="appointment_date" required>

        <button type="submit">Add Appointment</button>
    </form>

    <h2>Appointment List</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Client</th>
            <th>Provider</th>
            <th>Date</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($appointments as $a): ?>
            <tr>
                <td><?= $a['id'] ?></td>
                <td><?= $a['first_name'] . " " . $a['last_name'] ?></td>
                <td><?= $a['provider'] ?></td>
                <td><?= $a['appointment_date'] ?></td>
                <td><?= $a['created_at'] ?></td>
                <td> 
                    <a href="edit_appointment.php?id=<?= $a['id'] ?>" style="color: green; text-decoration: none;">Edit | </a>
                    <a href="delete_appointment.php?id=<?= $a['id'] ?>" style="color: red; text-decoration: none;" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const providerSelect = document.getElementById('service_provider_id');
    const serviceSelect = document.getElementById('service_type_id');

    providerSelect.addEventListener('change', function() {
        const providerId = this.value;
        serviceSelect.innerHTML = '<option value="">Loading...</option>';
        serviceSelect.disabled = true;

        if (!providerId) {
            serviceSelect.innerHTML = '<option value="">Select Provider first</option>';
            serviceSelect.disabled = true;
            return;
        }

        fetch(`get_services_by_provider.php?provider_id=${providerId}`)
            .then(response => response.json())
            .then(services => {
                serviceSelect.innerHTML = '<option value="">Select Service</option>';
                services.forEach(service => {
                    const option = document.createElement('option');
                    option.value = service.id;
                    option.textContent = service.name;
                    serviceSelect.appendChild(option);
                });
                serviceSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                serviceSelect.innerHTML = '<option value="">Error loading services</option>';
                serviceSelect.disabled = true;
            });
    });
});
</script>

</body>

</html>