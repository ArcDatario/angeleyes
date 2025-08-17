<?php
// Admin Plans page
?>
<!doctype html>
<html lang="en">
<head>
  <?php include "includes/default-src.php";?>
  <style>
  /* Pricing Section */
  #pricing {
      background: white;
  }

  .pricing-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
    
  }

  .pricing-card {
      background-color: white;
      padding: 2rem;
      border-radius: 0.5rem;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.7);
      text-align: center;
      position: relative;
    overflow: hidden;
  }

  /* allow the badge to overflow the card and ensure visibility */
  .pricing-card.popular {
    overflow: visible;
  }

  /* Visible badge element inside the popular card */
  .pricing-card .plan-badge {
    position: absolute;
    top: 10px;
    right: -18px;
    color:white !important;
    background-color: #6366f1 !important;
    color: #fff;
    padding: 0.25rem 0.9rem;
    font-size: 0.75rem;
    font-weight: 700;
    border-radius: 0.25rem;
    transform: rotate(50deg);
    transform-origin: center;
    z-index: 20;
    box-shadow: 0 6px 14px rgba(16, 24, 40, 0.12);
    text-transform: uppercase;
    letter-spacing: .4px;
  }

  .pricing-card h3 {
      font-size: 1.8rem;
      margin-bottom: 1rem;
      color: var(--primary);
  }

  .price {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      color: var(--dark);
  }

  .price span {
      font-size: 1rem;
      font-weight: 400;
      color: var(--gray);
  }

  .pricing-features {
      margin-bottom: 2rem;
  }

  .pricing-features li {
      margin-bottom: 0.8rem;
      color: var(--gray);
  }
  /* keep card button consistent with admin styles */
  .pricing-card .cta-button { display: inline-block; }
  </style>
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
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3">My Account</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-list-check fs-6"></i>
                      <p class="mb-0 fs-3">My Task</p>
                    </a>
                    <a href="./authentication-login.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
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
