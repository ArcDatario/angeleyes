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
    .cta-button{
        display:none;
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
            <h1 class="hero-title">Ultra-Fast Fiber Optic Internet</h1>
            <p class="hero-subtitle">Experience lightning-fast speeds with ANGELEYES's reliable fiber internet connection across Pampanga</p>
            
            <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="ANGELEYES Network" class="hero-image">
            
            <div class="hero-buttons">
                <a href="#pricing" class="cta-button">View Plans</a>
                <a href="#coverage" class="secondary-button">Check Coverage</a>
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
        
        <div class="about-container">
            <div class="about-content">
                <div class="mission-vision">
                    <h3>Our Mission</h3>
                    <p>To provide reliable, high-speed internet connectivity to homes and businesses across Pampanga, empowering our community with seamless digital experiences and fostering growth through innovative technology solutions.</p>
                </div>
                
                <div class="mission-vision">
                    <h3>Our Vision</h3>
                    <p>To be the leading fiber internet provider in Central Luzon, recognized for our exceptional service, cutting-edge technology, and commitment to customer satisfaction, bridging the digital divide one connection at a time.</p>
                </div>
            </div>
            
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="ANGELEYES Team" class="about-image">
        </div>
    </section>
    
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
<section id="internet-plans">
    <h2 class="section-title">Internet Plans</h2>
    <p style="text-align: center; margin-bottom: 2rem; color: var(--gray);">Pick the best plan for you.</p>
    
    <div class="pricing-container">
        <?php if (!empty($plans)): ?>
            <?php 
            $plan_count = count($plans);
            $display_count = min($plan_count, 3); // Show max 3 initially
            
            for ($i = 0; $i < $plan_count; $i++): 
                $plan = $plans[$i];
                $is_popular = (!empty($plan['badge']) && strtolower($plan['badge']) === 'popular');
                $is_hidden = $i >= 3 ? 'hidden-plan' : '';
            ?>
                <div class="pricing-card <?php echo $is_popular ? 'popular' : ''; ?> <?php echo $is_hidden; ?>" 
                     data-index="<?php echo $i; ?>">
                    <?php if (!empty($plan['badge']) && !$is_popular): ?>
                        <span class="plan-badge"><?php echo htmlspecialchars($plan['badge']); ?></span>
                    <?php endif; ?>
                    
                    <h3><?php echo htmlspecialchars($plan['plan_name']); ?></h3>
                    <div class="price">₱<?php echo number_format($plan['price'], 2); ?> <span>/month</span></div>
                    
                    <ul class="pricing-features">
                        <?php 
                        $inclusions = $inclusions_by_plan[$plan['id']] ?? [];
                        $display_inclusions = array_slice($inclusions, 0, 3);
                        
                        foreach ($display_inclusions as $inclusion): ?>
                            <li><?php echo htmlspecialchars($inclusion); ?></li>
                        <?php endforeach; ?>
                        
                        <?php if (count($inclusions) > 3): ?>
                            <li class="text-muted">+<?php echo count($inclusions) - 3; ?> more inclusions</li>
                        <?php endif; ?>
                    </ul>
                    
                    <button class="cta-button view-plan-btn internet-plan-btn" 
                            data-plan-id="<?php echo $plan['id']; ?>"
                            data-plan-name="<?php echo htmlspecialchars($plan['plan_name']); ?>"
                            data-plan-price="₱<?php echo number_format($plan['price'], 2); ?>">
                        View Inclusions
                    </button>
                </div>
            <?php endfor; ?>
        <?php else: ?>
            <div class="no-plans-message">
                <p>No plans available at the moment. Please check back later.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if ($plan_count > 3): ?>
        <div class="view-all-container" style="text-align: center; margin-top: 2rem;">
            <button id="view-all-plans" class="secondary-button">View All Plans</button>
        </div>
    <?php endif; ?>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewAllButton = document.getElementById('view-all-plans');
    const pricingContainer = document.querySelector('.pricing-container');
    const hiddenPlans = document.querySelectorAll('.hidden-plan');
    let allPlansVisible = false;
    
    if (viewAllButton && hiddenPlans.length > 0) {
        viewAllButton.addEventListener('click', function() {
            if (!allPlansVisible) {
                // Show all plans
                hiddenPlans.forEach(plan => {
                    plan.style.display = 'block';
                    setTimeout(() => {
                        plan.style.opacity = '1';
                        plan.style.transform = 'translateY(0)';
                    }, 10);
                });
                
                viewAllButton.textContent = 'View Less';
                allPlansVisible = true;
                
                // Smooth scroll to the button position after expansion
                setTimeout(() => {
                    viewAllButton.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 300);
            } else {
                // Hide extra plans (show only first 3)
                hiddenPlans.forEach(plan => {
                    plan.style.opacity = '0';
                    plan.style.transform = 'translateY(20px)';
                    
                    setTimeout(() => {
                        plan.style.display = 'none';
                    }, 300);
                });
                
                viewAllButton.textContent = 'View All Plans';
                allPlansVisible = false;
                
                // Scroll to top of section when collapsing
                document.getElementById('internet-plans').scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            }
        });
    }
});
</script>

