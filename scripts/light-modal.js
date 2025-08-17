/**
 * Light Modal Interactivity Script
 * - Shows modal on every page load
 * - Allows image navigation (5 images)
 * - Handles close button
 */

const modalOverlay = document.getElementById('lightModalOverlay');
const modalCloseBtn = document.getElementById('modalCloseBtn');
const modalImage = document.getElementById('modalImage');
const modalPrevBtn = document.getElementById('modalPrevBtn');
const modalNextBtn = document.getElementById('modalNextBtn');

// 5 Unsplash images (royalty-free)
const modalImages = [
  "https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80",
  "https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=600&q=80",
  "https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=600&q=80",
  "https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=600&q=80",
  "https://images.unsplash.com/photo-1465101178521-c1a9136a3b99?auto=format&fit=crop&w=600&q=80"
];

let currentImageIdx = 0;

function showModalImage(idx) {
  modalImage.style.opacity = 0;
  setTimeout(() => {
    modalImage.src = modalImages[idx];
    modalImage.style.opacity = 1;
  }, 200);
}

modalPrevBtn.addEventListener('click', () => {
  currentImageIdx = (currentImageIdx - 1 + modalImages.length) % modalImages.length;
  showModalImage(currentImageIdx);
});

modalNextBtn.addEventListener('click', () => {
  currentImageIdx = (currentImageIdx + 1) % modalImages.length;
  showModalImage(currentImageIdx);
});

modalCloseBtn.addEventListener('click', () => {
  modalOverlay.style.display = 'none';
});

// Show modal on every page load
window.addEventListener('DOMContentLoaded', () => {
  modalOverlay.style.display = 'flex';
  showModalImage(currentImageIdx);
});

// Optional: Close modal when clicking outside modal box
modalOverlay.addEventListener('click', (e) => {
  if (e.target === modalOverlay) {
    modalOverlay.style.display = 'none';
  }
});
