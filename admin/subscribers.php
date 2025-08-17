<!doctype html>
<html lang="en">
<head>
  <?php include "includes/default-src.php";?>
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
                <h5 class="card-title">Subscribers</h5>
                <div class="table-responsive">
                  <table class="table table-hover align-middle">
                    <thead>
                      <tr>
                        <th>Profile</th>
                        <th>User Id</th>
                        <th>FullName</th>
                        <th>Plan</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><img src="assets/images/profile/user-1.jpg" alt="" width="40" height="40" class="rounded-circle"></td>
                        <td>U1001</td>
                        <td>Denison Cruz</td>
                        <td>Pro</td>
                        <td>denison@example.com</td>
                        <td>09171234567</td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>
                          <div class="dropdown">
                            <button class="btn p-0" type="button" id="actionMenu1" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="ti ti-dots-vertical fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionMenu1">
                              <li><a class="dropdown-item" href="javascript:void(0)">View</a></li>
                              <li><a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a></li>
                            </ul>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><img src="assets/images/profile/user-1.jpg" alt="" width="40" height="40" class="rounded-circle"></td>
                        <td>U1002</td>
                        <td>Maria Lopez</td>
                        <td>Basic</td>
                        <td>maria@example.com</td>
                        <td>09171230000</td>
                        <td><span class="badge bg-warning">Trial</span></td>
                        <td>
                          <div class="dropdown">
                            <button class="btn p-0" type="button" id="actionMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="ti ti-dots-vertical fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionMenu2">
                              <li><a class="dropdown-item" href="javascript:void(0)">View</a></li>
                              <li><a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a></li>
                            </ul>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><img src="assets/images/profile/user-1.jpg" alt="" width="40" height="40" class="rounded-circle"></td>
                        <td>U1003</td>
                        <td>Angela Reyes</td>
                        <td>Enterprise</td>
                        <td>angela@example.com</td>
                        <td>09171239999</td>
                        <td><span class="badge bg-secondary">Inactive</span></td>
                        <td>
                          <div class="dropdown">
                            <button class="btn p-0" type="button" id="actionMenu3" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="ti ti-dots-vertical fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionMenu3">
                              <li><a class="dropdown-item" href="javascript:void(0)">View</a></li>
                              <li><a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a></li>
                            </ul>
                          </div>
                        </td>
                      </tr>
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

  <?php include "includes/default-scripts.php";?>
</body>

</html>
