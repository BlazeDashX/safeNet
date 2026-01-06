<?php
session_start();
require_once '../../models/reportModel.php';

// Session check
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    header("Location: login.php");
    exit;
}

// User reports
$reports = getReportsByUserId($_SESSION['user_id']);

// Dashboard link
$backLink = ($_SESSION['type'] == 'admin')
    ? "admin_consultant/adminDashboard.php"
    : "userDashboard.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SAFENET - Track Reports</title>

  <!-- Styles -->
  <link rel="stylesheet" href="../../assets/css/track_reports.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="icon" href="https://img.icons8.com/fluency/48/shield.png">
</head>

<body>

  <!-- Top bar -->
  <header class="topbar">
    <div class="logo">SAFENET</div>
    <div class="user-info">
      <a href="<?php echo $backLink; ?>" style="color: white; text-decoration: underline;">
        &larr; Back to Dashboard
      </a>
    </div>
  </header>

  <!-- Content -->
  <div class="container">
    <h2>My Report History</h2>

    <?php if (count($reports) > 0): ?>

        <!-- Report table -->
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Evidence</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($reports as $row): ?>
                        <tr>

                            <td>
                                <?php echo date("M d, Y", strtotime($row['created_at'])); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['type']); ?>
                            </td>

                            <td>
                                <?php 
                                    $desc = htmlspecialchars($row['description']);
                                    echo (strlen($desc) > 50)
                                        ? substr($desc, 0, 50) . '...'
                                        : $desc;
                                ?>
                            </td>

                            <td>
                                <?php if (!empty($row['evidence'])): ?>
                                    <a href="../<?php echo $row['evidence']; ?>" 
                                       target="_blank" 
                                       class="view-btn">
                                        <i class="fa-solid fa-image"></i> View
                                    </a>
                                <?php else: ?>
                                    <span style="color:#999;">None</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <span class="status-badge <?php echo strtolower($row['status']); ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php else: ?>

        <!-- Empty state -->
        <div class="empty-state">
            <p>You haven't submitted any reports yet.</p>
            <a href="report.php">
                <button>Submit a Report</button>
            </a>
        </div>

    <?php endif; ?>
  </div>

  <!-- Footer -->
  <footer class="bottombar">
    © 2025 SAFENET | All Rights Reserved
  </footer>

</body>
</html>
