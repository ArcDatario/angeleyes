<?php
// File: subscriptions.php
require_once '../db.php';

// Get subscriber ID from query parameter
$subscriber_id = $_GET['id'] ?? 0;
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
        width: 80px;
        height: 80px;
        object-fit: cover;
    }
    .plan-card {
        cursor: pointer;
        transition: all 0.3s;
    }
    .plan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
    }
    .plan-card.selected {
        border: 2px solid #0d6efd;
        background-color: #f8f9fa;
    }
    .calendar-container {
        background: white;
        border-radius: 0.5rem;
        padding: 1rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
    }
    .flatpickr-calendar {
        width: 100%;
    }
    .card-body {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); /* x-offset, y-offset, blur, color */
    border-radius: 8px; /* optional, for rounded corners */
    padding: 16px; /* optional, for spacing inside */
   
}
.back-arrow {
  display: inline-block;
  font-size: 25px;
  font-weight: 600;
  color: black !important;
  text-decoration: none;
  padding: 0px 10px;
  border-radius: 8px;
  background: #fff;
  transition: all 0.3s ease-in-out;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.back-arrow:hover {
  background: #4CAF50; /* green background on hover */
  color: #fff;         /* white text */
  transform: translateX(-5px); /* subtle slide left */
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}
  </style>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
          <div class="col-md-4">
            <div class="card mb-4">
                <a href="subscribers" class="back-arrow"> &#8592;</a>
              <div class="card-body text-center">
                <?php
                // Get subscriber info
                $subscriber = [];
                if ($subscriber_id) {
                    $subscriber = $conn->query("SELECT * FROM subscribers WHERE id = $subscriber_id")->fetch_assoc();
                }
                ?>
                <img src="<?= $subscriber['profile'] ?? '../user.png' ?>" alt="Profile" class="rounded-circle profile-img mb-3">
                <h4><?= $subscriber['full_name'] ?? 'Subscriber Not Found' ?></h4>
                <p class="text-muted mb-1">ID: <?= $subscriber['user_id'] ?? '' ?></p>
                <p class="text-muted mb-1"><?= $subscriber['email'] ?? '' ?></p>
                <p class="text-muted"><?= $subscriber['phone'] ?? '' ?></p>
                <span class="badge bg-<?= 
                    $subscriber['status'] === 'Active' ? 'success' : 
                    ($subscriber['status'] === 'Inactive' ? 'secondary' : 
                    ($subscriber['status'] === 'Pending' ? 'warning' : 'danger'))
                ?>">
                    <?= $subscriber['status'] ?? '' ?>
                </span>
              </div>
            </div>
          </div>

          <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <h5 class="card-title mb-0">Subscriptions</h5>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subscriptionModal">Add Subscription</button>
                </div>

                <div class="table-responsive">
                  <table class="table table-hover align-middle" id="subscriptionsTable">
                    <thead>
                      <tr>
                        <th>Reference</th>
                        <th>Plan</th>
                        <th>Start Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Subscriptions will be loaded via AJAX -->
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

  <!-- Subscription Modal -->
  <div class="modal fade" id="subscriptionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fs-6">Subscription Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="subscriptionForm">
            <input type="hidden" id="subscriptionId" name="id" value="0">
            <input type="hidden" id="subscriberId" name="user_id" value="<?= $subscriber_id ?>">
            
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="reference" class="form-label">Reference</label>
                <input type="text" class="form-control form-control-sm" id="reference" name="reference" readonly>
              </div>
              <div class="col-md-6">
                <label for="status" class="form-label">Status</label>
                <select class="form-select form-select-sm" id="status" name="status">
                  <option value="Active" selected>Active</option>
                  <option value="Inactive">Inactive</option>
                  <option value="Pending">Pending</option>
                  <option value="Suspended">Suspended</option>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Select Plan</label>
              <div class="row" id="plansContainer">
                <!-- Plans will be loaded via AJAX -->
              </div>
              <input type="hidden" id="planId" name="plan_id">
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <div class="calendar-container mb-3">
                  <label for="started_date" class="form-label">Start Date</label>
                  <input type="text" class="form-control form-control-sm datepicker" id="started_date" name="started_date" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="calendar-container mb-3">
                  <label for="due_date" class="form-label">Due Date</label>
                  <input type="text" class="form-control form-control-sm datepicker" id="due_date" name="due_date" readonly>
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="address" class="form-label">Address</label>
              <div class="input-group mb-2">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="useSubscriberAddress">Use Subscriber Address</button>
              </div>
              <textarea class="form-control form-control-sm" id="address" name="address" rows="3" required></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-sm btn-danger" id="deleteSubscriptionBtn" style="display:none;">Delete</button>
          <button type="button" class="btn btn-sm btn-primary" id="saveSubscriptionBtn">Save</button>
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
          <p>Are you sure you want to delete this subscription? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-sm btn-danger" id="confirmDeleteBtn">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <?php include "includes/default-scripts.php";?>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
$(document).ready(function() {
    // Initialize modals
    const subscriptionModal = new bootstrap.Modal(document.getElementById('subscriptionModal'), {
        focus: false
    });
    const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'), {
        focus: false
    });

    // Initialize date pickers
    const startDatePicker = flatpickr('#started_date', {
        dateFormat: "M j, Y",
        minDate: "today",
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length > 0) {
                const dueDate = new Date(selectedDates[0]);
                dueDate.setMonth(dueDate.getMonth() + 1);
                dueDatePicker.setDate(dueDate);
            }
        }
    });

    const dueDatePicker = flatpickr('#due_date', {
        dateFormat: "M j, Y",
        minDate: "today"
    });

    // Load subscriptions on page load
    loadSubscriptions();
    loadPlansForSelection();

    // Generate reference number when adding new subscription
    $('#subscriptionModal').on('show.bs.modal', function() {
        if ($('#subscriptionId').val() == '0') {
            $('#reference').val(generateReference());
        }
    });

    // Use subscriber's address
    $('#useSubscriberAddress').click(function() {
        const subscriberId = $('#subscriberId').val();
        if (subscriberId) {
            $.post('ajax/crud_subscriber.php', {action: 'get_subscriber', id: subscriberId}, function(response) {
                if (response.success && response.subscriber.address) {
                    $('#address').val(response.subscriber.address);
                }
            }, 'json');
        }
    });

    // Select plan
    $(document).on('click', '.plan-card', function() {
        $('.plan-card').removeClass('selected');
        $(this).addClass('selected');
        $('#planId').val($(this).data('id'));
    });

    // Save subscription
    $('#saveSubscriptionBtn').click(function() {
        const $btn = $(this);
        $btn.prop('disabled', true);
        
        const formData = $('#subscriptionForm').serializeArray();
        formData.push({name: 'action', value: 'save_subscription'});
        
        $.post('ajax/crud_subscription.php', formData)
            .done(function(response) {
                if (response.success) {
                    showToast('Subscription saved successfully', 'success');
                    subscriptionModal.hide();
                    loadSubscriptions();
                    
                    // Update subscriber's subscription count
                    const subscriberId = $('#subscriberId').val();
                    if (subscriberId && $('#subscriptionId').val() == '0') {
                        $.post('ajax/crud_subscriber.php', {
                            action: 'update_subscription_count',
                            id: subscriberId,
                            increment: 1
                        });
                    }
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
    
    // Delete subscription
    $('#deleteSubscriptionBtn').click(function() {
        confirmDeleteModal.show();
    });
    
    $('#confirmDeleteBtn').click(function() {
        const $btn = $(this);
        $btn.prop('disabled', true);
        
        const subscriptionId = $('#subscriptionId').val();
        const subscriberId = $('#subscriberId').val();
        
        $.post('ajax/crud_subscription.php', {action: 'delete_subscription', id: subscriptionId})
            .done(function(response) {
                if (response.success) {
                    showToast('Subscription deleted successfully', 'success');
                    subscriptionModal.hide();
                    confirmDeleteModal.hide();
                    loadSubscriptions();
                    
                    // Update subscriber's subscription count
                    if (subscriberId) {
                        $.post('ajax/crud_subscriber.php', {
                            action: 'update_subscription_count',
                            id: subscriberId,
                            increment: -1
                        });
                    }
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
    
    // View subscription details
    $(document).on('click', '.view-subscription', function() {
        const subscriptionId = $(this).data('id');
        
        $.post('ajax/crud_subscription.php', {action: 'get_subscription', id: subscriptionId}, function(response) {
            if (response.success) {
                const subscription = response.subscription;
                $('#subscriptionId').val(subscription.id);
                $('#reference').val(subscription.reference);
                $('#status').val(subscription.status || 'Active');
                $('#planId').val(subscription.plan_id);
                
                // Set dates in formatted way
                if (subscription.started_date) {
                    const startDate = new Date(subscription.started_date);
                    startDatePicker.setDate(startDate);
                    
                    const dueDate = new Date(startDate);
                    dueDate.setMonth(dueDate.getMonth() + 1);
                    dueDatePicker.setDate(dueDate);
                }
                
                $('#address').val(subscription.address || '');
                
                // Highlight selected plan
                $('.plan-card').removeClass('selected');
                $(`.plan-card[data-id="${subscription.plan_id}"]`).addClass('selected');
                
                $('#deleteSubscriptionBtn').show();
                subscriptionModal.show();
            } else {
                showToast(response.message, 'error');
            }
        }, 'json');
    });
    
    // Reset form when modal is closed
    $('#subscriptionModal').on('hidden.bs.modal', function() {
        $('#subscriptionForm')[0].reset();
        $('#subscriptionId').val('0');
        $('#reference').val('');
        $('#status').val('Active');
        $('#planId').val('');
        $('.plan-card').removeClass('selected');
        $('#deleteSubscriptionBtn').hide();
        
        // Reset date pickers
        startDatePicker.clear();
        dueDatePicker.clear();
        
        // Cleanup backdrop if needed
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
    });
    
    // Function to load subscriptions
    function loadSubscriptions() {
        const subscriberId = $('#subscriberId').val();
        if (!subscriberId) return;
        
        $.post('ajax/crud_subscription.php', {
            action: 'get_subscriptions',
            user_id: subscriberId
        }, function(response) {
            if (response.success) {
                let html = '';
                response.subscriptions.forEach(sub => {
                    const statusClass = sub.status === 'Active' ? 'bg-success' : 
                                      sub.status === 'Inactive' ? 'bg-secondary' :
                                      sub.status === 'Pending' ? 'bg-warning' : 'bg-danger';
                    
                    // Format dates
                    const startDate = sub.started_date ? formatDate(new Date(sub.started_date)) : 'N/A';
                    const dueDate = sub.due_date ? formatDate(new Date(sub.due_date)) : 'N/A';
                    
                    html += `
                    <tr>
                        <td>${sub.reference}</td>
                        <td>${sub.plan_name || 'None'}</td>
                        <td>${startDate}</td>
                        <td>${dueDate}</td>
                        <td><span class="badge ${statusClass}">${sub.status}</span></td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm view-subscription" data-id="${sub.id}">View</button>
                        </td>
                    </tr>`;
                });
                
                $('#subscriptionsTable tbody').html(html || '<tr><td colspan="6" class="text-center">No subscriptions found</td></tr>');
            } else {
                showToast(response.message, 'error');
            }
        }, 'json');
    }
    
    // Function to load plans for selection
    function loadPlansForSelection() {
        $.post('ajax/crud_plan.php', {action: 'get_plans'}, function(response) {
            if (response.success) {
                let html = '';
                response.plans.forEach(plan => {
                    const badge = plan.badge ? `<span class="badge bg-primary">${plan.badge}</span>` : '';
                    const price = parseFloat(plan.price).toFixed(2);
                    
                    html += `
                    <div class="col-md-6 mb-3">
                        <div class="card plan-card" data-id="${plan.id}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">${plan.plan_name}</h5>
                                    ${badge}
                                </div>
                                <div class="price mb-2">₱${price} <small>/month</small></div>
                                <ul class="list-unstyled">
                                    ${plan.inclusions ? plan.inclusions.split('||').slice(0, 2).map(inc => `<li>${inc}</li>`).join('') : ''}
                                    ${plan.inclusions && plan.inclusions.split('||').length > 2 ? '<li class="text-muted">+ more</li>' : ''}
                                </ul>
                            </div>
                        </div>
                    </div>`;
                });
                
                $('#plansContainer').html(html);
            } else {
                showToast(response.message, 'error');
            }
        }, 'json');
    }
    
    // Function to generate reference number
    function generateReference() {
        const chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        let result = '';
        for (let i = 0; i < 10; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return result;
    }
    
    // Function to format date as "Aug 18, 2025"
    function formatDate(date) {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return `${months[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
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