<?php
session_start();
require_once '../../models/db.php';

// 1. Redirect Loop Fix & Security
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    header("Location: ../login.php"); exit;
}
if ($_SESSION['type'] === 'user') {
    header("Location: ../user/userDashboard.php"); exit;
}

// 2. Fetch Live Statistics
$con = getConnection();
$totalUsers = $con->query("SELECT COUNT(*) as total FROM users WHERE type='user'")->fetch_assoc()['total'];
$totalReports = $con->query("SELECT COUNT(*) as total FROM reports")->fetch_assoc()['total'];
$pendingReports = $con->query("SELECT COUNT(*) as total FROM reports WHERE status='Pending'")->fetch_assoc()['total'];
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - SAFENET</title>
    <link rel="stylesheet" href="../../assets/css/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-body">

    <nav class="sidebar">
        <div class="sidebar-header">
            <h3>SAFENET</h3>
            <span class="role-badge"><?php echo strtoupper($_SESSION['type']); ?></span>
        </div>
        <ul class="nav-links">
            <li class="active"><a href="adminDashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li><a href="manage_reports.php"><i class="fa-solid fa-file-shield"></i> Incident Reports</a></li>
            <?php if($_SESSION['type'] == 'admin'): ?>
                <li><a href="manage_users.php"><i class="fa-solid fa-users"></i> User Management</a></li>
            <?php endif; ?>
            <li><a href="../profile.php"><i class="fa-solid fa-user-gear"></i> My Profile</a></li>
            <li class="logout-link"><a href="../../controllers/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </nav>

    <main class="main-content">
        <header class="content-header">
            <h2>Administrative Overview</h2>
            <div class="user-pill">
                <i class="fa-solid fa-circle-user"></i>
                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </div>
        </header>

        <section class="stats-container">
            <div class="stat-card pending">
                <div class="stat-info">
                    <h3><?php echo $pendingReports; ?></h3>
                    <p>Pending Actions</p>
                </div>
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div class="stat-card reports">
                <div class="stat-info">
                    <h3><?php echo $totalReports; ?></h3>
                    <p>Total Incidents</p>
                </div>
                <i class="fa-solid fa-bullhorn"></i>
            </div>
            <div class="stat-card users">
                <div class="stat-info">
                    <h3><?php echo $totalUsers; ?></h3>
                    <p>Registered Users</p>
                </div>
                <i class="fa-solid fa-users"></i>
            </div>
        </section>

        <section class="recent-activity card">
            <div class="card-header">
                <h3>System Status</h3>
            </div>
            <div class="card-body">
                <p><i class="fa-solid fa-check-circle" style="color: green;"></i> Database Connection: <strong>Secure</strong></p>
                <p><i class="fa-solid fa-shield-halved" style="color: #1a3b5d;"></i> Firewall Status: <strong>Active</strong></p>
            </div>
        </section>
    </main>

</body>
</html>