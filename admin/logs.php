<?php
// File: logs.php
require_once '../db.php';
require_once '../admin/auth_check.php';
?>
<!doctype html>
<html lang="en">
<head>
  <?php include "includes/default-src.php";?>
  <style>
    .card-body {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
      border-radius: 8px;
      padding: 16px;
    }
    .log-table {
      font-size: 0.9rem;
    }
    .log-table th {
      background-color: #f8f9fa;
    }
  </style>
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!-- Sidebar Start -->
    <?php include "includes/navbar.php";?>
    <!--  Sidebar End -->

    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <?php include "includes/header.php";?>
      <!--  Header End -->

      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <h5 class="card-title mb-0">System Logs</h5>
                </div>

                <div class="table-responsive">
                  <table class="table table-hover align-middle log-table" id="logsTable">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Admin</th>
                        <th>Date & Time</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      // Query to get logs with admin username
                      $query = "SELECT l.*, a.username 
                               FROM logs l 
                               LEFT JOIN admin a ON l.admin_id = a.id 
                               ORDER BY l.created_at DESC";
                      $result = $conn->query($query);
                      
                      if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                              // Format the date as requested: "Aug 22, 2025 - 2:00 pm"
                              $formattedDate = date("M j, Y - g:i a", strtotime($row['created_at']));
                              
                              echo "<tr>";
                             
                              echo "<td>{$row['username']}</td>";
                              echo "<td>{$row['content']}</td>";
                              echo "<td>{$formattedDate}</td>";
                              echo "</tr>";
                          }
                      } else {
                          echo "<tr><td colspan='4' class='text-center'>No logs found</td></tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include "includes/default-scripts.php";?>
</body>
</html>