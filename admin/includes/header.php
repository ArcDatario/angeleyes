<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
        </ul>
        
        <div class="navbar-nav ms-auto">
            <div class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <?php
                    // Get the admin ID from session
                    $admin_id = $_SESSION['admin_id'] ?? null;
                    
                    if ($admin_id) {
                        // Fetch the latest profile image from database
                        require_once '../db.php';
                        $query = "SELECT profile FROM admin WHERE id = $admin_id";
                        $result = $conn->query($query);
                        
                        if ($result && $result->num_rows > 0) {
                            $admin_data = $result->fetch_assoc();
                            $profile_img = !empty($admin_data['profile']) ? 
                                '../admin/uploads/'.$admin_data['profile'] : '../user.png';
                        } else {
                            // Fallback if query fails
                            $profile_img = '../user.png';
                        }
                    } else {
                        // Fallback values if no session
                        $profile_img = '../user.png';
                    }
                    ?>
                    <img src="<?php echo $profile_img; ?>" 
                         alt="Admin Profile" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                    <div class="message-body">
                        <a href="profile.php" class="d-flex align-items-center gap-2 dropdown-item">
                            <i class="ti ti-user fs-6"></i>
                            <p class="mb-0 fs-3">My Profile</p>
                        </a>
                        <a href="../admin/logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>