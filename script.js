  // Mobile Menu Toggle
  const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
  const navLinks = document.querySelector('.nav-links');
  
  mobileMenuBtn.addEventListener('click', () => {
      navLinks.classList.toggle('active');
      mobileMenuBtn.innerHTML = navLinks.classList.contains('active') ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
  });
  
  // Smooth scrolling for navigation links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
          e.preventDefault();
          
          if(this.getAttribute('href') === '#') return;
          
          const target = document.querySelector(this.getAttribute('href'));
          if(target) {
              window.scrollTo({
                  top: target.offsetTop - 80,
                  behavior: 'smooth'
              });
              
              // Close mobile menu if open
              if(navLinks.classList.contains('active')) {
                  navLinks.classList.remove('active');
                  mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
              }
          }
      });
  });
  
  // Navbar scroll effect
  const navbar = document.getElementById('navbar');
  window.addEventListener('scroll', () => {
      if(window.scrollY > 50) {
          navbar.classList.add('scrolled');
      } else {
          navbar.classList.remove('scrolled');
      }
  });
  
  // Municipality tabs functionality
  const municipalityTabs = document.querySelectorAll('.municipality-tab');
  const barangayLists = document.querySelectorAll('.barangay-list');
  
  municipalityTabs.forEach(tab => {
      tab.addEventListener('click', () => {
          // Remove active class from all tabs and lists
          municipalityTabs.forEach(t => t.classList.remove('active'));
          barangayLists.forEach(list => list.classList.remove('active'));
          
          // Add active class to clicked tab and corresponding list
          tab.classList.add('active');
          const target = tab.getAttribute('data-target');
          document.getElementById(target).classList.add('active');
      });
  });
  
  // FAQ accordion functionality
  const faqItems = document.querySelectorAll('.faq-item');
  
  faqItems.forEach(item => {
      const question = item.querySelector('.faq-question');
      
      question.addEventListener('click', () => {
          // Close all other items
          faqItems.forEach(otherItem => {
              if(otherItem !== item) {
                  otherItem.classList.remove('active');
              }
          });
          
          // Toggle current item
          item.classList.toggle('active');
      });
  });
  
  // Animation on scroll
  const animateOnScroll = () => {
      const elements = document.querySelectorAll('.mission-vision, .branch-card, .feature-card, .inquiry-card, .pricing-card');
      
      elements.forEach(element => {
          const elementPosition = element.getBoundingClientRect().top;
          const screenPosition = window.innerHeight / 1.2;
          
          if(elementPosition < screenPosition) {
              element.style.opacity = '1';
              element.style.transform = 'translateY(0)';
          }
      });
  };
  
  // Set initial state for animated elements
  document.querySelectorAll('.mission-vision, .branch-card, .feature-card, .inquiry-card, .pricing-card').forEach(el => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(20px)';
      el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
  });
  
  window.addEventListener('scroll', animateOnScroll);
  window.addEventListener('load', animateOnScroll);
  
  // Trigger hero animations
  window.addEventListener('load', () => {
      document.querySelector('.hero-title').style.opacity = '1';
      document.querySelector('.hero-subtitle').style.opacity = '1';
      document.querySelector('.hero-buttons').style.opacity = '1';
  });