<style>
.hidden-plan {
    display: none;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.5s ease;
}

#internet-plans .pricing-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

#view-all-plans {
    background: transparent;
    color: var(--primary);
    border: 2px solid var(--primary);
    padding: 12px 30px;
    border-radius: 30px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

#view-all-plans:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(28, 180, 220, 0.3);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #internet-plans .pricing-container {
        grid-template-columns: 1fr;
    }
    
    .hidden-plan {
        display: none !important;
    }
}
</style>

<!-- (now showing Cable TV) -->
<section id="pricing">
    <h2 class="section-title">Cable TV Subscription</h2>
    <p style="text-align: center; margin-bottom: 2rem; color: var(--gray);">Enjoy entertainment for the whole family with our cable packages.</p>
    
    <div class="pricing-container">
        <!-- Basic Plan -->
        <div class="pricing-card">
            <br>
            <h3>Basic Entertainment</h3>
            <div class="price">₱499.00 <span>/month</span></div>
            
            <ul class="pricing-features">
                <li>60+ Local Channels</li>
                <li>10+ News Channels</li>
                <li>5 Popular Movie Channels</li>
                <li class="text-muted">+5 more inclusions</li>
            </ul>
            
            <button class="cta-button view-plan-btn cable-plan-btn" 
                    data-plan-name="Basic Entertainment"
                    data-plan-price="₱499.00">
                View All Channels
            </button>
        </div>
        
        <!-- Family Plan (Popular) -->
        <div class="pricing-card popular">
            <span class="plan-badge">Most Popular</span>
            <h3>Family Package</h3>
            <div class="price">₱799.00 <span>/month</span></div>
            
            <ul class="pricing-features">
                <li>80+ Local & International Channels</li>
                <li>15+ Kids & Educational Channels</li>
                <li>Premium Sports Channels</li>
                <li class="text-muted">+8 more inclusions</li>
            </ul>
            
            <button class="cta-button view-plan-btn cable-plan-btn" 
                    data-plan-name="Family Package"
                    data-plan-price="₱799.00">
                View All Channels
            </button>
        </div>
        
        <!-- Premium Plan -->
        <div class="pricing-card">
            <br>
            <h3>Premium Experience</h3>
            <div class="price">₱1,299.00 <span>/month</span></div>
            
            <ul class="pricing-features">
                <li>120+ Local & International Channels</li>
                <li>All Premium Movie Channels</li>
                <li>HD Sports & PPV Events</li>
                <li class="text-muted">+12 more inclusions</li>
            </ul>
            
            <button class="cta-button view-plan-btn cable-plan-btn" 
                    data-plan-name="Premium Experience"
                    data-plan-price="₱1,299.00">
                View All Channels
            </button>
        </div>
    </div>
