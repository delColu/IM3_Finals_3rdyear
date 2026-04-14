<?php
include 'db_connect.php';

$id = $_GET['id'] ?? null;
$appointment = null;
$clients = $conn->query("SELECT id, first_name, last_name FROM clients")->fetchAll(PDO::FETCH_ASSOC);
$providers = $conn->query("SELECT id, name FROM service_providers")->fetchAll(PDO::FETCH_ASSOC);
// $services removed - loaded via JS

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM appointments WHERE id = ?");
    $stmt->execute([$id]);
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("UPDATE appointments SET client_id = ?, service_provider_id = ?, service_type_id = ?, appointment_date = ? WHERE id = ?");
    $stmt->execute([$_POST['client_id'], $_POST['service_provider_id'], $_POST['service_type_id'], $_POST['appointment_date'], $id]);
    header('Location: index_appointments.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Appointment</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: auto; }
        h1 { text-align: center; color: #333; }
        form { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        label { font-weight: bold; display: block; margin-top: 10px; }
        select, input { width: 100%; padding: 10px; margin-top: 5px; border-radius: 6px; border: 1px solid #ccc; }
        button { margin-top: 15px; padding: 10px; width: 100%; background: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; }
        button:hover { background: #0056b3; }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #007bff; text-decoration: none; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        th { background: #007bff; color: white; }
        th, td { padding: 12px; text-align: center; }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">
    <h1>Edit Appointment</h1>
    <?php if ($appointment): ?>
    <form method="post" id="editAppointmentForm">
        <label>Client</label>
        <select name="client_id" id="edit_client_id" required>
            <?php foreach ($clients as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $appointment['client_id'] == $c['id'] ? 'selected' : '' ?>>
                    <?= $c['first_name'] . " " . $c['last_name'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Service Provider</label>
        <select name="service_provider_id" id="edit_service_provider_id" required>
            <option value="">Select Provider</option>
            <?php foreach ($providers as $p): ?>
                <option value="<?= $p['id'] ?>" <?= $appointment['service_provider_id'] == $p['id'] ? 'selected' : '' ?>>
                    <?= $p['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Service Type</label>
        <select name="service_type_id" id="edit_service_type_id" required disabled>
            <option value="">Select Provider first</option>
        </select>

        <label>Appointment Date</label>
        <input type="datetime-local" name="appointment_date" id="appointment_date" value="<?= $appointment['appointment_date'] ?>" required style="width: 97.5%;">

        <button type="submit">Update Appointment</button>
    </form>
    <?php else: ?>
        <p>Appointment not found.</p>
    <?php endif; ?>
    <div class="back-link"><a href="index_appointments.php">Back to Appointments</a></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const providerSelect = document.getElementById('edit_service_provider_id');
    const serviceSelect = document.getElementById('edit_service_type_id');
    const selectedServiceId = '<?= $appointment['service_type_id'] ?? '' ?>';

    function loadServices(providerId) {
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
                let serviceSelected = false;
                services.forEach(service => {
                    const option = document.createElement('option');
                    option.value = service.id;
                    option.textContent = service.name;
                    if (service.id == selectedServiceId) {
                        option.selected = true;
                        serviceSelected = true;
                    }
                    serviceSelect.appendChild(option);
                });
                serviceSelect.disabled = false;
                if (!serviceSelected && selectedServiceId) {
                    serviceSelect.innerHTML += `<option value="${selectedServiceId}" selected>(Service no longer available)</option>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                serviceSelect.innerHTML = '<option value="">Error loading services</option>';
                serviceSelect.disabled = true;
            });
    }

    // Load initial services for existing appointment
    const initialProviderId = '<?= $appointment['service_provider_id'] ?? '' ?>';
    if (initialProviderId) {
        loadServices(initialProviderId);
    }

    // Listen for provider change
    providerSelect.addEventListener('change', function() {
        loadServices(this.value);
    });
});
</script>

</body>

</html>
