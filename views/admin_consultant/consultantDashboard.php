<?php
session_start();
require_once '../../models/db.php';

// Session validation
if (!isset($_SESSION['status']) || $_SESSION['type'] != 'consultant') {
    header("Location: ../login.php");
    exit;
}

// Database connection
$con = getConnection();

// Report statistics
$pendingQuery  = "SELECT COUNT(*) AS count FROM reports WHERE status = 'Pending'";
$resolvedQuery = "SELECT COUNT(*) AS count FROM reports WHERE status = 'Resolved'";

$pendingRes  = $con->query($pendingQuery)->fetch_assoc();
$resolvedRes = $con->query($resolvedQuery)->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Consultant Dashboard - SAFENET</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="../../assets/css/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="admin-body">

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <h3>SAFENET</h3>
            <span class="role-badge" style="background-color: #2ecc71;">
                CONSULTANT
            </span>
        </div>

        <ul class="nav-links">
            <li class="active">
                <a href="consultantDashboard.php">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="manage_reports.php">
                    <i class="fa-solid fa-file-shield"></i> Incident Reports
                </a>
            </li>

            <li>
                <a href="../profile.php">
                    <i class="fa-solid fa-user-gear"></i> My Profile
                </a>
            </li>

            <li>
                <a href="../change_password.php">
                    <i class="fa-solid fa-key"></i> Change Password
                </a>
            </li>

            <li class="logout-link">
                <a href="../../controllers/logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main content -->
    <main class="main-content">

        <!-- Header -->
        <header class="content-header">
            <h2>Overview</h2>
            <div class="user-pill">
                <i class="fa-solid fa-user-nurse"></i>
                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </div>
        </header>

        <!-- Statistics -->
        <div class="stats-grid">

            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
                <div class="stat-info">
                    <h3>Pending Cases</h3>
                    <p class="stat-number">
                        <?php echo $pendingRes['count']; ?>
                    </p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fa-solid fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>Resolved Cases</h3>
                    <p class="stat-number">
                        <?php echo $resolvedRes['count']; ?>
                    </p>
                </div>
            </div>

        </div>

        <!-- Welcome message -->
        <div class="welcome-banner" style="margin-top: 30px; background: white; padding: 30px; border-radius: 12px; border: 1px solid #e1e8ed;">
            <h3 style="color: #2c3e50;">Welcome back, Consultant.</h3>
            <p style="color: #7f8c8d; margin-top: 10px;">
                Your expertise helps keep our community safe. Please review the 
                <strong>Pending Cases</strong> to assist users.
            </p>
        </div>

    </main>

</body>
</html>
