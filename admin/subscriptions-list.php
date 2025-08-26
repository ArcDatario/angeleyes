<?php
// File: admin/subscriptions-list.php
require_once '../db.php';
require_once('auth_check.php');
require_login();
// Use Asia/Manila timezone for all date calculations and provide helpers for formatting
date_default_timezone_set('Asia/Manila');
$now = new DateTime('now');

/**
 * Format a datetime string into Manila timezone and return like "Aug 21, 2025 1:05 am".
 */
function format_manila($dtStr)
{
  $dtStr = trim((string)$dtStr);
  if ($dtStr === '' || $dtStr === '0000-00-00' || $dtStr === '0000-00-00 00:00:00') return '';
  try {
    $dt = new DateTime($dtStr);
    $dt->setTimezone(new DateTimeZone('Asia/Manila'));
    return $dt->format('M j, Y g:i a');
  } catch (Exception $e) {
    return $dtStr;
  }
}

/**
 * Format only the date portion in Manila timezone: "Aug 21, 2025"
 */
function format_manila_date($dtStr)
{
  $dtStr = trim((string)$dtStr);
  if ($dtStr === '' || $dtStr === '0000-00-00' || $dtStr === '0000-00-00 00:00:00') return '';
  try {
    $dt = new DateTime($dtStr);
    $dt->setTimezone(new DateTimeZone('Asia/Manila'));
    return $dt->format('M j, Y');
  } catch (Exception $e) {
    return $dtStr;
  }
}

$tab = $_GET['tab'] ?? 'all';

// Build query based on tab
switch ($tab) {
  case 'near':
    // due_date between now and now + 7 days
    $end = (clone $now)->modify('+7 days')->format('Y-m-d H:i:s');
    $start = $now->format('Y-m-d H:i:s');
    $sql = "SELECT s.*, u.full_name, u.user_id AS subscriber_user_id, u.id AS subscriber_id, p.plan_name, p.price FROM subscriptions s JOIN subscribers u ON s.user_id = u.id LEFT JOIN plans p ON s.plan_id = p.id WHERE s.due_date >= '$start' AND s.due_date <= '$end' ORDER BY s.due_date ASC";
        $title = 'Near Due Date (next 7 days)';
        break;
    case 'penalty':
        // due_date < now AND due_date > now - 3 days (overdue but less than 3 days)
  $threeDaysAgo = (clone $now)->modify('-3 days')->format('Y-m-d H:i:s');
  $nowStr = $now->format('Y-m-d H:i:s');
  $sql = "SELECT s.*, u.full_name, u.user_id AS subscriber_user_id, u.id AS subscriber_id, p.plan_name, p.price FROM subscriptions s JOIN subscribers u ON s.user_id = u.id LEFT JOIN plans p ON s.plan_id = p.id WHERE s.due_date < '$nowStr' AND s.due_date > '$threeDaysAgo' ORDER BY s.due_date ASC";
        $title = 'Penalty (overdue &lt; 3 days)';
        break;
    case 'deactivated':
        // due_date <= now - 3 days (deactivated)
  $threeDaysAgo = (clone $now)->modify('-3 days')->format('Y-m-d H:i:s');
  $sql = "SELECT s.*, u.full_name, u.user_id AS subscriber_user_id, u.id AS subscriber_id, p.plan_name, p.price FROM subscriptions s JOIN subscribers u ON s.user_id = u.id LEFT JOIN plans p ON s.plan_id = p.id WHERE s.due_date <= '$threeDaysAgo' ORDER BY s.due_date ASC";
        $title = 'Deactivated (overdue ≥ 3 days)';
        break;
    case 'all':
    default:
  $sql = "SELECT s.*, u.full_name, u.user_id AS subscriber_user_id, u.id AS subscriber_id, p.plan_name, p.price FROM subscriptions s JOIN subscribers u ON s.user_id = u.id LEFT JOIN plans p ON s.plan_id = p.id ORDER BY s.started_date DESC";
        $title = 'All Subscriptions';
        $tab = 'all';
        break;
}

$result = $conn->query($sql);

?>
<!doctype html>
<html lang="en">
<head>
  <?php include "includes/default-src.php";?>
  <style>
    .profile-img { width:40px; height:40px; object-fit:cover; }
  </style>
