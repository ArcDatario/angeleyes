<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANGELEYES - Fast & Reliable Fiber Internet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="angeleyes-logo.png">
    
    <link rel="stylesheet" href="styles.css">

    <link rel="stylesheet" href="styles/light-modal.css">
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
    height: 40px; /* Adjust as needed */
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
<section id="gallery">
    <h2 class="section-title">Our Work</h2>
    <p style="text-align: center; margin-bottom: 2rem; color: var(--gray);">See our actual installations and projects</p>
    
    <div class="scrollable-gallery">
        <div class="gallery-track">
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1597852074816-d933c7d2b988?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Network Installation">
                <div class="gallery-caption">Network Installation</div>
            </div>
            
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="CCTV Installation">
                <div class="gallery-caption">CCTV Installation</div>
            </div>
            
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Fire Alarm Setup">
                <div class="gallery-caption">Fire Alarm Setup</div>
            </div>
            
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1509391366360-2e959784a276?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1472&q=80" alt="Solar Panel Installation">
                <div class="gallery-caption">Solar Panel Installation</div>
            </div>
            
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Fiber Optic Setup">
                <div class="gallery-caption">Fiber Optic Setup</div>
            </div>
            
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Team at Work">
                <div class="gallery-caption">Team at Work</div>
            </div>
            
            <!-- Duplicate items for seamless looping -->
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1597852074816-d933c7d2b988?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Network Installation">
                <div class="gallery-caption">Network Installation</div>
            </div>
            
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="CCTV Installation">
                <div class="gallery-caption">CCTV Installation</div>
            </div>
            
            <div class="gallery-item">
               <img src="https://images.unsplash.com/photo-1581094271901-8022df4466f9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Fire Alarm Installation">
                <div class="gallery-caption">Fire Alarm Setup</div>
            </div>
        </div>
    </div>
</section>
<style>
    /* Gallery Section */
#gallery {
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.05) 0%, rgba(99, 102, 241, 0.02) 100%);
    padding-top: 3rem;
}

.scrollable-gallery {
    width: 100%;
    overflow-x: auto;
    overflow-y: hidden;
    white-space: nowrap;
    scroll-behavior: smooth;
    padding: 1rem 0;
    -webkit-overflow-scrolling: touch; /* For smooth scrolling on iOS */
}

.scrollable-gallery::-webkit-scrollbar {
    display: none; /* Hide scrollbar */
}

.gallery-track {
    display: inline-block;
    white-space: nowrap;
    animation: scroll 60s linear infinite;
}

.gallery-item {
    display: inline-block;
    position: relative;
    width: 300px;
    height: 350px;
    margin-right: 1.5rem;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    vertical-align: top;
}

.gallery-item:hover {
    transform: scale(1.05);
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.gallery-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 0.8rem;
    text-align: center;
    font-size: 0.9rem;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.gallery-item:hover .gallery-caption {
    transform: translateY(0);
}

@keyframes scroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}
.scrollable-gallery {
    -webkit-overflow-scrolling: touch;
    overscroll-behavior-x: contain;
    scroll-snap-type: x proximity;
}

.gallery-item {
    scroll-snap-align: start;
}

@media (max-width: 768px) {
    .scrollable-gallery {
        padding-bottom: 15px; /* Extra space for scroll */
    }
    
    .gallery-item {
        width: 280px; /* Slightly larger for touch */
        margin-right: 1rem;
    }
}
/* Pause animation when user interacts */
.scrollable-gallery:hover .gallery-track {
    animation-play-state: paused;
}

/* Responsive */
@media (max-width: 768px) {
    .gallery-item {
        width: 250px;
        height: 300px;
        margin-right: 1rem;
    }
}

