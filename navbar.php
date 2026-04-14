<style>
.navbar {
    background: #1e293b;
    padding: 15px 20px;
    margin-bottom: 20px;
    display: flex;
    gap: 20px;
}

.navbar a {
    color: #e2e8f0;
    text-decoration: none;
    font-weight: 500;
    padding: 8px 12px;
    border-radius: 6px;
    transition: 0.3s;
}

.navbar a:hover {
    background: #334155;
    color: #fff;
}

.active {
    background: #3b82f6;
    color: white !important;
}

body {
    margin: 0;
    padding: 0;
}


</style>

<div class="navbar">
    <a href="index_appointments.php" class="<?= basename($_SERVER['PHP_SELF'])=='index_appointments.php' ? 'active' : '' ?>">Appointments</a>
    <a href="index_client.php" class="<?= basename($_SERVER['PHP_SELF'])=='index_client.php' ? 'active' : '' ?>">Clients</a>
    <a href="index_service_provider.php" class="<?= basename($_SERVER['PHP_SELF'])=='index_service_provider.php' ? 'active' : '' ?>">Service Providers</a>
    <a href="index_services.php" class="<?= basename($_SERVER['PHP_SELF'])=='index_services.php' ? 'active' : '' ?>">Services</a>
</div>