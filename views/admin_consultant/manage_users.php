<?php
session_start();
require_once '../../models/db.php';

// Access control: admin only
if (!isset($_SESSION['status']) || $_SESSION['type'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$con = getConnection();

// Fetch non-admin users
$sql = "SELECT id, username, email, type FROM users WHERE type != 'admin' ORDER BY id DESC";
$result = $con->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users - SAFENET</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/admin_dashboard.css">
    <link rel="stylesheet" href="../../assets/css/manage_users.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-body">

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <h3>SAFENET</h3>
            <span class="role-badge">ADMIN</span>
        </div>
        <ul class="nav-links">
            <li><a href="adminDashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li><a href="manage_reports.php"><i class="fa-solid fa-file-shield"></i> Incident Reports</a></li>
            <li class="active"><a href="manage_users.php"><i class="fa-solid fa-users"></i> User Management</a></li>
            <li><a href="../profile.php"><i class="fa-solid fa-user-gear"></i> My Profile</a></li>
            <li><a href="../change_password.php"><i class="fa-solid fa-key"></i> Change Password</a></li>
            <li class="logout-link"><a href="../../controllers/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <header class="content-header">
            <h2>User Management</h2>
            <div class="user-pill">
                <i class="fa-solid fa-user-shield"></i>
                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </div>
        </header>

        <div class="table-card">
            <table class="user-table">
                <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th width="25%">Username</th>
                        <th width="35%">Email</th>
                        <th width="15%">Role</th>
                        <th width="15%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0): ?>
                        <?php while($user = $result->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $user['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($user['username']); ?></strong></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><span class="role-tag role-<?php echo $user['type']; ?>"><?php echo strtoupper($user['type']); ?></span></td>
                            <td class="text-center">
                                <button class="btn-delete" data-id="<?php echo $user['id']; ?>" data-name="<?php echo $user['username']; ?>">
                                    <i class="fa-solid fa-trash"></i> Remove
                                </button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="empty-row">No active users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- JS -->
    <script src="../../assets/js/manage_users.js"></script>
</body>
</html>
