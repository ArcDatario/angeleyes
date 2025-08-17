const logo = document.getElementById('AngeleyesLogo');
  
  // Click animation
  logo.addEventListener('click', function() {
    this.style.animation = 'pulse 0.5s';
    setTimeout(() => {
      this.style.animation = '';
    }, 500);
  });
  
  // Follow mouse tilt effect
  logo.addEventListener('mousemove', (e) => {
    const rect = logo.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    const centerX = rect.width / 2;
    const centerY = rect.height / 2;
    const angleX = (y - centerY) / 10;
    const angleY = (centerX - x) / 10;
    
    logo.style.transform = `perspective(500px) rotateX(${angleX}deg) rotateY(${angleY}deg) translateY(-3px)`;
  });
  
  logo.addEventListener('mouseleave', () => {
    logo.style.transform = 'perspective(500px) rotateX(0) rotateY(0)';
  });