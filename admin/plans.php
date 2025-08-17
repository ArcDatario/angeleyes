<?php
// Admin Plans page
?>
<!doctype html>
<html lang="en">
<head>
  <?php include "includes/default-src.php";?>

  <link rel="stylesheet" href="assets/css/plans.css">
</head>

<body>
  <!--  Body Wrapper -->
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
                  <a href="./add-plan.php" class="btn btn-primary"> Add Plan</a>
                </div>

                <!-- Pricing Section -->
                <section id="pricing">
                 
                  
                  <div class="pricing-container">
                      <div class="pricing-card">
                          <h3>PLAN 999</h3>
                          <div class="price">₱999 <span>/month</span></div>
                          <ul class="pricing-features">
                              <li>Up to *100 Mbps</li>
                              <li>NO DATA CAP</li>
                              <li>24/7 Customer Support</li>
                          </ul>
                          <a href="#inquiry" class="cta-button btn btn-outline-primary">View</a>
                      </div>
                      
                        <div class="pricing-card popular">
                        <span class="plan-badge">Popular</span>
                        <h3>PLAN 1500</h3>
                          <div class="price">₱1,500 <span>/month</span></div>
                          <ul class="pricing-features">
                              <li>Up to *300 Mbps</li>
                              <li>NO DATA CAP</li>
                              <li>24/7 Customer Support</li>
                          </ul>
                          <a href="#inquiry" class="cta-button btn btn-outline-primary">View</a>
                      </div>
                      
                      <div class="pricing-card">
                          <h3>PLAN 2500</h3>
                          <div class="price">₱2,500 <span>/month</span></div>
                          <ul class="pricing-features">
                              <li>Up to *400 Mbps</li>
                              <li>NO DATA CAP</li>
                              <li>24/7 Customer Support</li>
                          </ul>
                          <a href="#inquiry" class="cta-button btn btn-outline-primary">View</a>
                      </div>
                      
                      <div class="pricing-card">
                          <h3>PLAN 3500</h3>
                          <div class="price">₱3,500 <span>/month</span></div>
                          <ul class="pricing-features">
                              <li>Up to *500 Mbps</li>
                              <li>NO DATA CAP</li>
                              <li>24/7 Customer Support</li>
                          </ul>
                          <a href="#inquiry" class="cta-button btn btn-outline-primary">View</a>
                      </div>
                  </div>
                </section>

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