@media (max-width: 576px) {
    .gallery-item {
        width: 250px;
        height: 300px;
        margin-right: 1rem;
    }
    
    .gallery-caption {
        font-size: 0.8rem;
        padding: 0.6rem;
    }
}
</style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const gallery = document.querySelector('.scrollable-gallery');
    const track = document.querySelector('.gallery-track');
    let autoScrollInterval;
    let isUserInteracting = false;
    let resumeTimeout;
    
    // Start auto-scroll with slower speed
    function startAutoScroll() {
        autoScrollInterval = setInterval(() => {
            if (!isUserInteracting) {
                // Slower scroll speed (0.5 pixels per frame instead of 1)
                gallery.scrollLeft += 0.5;
                
                // Loop back to start when halfway through
                if (gallery.scrollLeft >= track.scrollWidth / 2) {
                    gallery.scrollLeft = 0;
                }
            }
        }, 30); // Keep the interval timing but scroll less each frame
    }

    // Handle user interaction
    function handleUserInteraction() {
        isUserInteracting = true;
        clearInterval(autoScrollInterval);
        clearTimeout(resumeTimeout);
        
        // Resume auto-scroll after 5 seconds of inactivity (increased from 3)
        resumeTimeout = setTimeout(() => {
            isUserInteracting = false;
            startAutoScroll();
        }, 5000);
    }

    // Event listeners for all devices
    gallery.addEventListener('scroll', handleUserInteraction);
    gallery.addEventListener('touchstart', handleUserInteraction, { passive: true });
    gallery.addEventListener('touchend', () => {
        // Only resume if no further interaction within timeout
        resumeTimeout = setTimeout(() => {
            isUserInteracting = false;
            startAutoScroll();
        }, 5000);
    }, { passive: true });
    
    gallery.addEventListener('mousedown', handleUserInteraction);
    gallery.addEventListener('mouseup', () => {
        resumeTimeout = setTimeout(() => {
            isUserInteracting = false;
            startAutoScroll();
        }, 5000);
    });

    // Initialize
    startAutoScroll();
    
    // Clone items for seamless looping
    const items = document.querySelectorAll('.gallery-item');
    items.forEach(item => {
        track.appendChild(item.cloneNode(true));
    });
});
    </script>
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
    <section id="branches">
        <h2 class="section-title">Our Branches</h2>
        
        <div class="branches-container">
            <div class="branch-card">
                <div class="branch-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h3>Macabebe Branch</h3>
                <p>Main Office</p>
                <p>PADECO Bldg.,137</p>
                <p>Macabebe, Pampanga</p>
                <p>Monday to Saturday</p>
                <p>8am to 5pm</p>
            </div>
            
            <div class="branch-card">
                <div class="branch-icon">
                    <i class="fas fa-store"></i>
                </div>
                <h3>Sto. Tomas Branch</h3>
                <p>33 Municipal Road</p>
                <p>Santo Tomas</p>
                <p>Pampanga</p>
                <p>Monday to Saturday</p>
                <p>8am to 5pm</p>
            </div>
            
            <div class="branch-card">
                <div class="branch-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Apalit Branch</h3>
                <p>461 Centro Dos</p>
                <p>Colgante, Apalit</p>
                <p>Pampanga 2016</p>
                <p>Monday to Saturday</p>
                <p>8am to 5pm</p>
            </div>
            
            <div class="branch-card">
                <div class="branch-icon">
                    <i class="fas fa-home"></i>
                </div>
                <h3>Masantol Branch</h3>
                <p>2 Kalsadang Bayu</p>
                <p>Masantol</p>
                <p>Pampanga</p>
                <p>Monday to Saturday</p>
                <p>8am to 5pm</p>
            </div>
        </div>
    </section>
    
    <!-- Coverage Section -->
    <section id="coverage">
        <h2 class="section-title">FTTH Internet Coverage</h2>
        <p style="text-align: center; margin-bottom: 2rem; color: var(--gray);">Now available in these municipalities:</p>
        
        <div class="coverage-container">
            <div class="municipality-tabs">
                <div class="municipality-tab active" data-target="macabebe">Macabebe</div>
                <div class="municipality-tab" data-target="apalit">Apalit</div>
                <div class="municipality-tab" data-target="minalin">Minalin</div>
                <div class="municipality-tab" data-target="san-simon">San Simon</div>
                <div class="municipality-tab" data-target="sto-tomas">Sto. Tomas</div>
                <div class="municipality-tab" data-target="masantol">Masantol</div>
            </div>
            
            <div class="barangay-list active" id="macabebe">
                <div class="barangay-item">San Gabriel</div>
                <div class="barangay-item">San Esteban</div>
                <div class="barangay-item">San Rafael</div>
                <div class="barangay-item">San Vicente</div>
                <div class="barangay-item">Santo Rosario</div>
                <div class="barangay-item">Santo Niño</div>
            </div>
            
            <div class="barangay-list" id="apalit">
                <div class="barangay-item">Balucuc</div>
                <div class="barangay-item">Calantipe</div>
                <div class="barangay-item">Cansinala</div>
                <div class="barangay-item">Capalangan</div>
                <div class="barangay-item">Colgante</div>
                <div class="barangay-item">Paligui</div>
            </div>
            
            <div class="barangay-list" id="minalin">
                <div class="barangay-item">Bulanon</div>
                <div class="barangay-item">Dawe</div>
                <div class="barangay-item">Lourdes</div>
                <div class="barangay-item">Manianeg</div>
                <div class="barangay-item">San Francisco</div>
                <div class="barangay-item">Santo Domingo</div>
            </div>
            
            <div class="barangay-list" id="san-simon">
                <div class="barangay-item">San Juan</div>
                <div class="barangay-item">San Agustin</div>
                <div class="barangay-item">San Miguel</div>
                <div class="barangay-item">San Pablo</div>
                <div class="barangay-item">San Pedro</div>
                <div class="barangay-item">Santa Cruz</div>
            </div>
            
            <div class="barangay-list" id="sto-tomas">
                <div class="barangay-item">Moras de la Paz</div>
                <div class="barangay-item">Poblacion</div>
                <div class="barangay-item">San Bartolome</div>
                <div class="barangay-item">San Matias</div>
                <div class="barangay-item">San Vicente</div>
                <div class="barangay-item">Santo Rosario</div>
            </div>
            
            <div class="barangay-list" id="masantol">
                <div class="barangay-item">Balanac</div>
                <div class="barangay-item">Bebe Anac</div>
                <div class="barangay-item">Bebe Matua</div>
                <div class="barangay-item">Bulacus</div>
                <div class="barangay-item">Caingin</div>
                <div class="barangay-item">Palimpe</div>
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
    <section id="inquiry">
        <h2 class="section-title">Questions? Inquiries?</h2>
        <p style="text-align: center; margin-bottom: 2rem; color: var(--gray);">Feel free to contact us now. Our customer support is available 24/7.</p>
        
        <div class="inquiry-container">
            <div class="inquiry-card">
                <div class="inquiry-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <h3>Contact Us Now</h3>
                <p>Call our hotline for immediate assistance with your inquiries and technical support needs—our team is ready to help you anytime.</p>
                <a href="#" class="secondary-button" >Call Now</a>
            </div>
            
            <div class="inquiry-card">
                <div class="inquiry-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h3>Inquire</h3>
                <p>Visit us in one of our offices in Sto. Rosario, Sto. Tomas, or Apalit to learn more about our offers and inquire about our services.</p>
                <a href="#branches" class="secondary-button">View Branches</a>
            </div>
            
            <div class="inquiry-card">
                <div class="inquiry-icon">
                    <i class="fas fa-wifi"></i>
                </div>
                <h3>Install</h3>
                <p>Wait for the installation team to come to your home to provide you with our modem/router and have your internet connection activated.</p>
                <a href="#pricing" class="secondary-button">View Plans</a>
            </div>
            
            <div class="inquiry-card">
                <div class="inquiry-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3>Test & Enjoy</h3>
                <p>After activating your account, test your internet speed at speedtest.net and enjoy our fast, reliable, and secure connection.</p>
                <a href="https://www.speedtest.net/" target="_blank" class="secondary-button">Test Speed</a>
            </div>
        </div>
    </section>
    
    <!-- Pricing Section -->
    <section id="pricing">
        <h2 class="section-title">Pricing</h2>
        <p style="text-align: center; margin-bottom: 2rem; color: var(--gray);">Pick the best plan for you.</p>
        
        <div class="pricing-container">
            <div class="pricing-card">
                <h3>PLAN 999</h3>
                <div class="price">₱999 <span>/month</span></div>
                <ul class="pricing-features">
                    <li>Up to *100 Mbps</li>
                    <li>NO DATA CAP</li>
                    <li>24/7 Customer Support</li>
                </ul>
                <a href="#inquiry" class="cta-button">Subscribe Now</a>
            </div>
            
            <div class="pricing-card popular">
                <h3>PLAN 1500</h3>
                <div class="price">₱1,500 <span>/month</span></div>
                <ul class="pricing-features">
                    <li>Up to *300 Mbps</li>
                    <li>NO DATA CAP</li>
                    <li>24/7 Customer Support</li>
                </ul>
                <a href="#inquiry" class="cta-button">Subscribe Now</a>
            </div>
            
            <div class="pricing-card">
                <h3>PLAN 2500</h3>
                <div class="price">₱2,500 <span>/month</span></div>
                <ul class="pricing-features">
                    <li>Up to *400 Mbps</li>
                    <li>NO DATA CAP</li>
                    <li>24/7 Customer Support</li>
                </ul>
                <a href="#inquiry" class="cta-button">Subscribe Now</a>
            </div>
            
            <div class="pricing-card">
                <h3>PLAN 3500</h3>
                <div class="price">₱3,500 <span>/month</span></div>
                <ul class="pricing-features">
                    <li>Up to *500 Mbps</li>
                    <li>NO DATA CAP</li>
                    <li>24/7 Customer Support</li>
                </ul>
                <a href="#inquiry" class="cta-button">Subscribe Now</a>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section id="faq">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <p style="text-align: center; margin-bottom: 2rem; color: var(--gray);">Questions and Answers.</p>
        
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question">
                    <span>What are your covered and available areas?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>We currently cover Macabebe, Apalit, Minalin, San Simon, Sto. Tomas, and Masantol. You can check our coverage section for specific barangays in each municipality.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you have payment centers?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes, we have payment centers in all our branch locations. You can also pay through online banking and other digital payment platforms.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>What are the requirements for residential applications?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>You'll need a valid government ID, proof of billing address, and completed application form. Our representatives can guide you through the process when you visit any of our branches.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>How long do we wait for the installation?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Standard installation is scheduled within 3-5 business days after payment confirmation. We also offer same-day installation for urgent requirements (additional fees may apply).</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>What are the plans offered for residential applications?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>We offer four main residential plans: 100Mbps (₱999), 300Mbps (₱1,500), 400Mbps (₱2,500), and 500Mbps (₱3,500). All plans come with unlimited data and 24/7 support.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>What if I need the Internet connection the same day I signed up and settled payment? Can it be installed that same day as an urgent requirement?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes, we offer expedited installation for urgent requirements, subject to technician availability and with an additional service fee. Please inform our staff when you sign up.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>What if I am not satisfied with your service and I want to cut it as soon as possible. Do I need to pay the remaining months?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>If you're within the 30-day satisfaction guarantee period, you can cancel without penalty. After that, standard contract terms apply. Please contact our customer service for specific details about your situation.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>What is the maximum number of gadgets per plan?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>There's no hard limit on the number of devices, but performance may vary based on simultaneous usage. Our routers can typically handle 20+ devices comfortably, with higher-tier plans better suited for heavy multi-device households.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>What if I subscribe the speed of 50mbps, can I downgrade it afterwards?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes, you can upgrade or downgrade your plan after your initial contract period (usually 12 months) without penalty. Plan changes may be subject to a minimal service fee.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you have cable TV?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Currently, we specialize in internet services only. However, our high-speed connections are perfect for streaming your favorite shows and movies through online platforms.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>What are your office hours?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>All our branches are open Monday to Saturday, 8am to 5pm. Our customer support hotline operates 24/7 for technical assistance.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>What are the options for online payment?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>We accept payments through GCash, Maya, online banking transfers, and credit/debit cards. Payment links are sent via email or SMS for your convenience.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>What is the modem user access credentials?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Default credentials are provided during installation. For security, we recommend changing these immediately. Our technicians can assist you with this setup.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>How much is the installation fee?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Standard installation fee is ₱1,500, which includes the modem/router and initial setup. Promotions may waive this fee - please check our current offers.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you have a contract? If yes, how many months?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>We have a 12-month service agreement for residential customers. Early termination fees apply if canceled before the contract ends, with some exceptions.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you send billing statements?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes, we send monthly billing statements via email. You can also access your billing history through our customer portal.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>After the contract, is there something we can receive? Like freebies?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Loyal customers often receive special offers, including free speed boosts, service upgrades, or promotional discounts. Check with our customer service for current loyalty rewards.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Where is your office located?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Our main office is in Macabebe, with branches in Sto. Tomas, Apalit, and Masantol. Please see our Branches section for complete addresses and contact details.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>How can we get in touch with your customer service?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>You can call our 24/7 hotline, visit any of our branches during office hours, or message us through our official social media pages. Contact details are available in the footer of this website.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-column">
                <h3>ANGELEYES</h3>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#branches">Branches</a></li>
                    <li><a href="#coverage">Coverage</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Services</h3>
                <ul>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#inquiry">Contact Us</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Legal</h3>
                <ul>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Acceptable Use Policy</a></li>
                    <li><a href="#">Service Agreement</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Contact Info</h3>
                <ul>
                    <li><i class="fas fa-phone-alt"></i> (045) 123-4567</li>
                    <li><i class="fas fa-envelope"></i> support@angeleyes.com</li>
                    <li><i class="fas fa-map-marker-alt"></i> ANGELEYES Bldg.,137 Macabebe, Pampanga</li>
                </ul>
            </div>
        </div>
        
        <div class="social-links">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
        
        <p class="copyright">© 2023 ANGELEYES. All Rights Reserved.</p>
    </footer>
    <!-- Modal Overlay and Modal -->
<div class="modal-overlay" id="lightModalOverlay">
    <div class="light-modal" id="lightModal">
      <button class="modal-close" id="modalCloseBtn" aria-label="Close">&times;</button>
      <div class="modal-image-container">
        <button class="modal-nav-btn left" id="modalPrevBtn" aria-label="Previous">&#8592;</button>
        <img id="modalImage" src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80" alt="Modal Image" />
        <button class="modal-nav-btn right" id="modalNextBtn" aria-label="Next">&#8594;</button>
      </div>
      <div class="modal-actions">
        <button class="apply-btn">Apply Now</button>
        <button class="pay-btn">Pay Online</button>

        <script>
            
// Ensure the DOM is loaded before attaching the event
document.addEventListener('DOMContentLoaded', function() {
    const payBtn = document.querySelector('.pay-btn');
    if (payBtn) {
        payBtn.addEventListener('click', function() {
            window.open('payment.php', '_blank');
        });
    }
});

        </script>
      </div>
    </div>
  </div>

<script src="scripts/light-modal.js"></script>

<script src="script.js"></script>
</body>
</html>
