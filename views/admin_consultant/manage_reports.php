<?php
session_start();
require_once '../../models/db.php';

// Access control
if (!isset($_SESSION['status']) || 
   ($_SESSION['type'] != 'admin' && $_SESSION['type'] != 'consultant')) {
    header("Location: ../login.php");
    exit;
}

// Database connection
$con = getConnection();

// Report list
$sql = "SELECT reports.*, users.username 
        FROM reports 
        JOIN users ON reports.user_id = users.id 
        ORDER BY reports.status ASC, reports.id DESC";

$result = $con->query($sql);

// Dashboard routing
$dashboardLink = ($_SESSION['type'] == 'consultant') 
    ? 'consultantDashboard.php' 
    : 'adminDashboard.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Reports - SAFENET</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="../../assets/css/manage_r.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="admin-body">

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <h3>SAFENET</h3>
            <span class="role-badge" 
                  style="<?php echo ($_SESSION['type'] == 'consultant') ? 'background-color:#2ecc71;' : ''; ?>">
                <?php echo strtoupper($_SESSION['type']); ?>
            </span>
        </div>

        <ul class="nav-links">
            <li>
                <a href="<?php echo $dashboardLink; ?>">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>
            </li>

            <li class="active">
                <a href="manage_reports.php">
                    <i class="fa-solid fa-file-shield"></i> Incident Reports
                </a>
            </li>

            <!-- Admin only -->
            <?php if($_SESSION['type'] == 'admin'): ?>
                <li>
                    <a href="manage_users.php">
                        <i class="fa-solid fa-users"></i> User Management
                    </a>
                </li>
            <?php endif; ?>

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
            <h2>Manage Incident Reports</h2>
            <div class="user-pill">
                <i class="fa-solid fa-circle-user"></i>
                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </div>
        </header>

        <!-- Reports grid -->
        <div class="report-grid">

            <?php if($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>

                <div class="report-card">

                    <!-- Evidence -->
                    <div class="card-image">
                        <?php if(!empty($row['evidence'])): ?>
                            <img src="../../<?php echo $row['evidence']; ?>" 
                                 onclick="window.open(this.src)" 
                                 alt="Evidence" 
                                 class="evidence-img">
                        <?php else: ?>
                            <div class="no-image-placeholder">
                                No Evidence Uploaded
                            </div>
                        <?php endif; ?>

                        <span class="category-tag">
                            <?php echo isset($row['type']) 
                                ? htmlspecialchars($row['type']) 
                                : 'Cyberbullying'; ?>
                        </span>
                    </div>

                    <!-- Content -->
                    <div class="card-content">

                        <div class="card-meta">
                            <span class="report-id">#<?php echo $row['id']; ?></span>
                            <span class="status-badge status-<?php echo strtolower($row['status']); ?>">
                                <?php echo $row['status']; ?>
                            </span>
                        </div>

                        <h3>
                            Reporter: <?php echo htmlspecialchars($row['username']); ?>
                        </h3>

                        <!-- Description -->
                        <div class="description-container">
                            <?php 
                                $fullDesc = htmlspecialchars($row['description']);
                                echo (strlen($fullDesc) > 60) 
                                    ? substr($fullDesc, 0, 60) . '...' 
                                    : $fullDesc; 
                            ?>

                            <?php if(strlen($fullDesc) > 60): ?>
                                <br>
                                <a href="javascript:void(0)"
                                   onclick="document.getElementById('modal_<?php echo $row['id']; ?>').showModal()"
                                   class="read-more-link">
                                    Read More
                                </a>
                            <?php endif; ?>
                        </div>

                        <!-- Modal -->
                        <dialog id="modal_<?php echo $row['id']; ?>" class="modal">
                            <h3>Incident Report #<?php echo $row['id']; ?></h3>
                            <div class="modal-body">
                                <?php echo $fullDesc; ?>
                            </div>
                            <button onclick="this.closest('dialog').close()" 
                                    class="modal-btn-close">
                                Close
                            </button>
                        </dialog>

                        <!-- Actions -->
                        <div class="card-actions">
                            <?php if($row['status'] == 'Pending'): ?>
                                <button class="btn-resolve"
                                        onclick="updateStatus(<?php echo $row['id']; ?>, 'Resolved')">
                                    <i class="fa-solid fa-check"></i> Mark as Resolved
                                </button>
                            <?php else: ?>
                                <div class="resolved-text">
                                    <i class="fa-solid fa-circle-check"></i> Resolved
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    No incident reports found.
                </div>
            <?php endif; ?>

        </div>
    </main>

    <!-- Status update -->
    <script>
    function updateStatus(id, status) {
        if (confirm("Confirm resolution of Report #" + id + "?")) {
            fetch('../../controllers/updateReportStatus.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${id}&status=${status}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert("Update failed");
                }
            });
        }
    }
    </script>

</body>
</html>
