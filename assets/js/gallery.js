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