</section>
<!-- Replace your existing modals with this code -->
<!-- Inclusions Modal -->
<div class="modal fade" id="inclusionsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inclusionsModalLabel">Plan Inclusions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 id="modalPlanName" class="mb-3"></h4>
                <div class="price mb-3" id="modalPlanPrice"></div>
                <ul id="modalInclusionsList" class="list-group"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="cta-button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Cable TV Channels Modal -->
<div class="modal fade" id="cableChannelsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cableChannelsModalLabel">Cable TV Channels</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 id="modalCablePlanName" class="mb-3"></h4>
                <div class="price mb-3" id="modalCablePlanPrice"></div>
                <div class="channels-container">
                    <h5>Included Channels:</h5>
                    <div class="channels-list" id="channelsList">
                        <!-- Channels will be populated by JavaScript -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="cta-button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Internet Plans modal handling
    const internetPlanButtons = document.querySelectorAll('.internet-plan-btn');
    const inclusionsModal = new bootstrap.Modal(document.getElementById('inclusionsModal'));
    const modalPlanName = document.getElementById('modalPlanName');
    const modalPlanPrice = document.getElementById('modalPlanPrice');
    const modalInclusionsList = document.getElementById('modalInclusionsList');
    
    // Store inclusions data for each plan
    const plansData = <?php echo json_encode($inclusions_by_plan); ?>;
    
    internetPlanButtons.forEach(button => {
        button.addEventListener('click', function() {
            const planId = this.getAttribute('data-plan-id');
            const planName = this.getAttribute('data-plan-name');
            const planPrice = this.getAttribute('data-plan-price');
            const inclusions = plansData[planId] || [];
            
            // Update modal content
            modalPlanName.textContent = planName;
            modalPlanPrice.innerHTML = planPrice + ' <span>/month</span>';
            modalInclusionsList.innerHTML = '';
            
            if (inclusions.length > 0) {
                inclusions.forEach(inclusion => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.textContent = inclusion;
                    modalInclusionsList.appendChild(li);
                });
            } else {
                const li = document.createElement('li');
                li.className = 'list-group-item text-muted';
                li.textContent = 'No inclusions available for this plan.';
                modalInclusionsList.appendChild(li);
            }
            
            // Show modal
            inclusionsModal.show();
            
            // Move focus to the close button when modal is shown
            $('#inclusionsModal').on('shown.bs.modal', function () {
                $(this).find('.btn-close').focus();
            });
        });
    });
    
    // Cable TV modal handling
    const cablePlanButtons = document.querySelectorAll('.cable-plan-btn');
    const cableModal = new bootstrap.Modal(document.getElementById('cableChannelsModal'));
    const modalCablePlanName = document.getElementById('modalCablePlanName');
    const modalCablePlanPrice = document.getElementById('modalCablePlanPrice');
    const channelsList = document.getElementById('channelsList');
    
    // Define channel lists for each plan
    const cablePlansData = {
        "Basic Entertainment": [
            "ABS-CBN", "GMA", "TV5", "CNN Philippines", "ANC", 
            "PTV", "IBC", "UNTV", "Net 25", "SMNI",
            "Cinema One", "My Movie Channel", "Jack TV", "Balls", "Solar Sports"
        ],
        "Family Package": [
            "All Basic Plan Channels", "Cartoon Network", "Disney Channel", "Nickelodeon", "Boomerang",
            "Discovery Channel", "National Geographic", "Animal Planet", "History", "FOX",
            "HBO", "Fox Movies", "AXN", "ESPN", "Fox Sports"
        ],
        "Premium Experience": [
            "All Family Package Channels", "HBO HD", "Cinemax", "Fox Family Movies", "TNT",
            "NBA TV", "BeIN Sports", "Setanta Sports", "Food Network", "TLC",
            "MTV", "VH1", "E!", "Lifetime", "Crime & Investigation"
        ]
    };
    
    cablePlanButtons.forEach(button => {
        button.addEventListener('click', function() {
            const planName = this.getAttribute('data-plan-name');
            const planPrice = this.getAttribute('data-plan-price');
            const channels = cablePlansData[planName] || [];
            
            // Update modal content
            modalCablePlanName.textContent = planName;
            modalCablePlanPrice.innerHTML = planPrice + ' <span>/month</span>';
            channelsList.innerHTML = '';
            
            if (channels.length > 0) {
                channels.forEach(channel => {
                    const channelItem = document.createElement('div');
                    channelItem.className = 'channel-item';
                    channelItem.textContent = channel;
                    channelsList.appendChild(channelItem);
                });
            } else {
                const noChannels = document.createElement('div');
                noChannels.className = 'text-muted';
                noChannels.textContent = 'No channel information available.';
                channelsList.appendChild(noChannels);
            }
            
            // Show modal
            cableModal.show();
            
            // Move focus to the close button when modal is shown
            $('#cableChannelsModal').on('shown.bs.modal', function () {
                $(this).find('.btn-close').focus();
            });
        });
    });
    
    // Handle focus when modals are hidden
    $('#inclusionsModal, #cableChannelsModal').on('hidden.bs.modal', function () {
        // Return focus to the button that opened the modal
        $('.view-plan-btn:focus').focus();
    });
});
</script>

