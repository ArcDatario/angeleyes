
<?php
// File: profile.php
require_once '../db.php';
require_once '../admin/auth_check.php';

// Get current admin data
$admin_id = $_SESSION['admin_id'];
$query = "SELECT * FROM admin WHERE id = $admin_id";
$result = $conn->query($query);
$admin = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'] ?? '';
    
    if (empty($username)) {
        $error = "Username is required";
    } else {
        // Check if username already exists (excluding current admin)
        $check = $conn->prepare("SELECT id FROM admin WHERE username = ? AND id != ?");
        $check->bind_param("si", $username, $admin_id);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $error = 'Username already exists';
        } else {
            // Handle file upload
            $profile_filename = $admin['profile'];
            $upload_dir = '../admin/uploads/';
            
            if (!empty($_FILES['profile']['name'])) {
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $file_extension = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
                $profile_filename = 'admin_' . time() . '.' . $file_extension;
                
                if (move_uploaded_file($_FILES['profile']['tmp_name'], $upload_dir . $profile_filename)) {
                    // Delete old profile image if it exists and is not default
                    if (!empty($admin['profile']) && $admin['profile'] !== 'default.png' && file_exists($upload_dir . $admin['profile'])) {
                        unlink($upload_dir . $admin['profile']);
                    }
                } else {
                    $error = 'Failed to upload profile image';
                }
            }
            
            if (empty($error)) {
                if (!empty($password)) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE admin SET username=?, password=?, profile=? WHERE id=?");
                    $stmt->bind_param("sssi", $username, $hashed_password, $profile_filename, $admin_id);
                } else {
                    $stmt = $conn->prepare("UPDATE admin SET username=?, profile=? WHERE id=?");
                    $stmt->bind_param("ssi", $username, $profile_filename, $admin_id);
                }
                
                if ($stmt->execute()) {
                    // Update session with new profile image path
                    $_SESSION['admin_profile'] = !empty($profile_filename) ? 
                        '../admin/uploads/'.$profile_filename : '../../user.png';
                    
                    $success = "Profile updated successfully";
                    // Refresh admin data
                    $result = $conn->query($query);
                    $admin = $result->fetch_assoc();
                } else {
                    $error = "Failed to update profile";
                }
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <?php include "includes/default-src.php";?>
  <style>
    .profile-content {
      padding: 2rem;
      background: #f8f9fa;
      min-height: calc(100vh - 180px);
    }
    .profile-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 2rem;
      margin: -2rem -2rem 2rem -2rem;
    }
    .profile-img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border: 3px solid #dee2e6;
    }
    .form-section {
      background: white;
      padding: 1.5rem;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      margin-bottom: 1.5rem;
    }
    .info-section {
      background: white;
      padding: 1.5rem;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      margin-bottom: 1.5rem;
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
        <div class="profile-content">
          <div class="profile-header">
            <h4 class="mb-0">Admin Profile</h4>
            <p class="mb-0">Manage your account settings</p>
          </div>
          
          <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
          <?php endif; ?>
          <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
          <?php endif; ?>
          
          <form method="POST" enctype="multipart/form-data">
            <div class="form-section">
              <div class="text-center mb-4">
                <?php
                $profileImg = !empty($admin['profile']) ? '../admin/uploads/'.$admin['profile'] : '../user.png';
                ?>
                <img src="<?php echo $profileImg; ?>" alt="Profile" class="rounded-circle profile-img mb-3" id="profilePreview">
                <div class="mb-3">
                  <label for="profile" class="form-label">Change Profile Image</label>
                  <input type="file" class="form-control form-control-sm" id="profile" name="profile" accept="image/*">
                </div>
              </div>
              
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>" required>
              </div>
              
              <div class="mb-3">
    <label for="password" class="form-label">New Password</label>
    <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" value="">
    <div class="form-text">Leave blank to keep current password</div>
</div>
            </div>
            
            <div class="info-section">
              <h5 class="mb-3">Account Information</h5>
              <div class="row">
                <div class="col-md-6">
                  <p><strong>Last Login:</strong><br>
                  <?php echo $admin['last_login'] ? date("M j, Y - g:i a", strtotime($admin['last_login'])) : 'Never'; ?></p>
                </div>
                <div class="col-md-6">
                  <p><strong>Account Created:</strong><br>
                  <?php echo date("M j, Y - g:i a", strtotime($admin['created_at'])); ?></p>
                </div>
              </div>
            </div>
            
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">Update Profile</button>
              
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include "includes/default-scripts.php";?>
  <script>
  $(document).ready(function() {
      // Profile image preview
      $('#profile').change(function() {
          const file = this.files[0];
          if (file) {
              const reader = new FileReader();
              reader.onload = function(e) {
                  $('#profilePreview').attr('src', e.target.result);
              }
              reader.readAsDataURL(file);
          }
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

      <?php if (isset($success)): ?>
        showToast('<?php echo $success; ?>', 'success');
      <?php endif; ?>
      <?php if (isset($error)): ?>
        showToast('<?php echo $error; ?>', 'error');
      <?php endif; ?>
  });
  </script>
</body>
</html>
