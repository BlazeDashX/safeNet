<?php
session_start();
require_once '../../models/db.php';

// Security Check
if (!isset($_SESSION['status']) || ($_SESSION['type'] != 'admin' && $_SESSION['type'] != 'consultant')) {
    header("Location: ../login.php"); exit;
}

$con = getConnection();
$sql = "SELECT reports.*, users.username FROM reports 
        JOIN users ON reports.user_id = users.id 
        ORDER BY reports.id DESC";
$result = $con->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Reports - SAFENET</title>
    <link rel="stylesheet" href="../../assets/css/admin_dashboard.css">
    <link rel="stylesheet" href="../../assets/css/manage_reports.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-body">

    <nav class="sidebar">
        <div class="sidebar-header">
            <h3>SAFENET</h3>
            <span class="role-badge"><?php echo strtoupper($_SESSION['type']); ?></span>
        </div>
        <ul class="nav-links">
            <li><a href="adminDashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li class="active"><a href="manage_reports.php"><i class="fa-solid fa-file-shield"></i> Incident Reports</a></li>
            <?php if($_SESSION['type'] == 'admin'): ?>
                <li><a href="manage_users.php"><i class="fa-solid fa-users"></i> User Management</a></li>
            <?php endif; ?>
            <li><a href="../profile.php"><i class="fa-solid fa-user-gear"></i> My Profile</a></li>
            <li class="logout-link"><a href="../../controllers/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </nav>

    <main class="main-content">
        <header class="content-header">
            <h2>Manage Incident Reports</h2>
            <div class="user-pill">
                <i class="fa-solid fa-circle-user"></i>
                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </div>
        </header>

        <div class="report-grid">
            <?php if($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <div class="report-card">
                    <div class="card-image">
                        <?php if(!empty($row['image'])): ?>
                            <img src="../../assets/uploads/<?php echo $row['image']; ?>" onclick="window.open(this.src)">
                        <?php else: ?>
                            <div class="no-image-placeholder">No Evidence Uploaded</div>
                        <?php endif; ?>
                        <span class="category-tag"><?php echo isset($row['category']) ? htmlspecialchars($row['category']) : 'Cyberbullying'; ?></span>
                    </div>
                    
                    <div class="card-content">
                        <div class="card-meta">
                            <span class="report-id">#<?php echo $row['id']; ?></span>
                            <span class="status-badge status-<?php echo $row['status']; ?>"><?php echo $row['status']; ?></span>
                        </div>
                        <h3>Reporter: <?php echo htmlspecialchars($row['username']); ?></h3>
                        <p class="description"><?php echo htmlspecialchars($row['description']); ?></p>
                        
                        <div class="card-actions">
                            <?php if($row['status'] == 'Pending'): ?>
                                <button class="btn-resolve" onclick="updateStatus(<?php echo $row['id']; ?>, 'Resolved')">
                                    <i class="fa-solid fa-check"></i> Mark as Resolved
                                </button>
                            <?php else: ?>
                                <div class="resolved-text"><i class="fa-solid fa-circle-check"></i> Resolved</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">No incident reports found.</div>
            <?php endif; ?>
        </div>
    </main>

    <script>
    function updateStatus(id, status) {
        if(confirm("Confirm resolution of Report #" + id + "?")) {
            fetch('../../controllers/updateReportStatus.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${id}&status=${status}`
            })
            .then(res => res.json())
            .then(data => { if(data.success) location.reload(); else alert("Error updating status"); });
        }
    }
    </script>
</body>
</html>