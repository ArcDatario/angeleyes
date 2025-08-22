<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="./dashboard" class="text-nowrap logo-img">
        <img src="../angeleyes-logo.png" alt="Angeleyes" class="logo-img" style="height:40px; object-fit:contain;">
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>

    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">
        <li class="sidebar-item">
          <a class="sidebar-link" href="./dashboard" aria-expanded="false">
            <span>
              <i class="ti ti-layout-dashboard"></i>
            </span>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="./transactions" aria-expanded="false">
            <span>
              <i class="ti ti-receipt"></i>
            </span>
            <span class="hide-menu">Transactions</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="./plans" aria-expanded="false">
            <span>
              <i class="ti ti-layout-grid"></i>
            </span>
            <span class="hide-menu">Plans</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="./subscribers" aria-expanded="false">
            <span>
              <i class="ti ti-users"></i>
            </span>
            <span class="hide-menu">Subscribers</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="./subscriptions-list" aria-expanded="false">
            <span>
              <i class="ti ti-list"></i>
            </span>
            <span class="hide-menu">Subscription List</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="./admins" aria-expanded="false">
            <span>
              <i class="ti ti-shield-check"></i>
            </span>
            <span class="hide-menu">Admins</span>
          </a>
        </li>
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">LOG OUT</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link logout-link" href="#" aria-expanded="false">
            <span>
              <i class="ti ti-logout"></i>
            </span>
            <span class="hide-menu">Logout</span>
          </a>
        </li>
      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>

<!-- Modals placed outside sidebar to prevent positioning issues -->
<div class="modal-holder">
  <!-- Logout Confirmation Modal -->
  <div class="modal fade" id="logoutConfirmationModal" tabindex="-1" aria-labelledby="logoutConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutConfirmationModalLabel">Confirm Logout</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to log out?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="confirmLogout">Yes, Logout</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Loading Modal (same as login page) -->
  <div class="modal fade loading-modal" id="loadingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center py-4">
          <div class="loading-spinner mb-3"></div>
          <h5>Logging you out...</h5>
          <p class="text-muted">You will be redirected shortly</p>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
/* Ensure modals appear above all content */
.modal-holder {
  position: relative;
  z-index: 9999;
}

.modal {
  z-index: 99999;
}

/* Loading spinner styles */
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
</style>

<script>
$(document).ready(function() {
  // Create modal instances
  var logoutConfirmationModal = new bootstrap.Modal(document.getElementById('logoutConfirmationModal'));
  var loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
  
  // Handle logout link click
  $('.logout-link').on('click', function(e) {
    e.preventDefault();
    logoutConfirmationModal.show();
  });
  
  // Handle confirm logout button click
  $('#confirmLogout').on('click', function() {
    // Hide confirmation modal
    logoutConfirmationModal.hide();
    
    // Show loading modal
    loadingModal.show();
    
    // Redirect to logout after a short delay
    setTimeout(function() {
      window.location.href = './logout';
    }, 1500);
  });
});
</script>