<style>
.channels-container {
    max-height: 300px;
    overflow-y: auto;
}

.channel-item {
    padding: 8px 12px;
    border-bottom: 1px solid #eee;
}

.channel-item:last-child {
    border-bottom: none;
}

#internet-plans .pricing-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 2rem;
    margin-top: 2rem;
}

#internet-plans .pricing-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 10px 25px rgba(0,0,0,0.34);
    text-align: center;
    flex: 1;
    min-width: 280px;
    max-width: 350px;
    position: relative;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

#internet-plans .pricing-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

#internet-plans .plan-badge {
    position: absolute;
    top: 10px;
    right: 20px;
    background: var(--primary);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

#internet-plans .pricing-card h3 {
    color: var(--dark);
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

#internet-plans .price {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 1.5rem;
}

#internet-plans .price span {
    font-size: 1rem;
    color: var(--gray);
    font-weight: 400;
}

#internet-plans .pricing-features {
    list-style: none;
    padding: 0;
    margin-bottom: 2rem;
}

#internet-plans .pricing-features li {
    padding: 0.5rem 0;
    color: var(--dark);
}

#internet-plans .pricing-features .text-muted {
    color: var(--gray) !important;
}

#internet-plans .cta-button {
    display: inline-block;
    background: var(--primary);
    color: white;
    padding: 12px 30px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

#internet-plans .cta-button:hover {
    background: var(--primary-light);
    transform: translateY(-2px);
}

#internet-plans .pricing-card.popular {
    border: 2px solid var(--primary);
    transform: scale(1.05);
}

#internet-plans .pricing-card.popular:hover {
    transform: scale(1.05) translateY(-5px);
}

@media (max-width: 768px) {
    #internet-plans .pricing-container {
        flex-direction: column;
        align-items: center;
    }
    
    #internet-plans .pricing-card {
        width: 100%;
        max-width: 100%;
    }
    
    #internet-plans .pricing-card.popular {
        transform: none;
    }
    
    #internet-plans .pricing-card.popular:hover {
        transform: translateY(-5px);
    }
}
</style>
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
           
            
            
        </div>
        <div class="image-indicators" id="imageIndicators">
            <div class="indicator active" data-index="0"></div>
            <div class="indicator" data-index="1"></div>
            <div class="indicator" data-index="2"></div>
            <div class="indicator" data-index="3"></div>
            <div class="indicator" data-index="4"></div>
            <div class="indicator" data-index="5"></div>
        </div>
        <div class="modal-actions">
            <button class="apply-btn">Apply Now</button>
            <button class="pay-btn">Pay Online</button>
        </div>
    </div>
</div>

<script src="scripts/light-modal.js"></script>

<script src="script.js"></script>



<script src="assets/js/gallery.js"></script>
</body>
</html>
