<?php
// File: subscribers.php
require_once '../db.php';
?>
<!doctype html>
<html lang="en">
<head>
  <?php include "includes/default-src.php";?>
  <style>
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
    .profile-img {
        width: 40px;
        height: 40px;
        object-fit: cover;
    }
    .card-body {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); /* x-offset, y-offset, blur, color */
    border-radius: 8px; /* optional, for rounded corners */
    padding: 16px; /* optional, for spacing inside */
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
                  <h5 class="card-title mb-0">Subscribers</h5>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subscriberModal">Add Subscriber</button>
                </div>

                <div class="table-responsive">
                  <table class="table table-hover align-middle" id="subscribersTable">
                    <thead>
                      <tr>
                        <th>Profile</th>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Plan</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Subscribers will be loaded via AJAX -->
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

  <!-- Subscriber Modal -->
  <div class="modal fade" id="subscriberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fs-6">Subscriber Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="subscriberForm">
            <input type="hidden" id="subscriberId" name="id" value="0">
            <div class="mb-3">
              <label for="fullName" class="form-label">Full Name</label>
              <input type="text" class="form-control form-control-sm" id="fullName" name="full_name" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control form-control-sm" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label">Phone</label>
              <input type="text" class="form-control form-control-sm" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">Address</label>
              <textarea class="form-control form-control-sm" id="address" name="address" rows="2"></textarea>
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select class="form-select form-select-sm" id="status" name="status">
                <option value="Active" selected>Active</option>
                <option value="Inactive">Inactive</option>
                <option value="Pending">Pending</option>
                <option value="Suspended">Suspended</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-sm btn-danger" id="deleteSubscriberBtn" style="display:none;">Delete</button>
          <button type="button" class="btn btn-sm btn-primary" id="saveSubscriberBtn">Save</button>
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
          <p>Are you sure you want to delete this subscriber? This action cannot be undone.</p>
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
    const subscriberModal = new bootstrap.Modal(document.getElementById('subscriberModal'), {
        focus: false
    });
    const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'), {
        focus: false
    });

    // Change the view button click handler in subscribers.php
    $(document).on('click', '.view-subscriber', function(e) {
        e.preventDefault();
        const subscriberId = $(this).data('id');
        window.location.href = `subscriptions.php?id=${subscriberId}`;
    });
    // Load subscribers on page load
    loadSubscribers();
    
    // Save subscriber
    $('#saveSubscriberBtn').click(function() {
        const $btn = $(this);
        $btn.prop('disabled', true);
        
        const formData = $('#subscriberForm').serializeArray();
        formData.push({name: 'action', value: 'save_subscriber'});
        
        $.post('ajax/crud_subscriber.php', formData)
            .done(function(response) {
                if (response.success) {
                    showToast('Subscriber saved successfully', 'success');
                    subscriberModal.hide();
                    loadSubscribers();
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
    
    // Delete subscriber
    $('#deleteSubscriberBtn').click(function() {
        confirmDeleteModal.show();
    });
    
    $('#confirmDeleteBtn').click(function() {
        const $btn = $(this);
        $btn.prop('disabled', true);
        
        const subscriberId = $('#subscriberId').val();
        
        $.post('ajax/crud_subscriber.php', {action: 'delete_subscriber', id: subscriberId})
            .done(function(response) {
                if (response.success) {
                    showToast('Subscriber deleted successfully', 'success');
                    subscriberModal.hide();
                    confirmDeleteModal.hide();
                    loadSubscribers();
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
    
  // Edit subscriber (opens modal for editing)
  $(document).on('click', '.edit-subscriber', function() {
    const subscriberId = $(this).data('id');
    openSubscriberModal(subscriberId, false);
  });

  // View subscriber (arrow) - opens modal in read-only mode
  $(document).on('click', '.view-subscriber', function() {
    const subscriberId = $(this).data('id');
    openSubscriberModal(subscriberId, true);
  });

  function openSubscriberModal(subscriberId, readOnly) {
    $.post('ajax/crud_subscriber.php', {action: 'get_subscriber', id: subscriberId}, function(response) {
      if (response.success) {
        const subscriber = response.subscriber;
        $('#subscriberId').val(subscriber.id);
        $('#fullName').val(subscriber.full_name);
        $('#email').val(subscriber.email);
        $('#phone').val(subscriber.phone);
        $('#address').val(subscriber.address || '');
        $('#status').val(subscriber.status || 'Active');

        // Toggle readonly state
        $('#subscriberForm input, #subscriberForm textarea, #subscriberForm select').prop('disabled', !!readOnly);

        if (readOnly) {
          $('#deleteSubscriberBtn').hide();
        } else {
          $('#deleteSubscriberBtn').show();
        }

        subscriberModal.show();
      } else {
        showToast(response.message, 'error');
      }
    }, 'json');
  }
    
    // Reset form when modal is closed
    $('#subscriberModal').on('hidden.bs.modal', function() {
        $('#subscriberForm')[0].reset();
        $('#subscriberId').val('0');
        $('#status').val('Active');
        $('#deleteSubscriberBtn').hide();
        
        // Cleanup backdrop if needed
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
    });
    
   
    // Function to load subscribers
// Function to load subscribers
function loadSubscribers() {
    $.post('ajax/crud_subscriber.php', {action: 'get_subscribers'}, function(response) {
        if (response.success) {
            let html = '';
            response.subscribers.forEach(sub => {
                const profileImg = sub.profile || '../user.png';
                const statusClass = sub.status === 'Active' ? 'bg-success' : 
                                  sub.status === 'Inactive' ? 'bg-secondary' :
                                  sub.status === 'Pending' ? 'bg-warning' : 'bg-danger';
                
                // Display subscription_count or "None" if 0 or null
                const subscriptionDisplay = sub.subscription_count > 0 ? sub.subscription_count : 'None';
                
                html += `
                <tr>
                    <td><img src="${profileImg}" alt="Profile" class="rounded-circle profile-img"></td>
                    <td>${sub.user_id}</td>
                    <td>${sub.full_name}</td>
                    <td>${subscriptionDisplay}</td>
                    <td>${sub.email}</td>
                    <td>${sub.phone}</td>
                    <td><span class="badge ${statusClass}">${sub.status}</span></td>
                    <td>
                        <div class="btn-group" role="group" aria-label="actions">
                          <button class="btn btn-outline-primary btn-sm edit-subscriber" data-id="${sub.id}">Edit</button>
                          <button class="btn btn-outline-secondary btn-sm view-subscriber" data-id="${sub.id}" title="View"><i class="ti ti-arrow-right"></i></button>
                        </div>
                    </td>
                </tr>`;
            });
            
            $('#subscribersTable tbody').html(html);
        } else {
            showToast(response.message, 'error');
        }
    }, 'json');
}
    
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