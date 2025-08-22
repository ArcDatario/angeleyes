<?php
// File: plans.php
require_once '../db.php';
require_once('auth_check.php');
require_login();
?>
<!doctype html>
<html lang="en">
<head>
  <?php include "includes/default-src.php";?>
  <link rel="stylesheet" href="assets/css/plans.css">
  <style>
    .toast {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1100;
    }
    .toast {
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
    }
    .add-inclusion {
        cursor: pointer;
        font-size: 0.8rem;
    }
    .inclusion-input-group {
        margin-bottom: 0.5rem;
    }
    .plan-badge {
        font-size: 0.7rem;
        padding: 0.2rem 0.4rem;
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
                  <h5 class="card-title mb-0">Plans</h5>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#planModal">Add Plan</button>
                </div>

                <!-- Pricing Section -->
                <section id="pricing">
                  <div class="pricing-container" id="plansContainer">
                      <!-- Plans will be loaded via AJAX -->
                  </div>
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Plan Modal -->
  <div class="modal fade" id="planModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fs-6">Plan Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="planForm">
            <input type="hidden" id="planId" name="id" value="0">
            <div class="mb-3">
              <label for="planName" class="form-label">Plan Name</label>
              <input type="text" class="form-control form-control-sm" id="planName" name="plan_name" required>
            </div>
            <!-- File: plans.php (updated modal part) -->
            <div class="mb-3">
                <label for="planBadge" class="form-label">Badge</label>
                <select class="form-select form-select-sm" id="planBadge" name="badge">
                    <option value="">None</option>
                    <option value="popular">Popular</option>
                    <option value="top rated">Top Rated</option>
                    <option value="premium">Premium</option>
                </select>
            </div>
            <div class="mb-3">
              <label for="planPrice" class="form-label">Price</label>
              <input type="number" step="0.01" class="form-control form-control-sm" id="planPrice" name="price" required>
            </div>
            
            <div class="mb-3">
              <label class="form-label">Inclusions</label>
              <div id="inclusionsContainer">
                <div class="input-group inclusion-input-group">
                  <input type="text" class="form-control form-control-sm" name="inclusions[]" required>
                </div>
              </div>
              <small class="text-primary add-inclusion" id="addInclusion">+ Add another inclusion</small>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-sm btn-danger" id="deletePlanBtn" style="display:none;">Delete</button>
          <button type="button" class="btn btn-sm btn-primary" id="savePlanBtn">Save</button>
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
          <p>Are you sure you want to delete this plan? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-sm btn-danger" id="confirmDeleteBtn">Delete</button>
        </div>
      </div>
    </div>
  </div>
  <?php include "includes/default-scripts.php";?>

    <div class="toast"></div>
<script>
$(document).ready(function() {
  // Initialize modals with proper options
  const planModal = new bootstrap.Modal(document.getElementById('planModal'), {
    focus: false // Disable automatic focus handling
  });
  
  const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'), {
    focus: false // Disable automatic focus handling
  });

  // Load plans on page load
  loadPlans();
    
  // Add inclusion field
  $('#addInclusion').click(function() {
    $('#inclusionsContainer').append(`
      <div class="input-group inclusion-input-group mb-2">
        <input type="text" class="form-control form-control-sm" name="inclusions[]" required>
        <button class="btn btn-outline-secondary btn-sm remove-inclusion" type="button">×</button>
      </div>
    `);
  });
    
  // Remove inclusion field
  $(document).on('click', '.remove-inclusion', function() {
    $(this).closest('.inclusion-input-group').remove();
  });
    
  // Save plan - fixed version with proper focus management
  $('#savePlanBtn').click(function() {
    const $btn = $(this);
    $btn.prop('disabled', true);
    
    const formData = $('#planForm').serializeArray();
    formData.push({name: 'action', value: 'save_plan'});
        
    $.post('ajax/crud_plan.php', formData)
      .done(function(response) {
        try {
          const data = typeof response === 'string' ? JSON.parse(response) : response;
          if (data.success) {
            showToast('Plan saved successfully', 'success');
            
            // Proper modal closing sequence
            planModal.hide();
            
            // Manually remove focus from any modal elements
            $(':focus').blur();
            
            // Force cleanup if needed
            setTimeout(() => {
              $('.modal-backdrop').remove();
              $('body').removeClass('modal-open');
              loadPlans();
            }, 300);
          } else {
            showToast(data.message || 'Error saving plan', 'error');
          }
        } catch (e) {
          showToast('Invalid server response', 'error');
          console.error(e);
        }
      })
      .fail(function(xhr, status, error) {
        showToast('Request failed: ' + error, 'error');
      })
      .always(function() {
        $btn.prop('disabled', false);
      });
  });
    
  // Delete plan - fixed version
  $('#deletePlanBtn').click(function() {
    confirmDeleteModal.show();
  });
    
  $('#confirmDeleteBtn').click(function() {
    const $btn = $(this);
    $btn.prop('disabled', true);
    
    const planId = $('#planId').val();
        
    $.post('ajax/crud_plan.php', {action: 'delete_plan', id: planId})
      .done(function(response) {
        if (response.success) {
          showToast('Plan deleted successfully', 'success');
          
          // Proper closing sequence
          planModal.hide();
          confirmDeleteModal.hide();
          
          // Remove focus from modal buttons
          $(':focus').blur();
          
          // Force cleanup if needed
          setTimeout(() => {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            loadPlans();
          }, 300);
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
    
  // View plan details
  $(document).on('click', '.view-plan', function() {
    const planId = $(this).data('id');
        
    $.post('ajax/crud_plan.php', {action: 'get_plan', id: planId}, function(response) {
      if (response.success) {
        const plan = response.plan;
        $('#planId').val(plan.id);
        $('#planName').val(plan.plan_name);
        $('#planBadge').val(plan.badge || '');
        $('#planPrice').val(plan.price);
                
        $('#inclusionsContainer').empty();
        if (response.inclusions && response.inclusions.length > 0) {
          response.inclusions.forEach(inc => {
            $('#inclusionsContainer').append(`
              <div class="input-group inclusion-input-group mb-2">
                <input type="text" class="form-control form-control-sm" name="inclusions[]" value="${inc}" required>
                <button class="btn btn-outline-secondary btn-sm remove-inclusion" type="button">×</button>
              </div>
            `);
          });
        } else {
          $('#inclusionsContainer').append(`
            <div class="input-group inclusion-input-group mb-2">
              <input type="text" class="form-control form-control-sm" name="inclusions[]" required>
            </div>
          `);
        }
                
        $('#deletePlanBtn').show();
        planModal.show();
      } else {
        showToast(response.message, 'error');
      }
    }, 'json');
  });
    
  // Reset form when modal is closed
  $('#planModal').on('hidden.bs.modal', function() {
    $('#planForm')[0].reset();
    $('#planId').val('0');
    $('#inclusionsContainer').html(`
      <div class="input-group inclusion-input-group mb-2">
        <input type="text" class="form-control form-control-sm" name="inclusions[]" required>
      </div>
    `);
    $('#deletePlanBtn').hide();
  });
    
  // Function to load plans
  function loadPlans() {
    $.post('ajax/crud_plan.php', {action: 'get_plans'}, function(response) {
      if (response.success) {
        let html = '';
        response.plans.forEach(plan => {
          const badge = plan.badge ? `<span class="badge bg-primary plan-badge">${plan.badge}</span>` : '';
          const inclusions = plan.inclusions ? plan.inclusions.split('||') : [];
          const displayInclusions = inclusions.slice(0,3);
          const remaining = inclusions.length - displayInclusions.length;
          const inclusionsHtml = displayInclusions.map(inc => `<li>${inc}</li>`).join('');
          const moreHtml = remaining > 0 ? `<li class="text-muted">+${remaining} more</li>` : '';
          const isPopular = plan.badge && plan.badge.toLowerCase() === 'popular';
          const cardClass = isPopular ? 'pricing-card popular' : 'pricing-card';
                    
          html += `
          <div class="${cardClass}">
            ${badge}
            <h3>${plan.plan_name}</h3>
            <div class="price">₱${parseFloat(plan.price).toFixed(2)} <span>/month</span></div>
            <ul class="pricing-features">
              ${inclusionsHtml}
              ${moreHtml}
            </ul>
            <button class="cta-button btn btn-outline-primary view-plan" data-id="${plan.id}">View</button>
          </div>`;
        });
                
        $('#plansContainer').html(html);
      } else {
        showToast(response.message, 'error');
      }
    }, 'json');
  }
    
  // Function to show toast messages using the single <div class="toast"></div>
  
});
</script>
</body>
</html>