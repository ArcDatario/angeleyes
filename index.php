<?php
// Add this at the very top of index.php (before the DOCTYPE)
require_once 'db.php'; // Adjust path as needed

// Fetch plans from database
$plans = [];
$inclusions_by_plan = [];

try {
    $result = $conn->query("
        SELECT p.*, 
               GROUP_CONCAT(i.inclusion_text SEPARATOR '||') AS inclusions
        FROM plans p
        LEFT JOIN inclusions i ON p.id = i.plan_id
        GROUP BY p.id
        ORDER BY p.price ASC
    ");
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $plans[] = $row;
            // Store inclusions separately for each plan
            $inclusions_by_plan[$row['id']] = !empty($row['inclusions']) ? 
                explode('||', $row['inclusions']) : [];
        }
    }
} catch (Exception $e) {
    // Handle error silently for production
    error_log("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANGELEYES - Fast & Reliable Fiber Internet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add these to your head section if not already present -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="angeleyes-logo.png">
    <link rel="stylesheet" href="assets/css/styles.css">

    <link rel="stylesheet" href="assets/css/light-modal.css">
    <link rel="stylesheet" href="assets/css/gallery.css">
    <style>
        :root {
            --primary: 
            #1cb4dc;
            --primary-light: #6366f1;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --success: #10b981;
        }
        
      
/* Ensure the button appears below the text and has consistent spacing */
.inquiry-card .secondary-button {
    display: block;
    margin-top: 1.5rem; /* Adjust as needed for your design */
    text-align: center; /* Center the button */
    width: 60%  !important;
    margin-left:20%;
}
.logo img {
    height: 50px; /* Adjust as needed */
    width: auto;
    transition: all 0.3s ease;
}

/* For responsive adjustments */
@media (max-width: 768px) {
    .logo img {
        height: 35px;
    }
  
}
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav id="navbar">
       <a href="#home" class="logo">
            <img src="angeleyes-logo.png" alt="ANGELEYES Logo">
        </a>
        
        <div class="nav-links">
            <a href="#home">Home</a>
            <a href="#about">About Us</a>
            <a href="#branches">Branches</a>
            <a href="#coverage">Coverage</a>
            <a href="#features">Features</a>
            <a href="#inquiry">Inquiry</a>
            <a href="#pricing">Pricing</a>
            <a href="#faq">FAQ</a>
        </div>
        
        <a href="#inquiry" class="cta-button">Contact Us</a>
        
        <div class="mobile-menu-btn">
            <i class="fas fa-bars"></i>
        </div>
    </nav>
     
<!-- Hero Section -->
<section id="home">
    <div class="hero-content">
        <div class="hero-text">
            <h1 class="hero-title">Ultra-Fast <span>Fiber Optic</span> Internet</h1>
            
            <!-- Mobile SVG container (shown only on mobile) -->
            <div class="mobile-svg-container"></div>
            
            <p class="hero-subtitle">Experience lightning-fast speeds with ANGELEYES's reliable fiber internet connection across Solano, Nueva Vizcaya. Stream, game, and work without interruptions.</p>
            
            <div class="hero-buttons">
                <a href="#internet-plans" class="cta-button">View Plans</a>
                <a href="#coverage" class="secondary-button">Check Coverage</a>
            </div>
        </div>
        
        <div class="hero-image-container">
            <!-- Empty container for layout consistency -->
        </div>
    </div>
</section>
        <!-- Product Section -->
    <section id="products">
        <h2 class="section-title">Our Products</h2>
        <p style="text-align: center; margin-bottom: 2rem; color: var(--gray);">Quality products for your home and business</p>
        
        <div class="products-container">
            <div class="product-card">
                <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="CCTV System">
                <h3>CCTV Systems</h3>
                <p>High-definition surveillance cameras with night vision and remote monitoring capabilities for complete security.</p>
            </div>
            
            <div class="product-card">
                <img src="https://images.unsplash.com/photo-1581094271901-8022df4466f9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Fire Alarm Installation">
                <h3>Fire Alarm Systems</h3>
                <p>Advanced fire detection and alarm systems to protect your property and ensure safety compliance.</p>
            </div>
            
            <div class="product-card">
                <img src="https://images.unsplash.com/photo-1509391366360-2e959784a276?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1472&q=80" alt="Solar Panels">
                <h3>Solar Panel Systems</h3>
                <p>Eco-friendly solar energy solutions to reduce electricity costs and carbon footprint.</p>
            </div>
            
            <div class="product-card">
                <img src="https://images.unsplash.com/photo-1597852074816-d933c7d2b988?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Network Equipment">
                <h3>Network Equipment</h3>
                <p>High-performance routers, switches, and access points for reliable connectivity.</p>
            </div>
        </div>
    </section>
    
<!-- Gallery Section -->
<?php include "includes/gallery.php";?>

<!-- About Section -->
<section id="about">
    <h2 class="section-title">About Us</h2>
    <div class="text-center mb-4">
        <button type="button" class="btn btn-primary view-details-btn" data-bs-toggle="modal" data-bs-target="#aboutModal">
            <i class="fas fa-info-circle me-2"></i>View Details
        </button>
    </div>
    <div class="about-container">
        <div class="about-content">
            <div class="mission-vision">
                <h3>Our Mission</h3>
                <p class="text-justify">At Angeleyes Solutions Inc., we provide fast internet (P2P Air Fiber, FTTH, Cable TV), strong security (CCTV, FDAS, Smart Gates), solar power, and tech systems like Piso WiFi, online payments, and LAN/Data Cabinets. We're here to make modern tech easy, affordable, and available for everyone—backed by expert support every step of the way</p>
            </div>
            
            <div class="mission-vision">
                <h3>Our Vision</h3>
                <p class="text-justify">Filipino home and business with smart, secure, and sustainable tech solutions.</p>
            </div>
        </div>
        
        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="ANGELEYES Team" class="about-image">
    </div>
</section>

<style>

.text-justify {
    text-align: justify !important;
    text-justify: inter-word !important;
}

.view-details-btn {
    display: inline-block;
    margin: 0 auto;
}
</style>
<!-- Modal -->
<div class="modal fade" id="aboutModal" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aboutModalLabel">About Angeleyes Solutions Inc.</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-justify">Angeleyes Solutions Inc. is a trusted systems integrator and contractor specializing in comprehensive technology solutions across Northern Luzon. From high-speed internet infrastructure—such as P2P AirFiber, FTTH, and Cable TV—to essential services like CCTV & surveillance, FDAS (Fire Detection and Alarm Systems), LAN & wireless networks, and online payment systems, we empower homes, businesses, and institutions with smarter, safer, and more connected environments.</p>
                
                <p class="text-justify">We also offer solar & power systems, data & server cabinet setups, smart gate automation, Piso WiFi machines, and full telecom integration (PBX, VoIP, intercom). With every service backed by professional installation and reliable after-sales support, Angeleyes is your all-in-one partner for future-ready infrastructure. Contact us now and upgrade with confidence.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    
    <!-- Branches Section -->
       <?php include "includes/branches.php";?>
    
    <!-- Coverage Section -->
   <?php include "includes/coverage.php";?>
    

    <section id="coverage">
        <h2 class="section-title">P2P Air Fiber</h2>
        <p style="text-align: center; margin-bottom: 2rem; color: var(--gray);">Now available in this municipalities:</p>
        
        <div class="coverage-container">
        <div class="municipality-tabs">
            <div class="municipality-tab active" data-target="nueva-vizcaya">Nueva Vizcaya</div>
        </div>
        
        <div class="barangay-list active" id="nueva-vizcaya">
            <div class="barangay-item">Solano</div>
            <div class="barangay-item">Bayombong</div>
            <div class="barangay-item">Runruno</div>
            <div class="barangay-item">Villaverde</div>
        </div>
    </div>
     
    </section>
    <!-- Features Section -->
    <section id="features">
        <h2 class="section-title">Why Choose ANGELEYES</h2>
        
        <div class="features-container">
            <div class="video-container">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/y42D87r6P7s" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            
            <div class="feature-cards">
                <div class="feature-card">
                    <h3>Fast</h3>
                    <p>Faster speeds are available for your home. With speeds up to 200, 300, and 400 Mbps; PADECO Fiber Optic Internet currently offers the top speed – much faster than DSL and cable.</p>
                </div>
                
                <div class="feature-card">
                    <h3>Reliable</h3>
                    <p>Reliable Internet means a stable internet connection. With PADECO, you don't have to struggle to keep your bandwidth high and won't have to worry about frequent disconnections.</p>
                </div>
                
                <div class="feature-card">
                    <h3>Secure</h3>
                    <p>Security matters. Knowing that your work is secure, that your accounts are safe, and that your information is protected is important. PADECO Internet offers you this and more.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Inquiry Section -->
   <?php include "includes/inquiry.php";?>

    <!-- Internet Plans Section -->
  <?php include "includes/internet-plans.php";?>

<!-- (now showing Cable TV) -->
  <?php include "includes/cable-tv.php";?>

    <!-- FAQ Section -->
    <?php include "includes/faq.php";?>
    
    <!-- Footer -->
      <?php include "includes/footer.php";?>
    
  <!-- Modal Overlay and Modal -->
<div class="modal-overlay" id="lightModalOverlay">
    <div class="light-modal" id="lightModal">
        <button class="modal-close" id="modalCloseBtn" aria-label="Close">&times;</button>
        <div class="modal-image-container">
           
            <!-- Your images are displayed here -->
            <img class="modal-image active" src="images/modal-images/1.png" alt="Modal Image 1">
            <img class="modal-image" src="images/modal-images/2.png" alt="Modal Image 2">
            <img class="modal-image" src="images/modal-images/3.png" alt="Modal Image 3">
            <img class="modal-image" src="images/modal-images/4.png" alt="Modal Image 4">
            <img class="modal-image" src="images/modal-images/5.png" alt="Modal Image 5">
            <img class="modal-image" src="images/modal-images/6.png" alt="Modal Image 6">
            <img class="modal-image" src="images/modal-images/7.png" alt="Modal Image 7">
            
        </div>
        <div class="image-indicators" id="imageIndicators">
            <div class="indicator active" data-index="0"></div>
            <div class="indicator" data-index="1"></div>
            <div class="indicator" data-index="2"></div>
            <div class="indicator" data-index="3"></div>
            <div class="indicator" data-index="4"></div>
            <div class="indicator" data-index="5"></div>
            <div class="indicator" data-index="6"></div>

        </div>
        <div class="modal-actions">
            <button class="pay-btn" onclick="window.open('payment', '_blank')">
                Pay Online
                <span class="arrow-right">→</span>
            </button>
        </div>
    </div>
</div>

<script src="scripts/light-modal.js"></script>

<script src="script.js"></script>



<script src="assets/js/gallery.js"></script>
</body>
</html>
