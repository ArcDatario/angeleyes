<?php
// File: admins.php
require_once '../db.php';
require_once '../admin/auth_check.php';
require_login();
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
    .profile-img {
      width: 40px;
      height: 40px;
      object-fit: cover;
    }
    .toast {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 1100;
      font-size: 0.85rem;
      padding: 0.5rem 1rem;
      background-color: #f8f9fa;
      border: 1px solid #dee2e6;
      box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
    }
  </style>
</head>

<body>
  <div class="toast-container"></div>

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
                  <h5 class="card-title mb-0">Administrators</h5>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adminModal">Add Admin</button>
                </div>

                <div class="table-responsive">
                  <table class="table table-hover align-middle" id="adminsTable">
                    <thead>
                      <tr>
                        <th>Profile</th>
                        <th>Username</th>
                        <th>Last Login</th>
                        <th>Created At</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      // Query to get all admins
                      $query = "SELECT * FROM admin WHERE id != " . $_SESSION['admin_id'] . " ORDER BY created_at DESC";
                      $result = $conn->query($query);
                      
                      if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                              $profileImg = !empty($row['profile']) ? '../admin/uploads/'.$row['profile'] : '../user.png';
                              $lastLogin = $row['last_login'] ? date("M j, Y - g:i a", strtotime($row['last_login'])) : 'Never';
                              $createdAt = date("M j, Y - g:i a", strtotime($row['created_at']));
                              
                              echo "<tr>";
                              echo "<td><img src='{$profileImg}' alt='Profile' class='rounded-circle profile-img'></td>";
                              echo "<td>{$row['username']}</td>";
                              echo "<td>{$lastLogin}</td>";
                              echo "<td>{$createdAt}</td>";
                              echo "<td>
                                      <div class='btn-group' role='group' aria-label='actions'>
                                        <button class='btn btn-outline-primary btn-sm edit-admin' data-id='{$row['id']}'>Edit</button>
                                        " . ($row['id'] != $_SESSION['admin_id'] ? "<button class='btn btn-outline-danger btn-sm delete-admin' data-id='{$row['id']}'>Delete</button>" : "") . "
                                      </div>
                                    </td>";
                              echo "</tr>";
                          }
                      } else {
                          echo "<tr><td colspan='5' class='text-center'>No administrators found</td></tr>";
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

  <!-- Admin Modal -->
  <div class="modal fade" id="adminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fs-6">Admin Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="adminForm" enctype="multipart/form-data">
            <input type="hidden" id="adminId" name="id" value="0">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control form-control-sm" id="username" name="username" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control form-control-sm" id="password" name="password">
              <div class="form-text">Leave blank to keep current password</div>
            </div>
            <div class="mb-3">
              <label for="profile" class="form-label">Profile Image</label>
              <input type="file" class="form-control form-control-sm" id="profile" name="profile" accept="image/*">
              <div class="form-text" id="currentProfileText" style="display: none;">Current profile image: <span id="currentProfileName"></span></div>
            </div>
            <div class="mb-3" id="profilePreviewContainer" style="display: none;">
              <img id="profilePreview" src="#" alt="Profile Preview" class="rounded-circle profile-img mt-2">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-sm btn-danger" id="deleteAdminBtn" style="display:none;">Delete</button>
          <button type="button" class="btn btn-sm btn-primary" id="saveAdminBtn">Save</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fs-6">Confirm Delete</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this administrator? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-sm btn-danger" id="confirmDeleteBtn">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <?php include "includes/default-scripts.php";?>
  <script>
$(document).ready(function() {
    // Initialize modals
    const adminModal = new bootstrap.Modal(document.getElementById('adminModal'), {
        focus: false
    });
    const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'), {
        focus: false
    });

    // Profile image preview
    $('#profile').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profilePreview').attr('src', e.target.result);
                $('#profilePreviewContainer').show();
            }
            reader.readAsDataURL(file);
        }
    });

    // Add new admin
    $(document).on('click', '#saveAdminBtn', function() {
        const $btn = $(this);
        $btn.prop('disabled', true);
        
        const formData = new FormData($('#adminForm')[0]);
        formData.append('action', 'save_admin');
        
        $.ajax({
            url: 'ajax/crud_admin.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showToast('Admin saved successfully', 'success');
                    adminModal.hide();
                    location.reload(); // Reload to see changes
                } else {
                    showToast(response.message, 'error');
                }
            },
            error: function() {
                showToast('An error occurred', 'error');
            },
            complete: function() {
                $btn.prop('disabled', false);
            }
        });
    });

    // Edit admin
    $(document).on('click', '.edit-admin', function() {
        const adminId = $(this).data('id');
        
        $.post('ajax/crud_admin.php', {action: 'get_admin', id: adminId}, function(response) {
            if (response.success) {
                const admin = response.admin;
                $('#adminId').val(admin.id);
                $('#username').val(admin.username);
                $('#password').val('');
                
                // Show current profile info if exists
                if (admin.profile && admin.profile !== 'default.png') {
                    $('#currentProfileText').show();
                    $('#currentProfileName').text(admin.profile);
                } else {
                    $('#currentProfileText').hide();
                }
                
                $('#deleteAdminBtn').show();
                adminModal.show();
            } else {
                showToast(response.message, 'error');
            }
        }, 'json');
    });

    // Delete admin
    $(document).on('click', '.delete-admin', function() {
        const adminId = $(this).data('id');
        $('#adminId').val(adminId);
        confirmDeleteModal.show();
    });

    $('#deleteAdminBtn').click(function() {
        confirmDeleteModal.show();
    });
    
    $('#confirmDeleteBtn').click(function() {
        const $btn = $(this);
        $btn.prop('disabled', true);
        
        const adminId = $('#adminId').val();
        
        $.post('ajax/crud_admin.php', {action: 'delete_admin', id: adminId})
            .done(function(response) {
                if (response.success) {
                    showToast('Admin deleted successfully', 'success');
                    adminModal.hide();
                    confirmDeleteModal.hide();
                    location.reload(); // Reload to see changes
                } else {
                    showToast(response.message, 'error');
                }
            })
            .fail(function() {
                showToast('An error occurred', 'error');
            })
            .always(function() {
                $btn.prop('disabled', false);
            });
    });

    // Reset form when modal is closed
    $('#adminModal').on('hidden.bs.modal', function() {
        $('#adminForm')[0].reset();
        $('#adminId').val('0');
        $('#currentProfileText').hide();
        $('#profilePreviewContainer').hide();
        $('#deleteAdminBtn').hide();
    });

    // Function to show toast messages
    function showToast(message, type) {
        const $toast = $('<div class="toast"></div>');
        $toast.addClass(type === 'error' ? 'bg-danger text-white' : 'bg-success text-white');
        $toast.text(message);
        $('.toast-container').html($toast);
        
        $toast.addClass('show');
        setTimeout(() => $toast.remove(), 3000);
    }
});
</script>
</body>
</html>