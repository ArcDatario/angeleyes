
<?php
session_start();
// Redirect to dashboard if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Angeleyes - Login</title>
  <link rel="shortcut icon" type="image/png" href="../angeleyes-logo.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    .loading-modal .modal-content {
      border-radius: 12px;
      border: none;
    }
    .loading-spinner {
      width: 60px;
      height: 60px;
      border: 5px solid #f3f3f3;
      border-top: 5px solid #3498db;
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin: 0 auto;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    .alert {
      border-radius: 8px;
      padding: 12px 15px;
      margin-bottom: 20px;
    }
    #errorMessage {
      display: none;
    }
    .shake {
      animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
    }
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
      20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
  </style>
</head>

<body>
  <!-- Loading Modal -->
  <div class="modal fade loading-modal" id="loadingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center py-4">
          <div class="loading-spinner mb-3"></div>
          <h5>Logging you in...</h5>
          <p class="text-muted">You will be redirected shortly</p>
        </div>
      </div>
    </div>
  </div>

  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-75">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="../angeleyes-logo.png" width="180" alt="">
                </a>
                <p class="text-center">Log In</p>
                
                <div id="errorMessage" class="alert alert-danger" role="alert">
                  <i class="fas fa-exclamation-circle me-2"></i> <span id="errorText"></span>
                </div>
                
                <form id="loginForm">
                  <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" name="remember_me" id="remember_me">
                      <label class="form-check-label text-dark" for="remember_me">
                        Remember this Device
                      </label>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-3 fs-6 mb-4 rounded-2">
                    <i class="fas fa-sign-in-alt me-2"></i> Sign In
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    $(document).ready(function() {
      // Create a Bootstrap modal instance for proper control
      var loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
      
      // Handle form submission
      $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        var formData = {
          username: $('#username').val(),
          password: $('#password').val(),
          remember_me: $('#remember_me').is(':checked') ? 1 : 0
        };
        
        // Hide any previous error messages
        $('#errorMessage').hide();
        
        // Basic validation
        if (!formData.username || !formData.password) {
          $('#errorText').text('Please enter both username and password.');
          $('#errorMessage').show();
          $('#loginForm').addClass('shake');
          setTimeout(function() {
            $('#loginForm').removeClass('shake');
          }, 500);
          return;
        }
        
        // Send AJAX request (don't show loading modal yet)
        $.ajax({
          url: 'login_ajax.php',
          type: 'POST',
          data: formData,
          dataType: 'json',
          success: function(response) {
            // If login successful, show loading modal then redirect
            if (response.success) {
              loadingModal.show();
              // Redirect to provided location if available after a short pause so the modal is visible
              var redirectTo = response.redirect || 'dashboard';
              setTimeout(function() {
                window.location.href = redirectTo;
              }, 3000); // 3000ms = 3s
            } else {
              // Shouldn't normally reach here because failures return 401, but handle defensively
              $('#errorText').text(response.message || 'Invalid username or password.');
              $('#errorMessage').show();
              $('#loginForm').addClass('shake');
              setTimeout(function() {
                $('#loginForm').removeClass('shake');
              }, 500);
            }
          },
          error: function(xhr, status, error) {
            // Do not show the loading modal on errors. Display server-provided message when available.
            var msg = 'An error occurred. Please try again.';
            try {
              var resp = xhr.responseJSON || JSON.parse(xhr.responseText || '{}');
              if (resp && resp.message) msg = resp.message;
            } catch (e) {
              // ignore parse errors and keep default message
            }

            $('#errorText').text(msg);
            $('#errorMessage').show();
            $('#loginForm').addClass('shake');
            setTimeout(function() {
              $('#loginForm').removeClass('shake');
            }, 500);

            // Log the error for debugging
            console.error('Login error:', status, error, xhr);
          }
        });
      });
    });
  </script>
</body>

</html>