</head>
<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <?php include "includes/navbar.php";?>
    <div class="body-wrapper">
      <?php include "includes/header.php";?>
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <h5 class="card-title mb-0">Subscriptions List</h5>
                  <div>
                    <a href="subscriptions-list.php?tab=all" class="btn btn-sm btn-outline-primary <?= $tab === 'all' ? 'active' : '' ?>">All</a>
                    <a href="subscriptions-list.php?tab=near" class="btn btn-sm btn-outline-warning <?= $tab === 'near' ? 'active' : '' ?>">Near Due Date</a>
                    <a href="subscriptions-list.php?tab=penalty" class="btn btn-sm btn-outline-danger <?= $tab === 'penalty' ? 'active' : '' ?>">Penalty</a>
                    <a href="subscriptions-list.php?tab=deactivated" class="btn btn-sm btn-outline-secondary <?= $tab === 'deactivated' ? 'active' : '' ?>">Deactivated</a>
                  </div>
                </div>

                <p class="text-muted mb-3"><?= htmlspecialchars($title) ?> — Current time: <?= htmlspecialchars($now->format('M j, Y g:i a')) ?> (Asia/Manila)</p>

                <div class="table-responsive">
                  <table class="table table-hover align-middle">
                    <thead>
                      <thead>
                        <tr>
                         
                          <th>Reference</th>
                          
                          <th>User Name</th>
                          <th>Plan</th>
                          <th>Price</th>
                          <th>Started Date</th>
                          <th>Due Date</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                          <tr>
                            <td><?= htmlspecialchars($row['reference'] ?? '') ?></td>
                            
                            <td><?= htmlspecialchars($row['full_name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['plan_name'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars(isset($row['price']) ? number_format((float)$row['price'],2) : '0.00') ?></td>
                            <td><?= htmlspecialchars(format_manila_date($row['started_date'])) ?></td>
                            <td><?= htmlspecialchars(format_manila_date($row['due_date'])) ?></td>
                            <td><span class="badge bg-<?= $row['status'] === 'Active' ? 'success' : 'secondary' ?>"><?= htmlspecialchars($row['status']) ?></span></td>
                            <td>
                              <button class="btn btn-sm btn-outline-primary view-sub"
                                data-sub-id="<?= $row['id'] ?>"
                                data-subscriber-id="<?= $row['subscriber_id'] ?>"
                                data-user-id="<?= htmlspecialchars($row['subscriber_user_id']) ?>"
                                data-user-name="<?= htmlspecialchars($row['full_name'] ?? '') ?>"
                                data-plan="<?= htmlspecialchars($row['plan_name'] ?? '') ?>"
                                data-price="<?= htmlspecialchars(isset($row['price']) ? number_format((float)$row['price'],2) : '0.00') ?>"
                                data-started="<?= htmlspecialchars(format_manila_date($row['started_date'])) ?>"
                                data-due="<?= htmlspecialchars(format_manila_date($row['due_date'])) ?>"
                                data-status="<?= htmlspecialchars($row['status']) ?>"
                                data-reference="<?= htmlspecialchars($row['reference'] ?? '') ?>"
                                data-address="<?= htmlspecialchars($row['address'] ?? '') ?>"
                              >View</button>
                            </td>
                          </tr>
                        <?php endwhile; ?>
                      <?php else: ?>
                        <tr><td colspan="8" class="text-center">No subscriptions found</td></tr>
                      <?php endif; ?>
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

  <!-- Minimal View Modal -->
  <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Subscription Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-6"><strong>User ID:</strong> <div id="modalUserId"></div></div>
            <div class="col-6"><strong>User Name:</strong> <div id="modalUserName"></div></div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><strong>Plan:</strong> <div id="modalPlan"></div></div>
            <div class="col-6"><strong>Price:</strong> ₱<div id="modalPrice"></div></div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><strong>Started:</strong> <div id="modalStarted"></div></div>
            <div class="col-6"><strong>Due:</strong> <div id="modalDue"></div></div>
          </div>
          <div class="row mt-2">
            <div class="col-12"><strong>Status:</strong> <div id="modalStatus"></div></div>
          </div>
          <hr />
          <!-- Reference is intentionally removed from modal as per requirements -->
          <div class="row mt-2">
            <div class="col-12"><strong>Address:</strong> <div id="modalAddress"></div></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-sm btn-primary" id="goToUserBtn">Go to users</button>
        </div>
      </div>
    </div>
  </div>

  <?php include "includes/default-scripts.php";?>
  <script>
    (function(){
      const viewModalEl = document.getElementById('viewModal');
      const viewModal = new bootstrap.Modal(viewModalEl, {focus:false});
      let currentSubscriberId = null;

      document.querySelectorAll('.view-sub').forEach(btn => {
        btn.addEventListener('click', function(){
          currentSubscriberId = this.getAttribute('data-subscriber-id') || '';
          document.getElementById('modalUserId').textContent = this.getAttribute('data-user-id') || '';
          document.getElementById('modalUserName').textContent = this.getAttribute('data-user-name') || '';
          document.getElementById('modalPlan').textContent = this.getAttribute('data-plan') || '';
          document.getElementById('modalPrice').textContent = this.getAttribute('data-price') || '';
          document.getElementById('modalStarted').textContent = this.getAttribute('data-started') || '';
          document.getElementById('modalDue').textContent = this.getAttribute('data-due') || '';
          document.getElementById('modalStatus').textContent = this.getAttribute('data-status') || '';
          // Reference is intentionally not populated in the modal anymore
          document.getElementById('modalAddress').textContent = this.getAttribute('data-address') || '';
          viewModal.show();
        });
      });

      document.getElementById('goToUserBtn').addEventListener('click', function(){
        if (currentSubscriberId) {
          window.location.href = 'subscriptions.php?id=' + encodeURIComponent(currentSubscriberId);
        }
      });
    })();
  </script>
</body>
</html>
