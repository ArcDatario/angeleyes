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
      <?php include "includes/header.php";?>
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
