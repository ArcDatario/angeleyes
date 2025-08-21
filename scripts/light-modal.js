/**
 * Light Modal Interactivity Script
 * - Shows modal on every page load
 * - Allows image navigation (6 images)
 * - Handles close button
 * - Includes auto-scroll functionality (3 seconds per image)
 */

const modalOverlay = document.getElementById('lightModalOverlay');
const modalCloseBtn = document.getElementById('modalCloseBtn');
const modalImages = document.querySelectorAll('.modal-image');
const indicators = document.querySelectorAll('.indicator');

let currentImageIdx = 0;
let autoScrollInterval;

// Function to show a specific image
function showModalImage(idx) {
    // Hide all images
    modalImages.forEach(img => {
        img.classList.remove('active');
        img.style.opacity = 0;
    });
    
    // Show the selected image
    setTimeout(() => {
        modalImages[idx].classList.add('active');
        modalImages[idx].style.opacity = 1;
        
        // Update indicators
        indicators.forEach(indicator => indicator.classList.remove('active'));
        indicators[idx].classList.add('active');
        
        currentImageIdx = idx;
    }, 200);
}

// Function to start auto-scroll
function startAutoScroll() {
    // Clear any existing interval
    if (autoScrollInterval) {
        clearInterval(autoScrollInterval);
    }
    
    // Set new interval
    autoScrollInterval = setInterval(() => {
        currentImageIdx = (currentImageIdx + 1) % modalImages.length;
        showModalImage(currentImageIdx);
    }, 3000); // 3 seconds
}

// Function to stop auto-scroll
function stopAutoScroll() {
    if (autoScrollInterval) {
        clearInterval(autoScrollInterval);
    }
}


// Indicator click events
indicators.forEach(indicator => {
    indicator.addEventListener('click', () => {
        stopAutoScroll();
        const index = parseInt(indicator.getAttribute('data-index'));
        showModalImage(index);
        startAutoScroll(); // Restart auto-scroll after manual navigation
    });
});

// Close button event
modalCloseBtn.addEventListener('click', () => {
    stopAutoScroll();
    modalOverlay.style.display = 'none';
});

// Show modal on every page load
window.addEventListener('DOMContentLoaded', () => {
    modalOverlay.style.display = 'flex';
    showModalImage(currentImageIdx);
    startAutoScroll(); // Start auto-scroll when modal opens
});

// Optional: Close modal when clicking outside modal box
modalOverlay.addEventListener('click', (e) => {
    if (e.target === modalOverlay) {
        stopAutoScroll();
        modalOverlay.style.display = 'none';
    }
});

// Note: auto-scroll runs continuously every 3 seconds. If you prefer
// to pause on hover, re-enable mouseenter/mouseleave handlers here.