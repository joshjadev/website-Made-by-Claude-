/* ===========================
   JAMAICA WILD TOURS — MAIN JS
   =========================== */

document.addEventListener('DOMContentLoaded', function () {

  /* ---- NAV SCROLL EFFECT ---- */
  const nav = document.getElementById('main-nav');
  if (nav) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 60) {
        nav.style.background = 'rgba(11,26,18,0.98)';
      } else {
        nav.style.background = 'rgba(11,26,18,0.95)';
      }
    });
  }

  /* ---- MOBILE BURGER ---- */
  const burger = document.getElementById('nav-burger');
  const mobileMenu = document.getElementById('mobile-menu');
  if (burger && mobileMenu) {
    burger.addEventListener('click', () => {
      mobileMenu.classList.toggle('open');
      const spans = burger.querySelectorAll('span');
      if (mobileMenu.classList.contains('open')) {
        spans[0].style.transform = 'translateY(7px) rotate(45deg)';
        spans[1].style.opacity = '0';
        spans[2].style.transform = 'translateY(-7px) rotate(-45deg)';
      } else {
        spans[0].style.transform = '';
        spans[1].style.opacity = '';
        spans[2].style.transform = '';
      }
    });
  }

  /* ---- SMOOTH SCROLL FOR ANCHOR LINKS ---- */
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        const offset = 80;
        const top = target.getBoundingClientRect().top + window.scrollY - offset;
        window.scrollTo({ top, behavior: 'smooth' });
      }
    });
  });

  /* ---- TOUR CARD STAGGER ANIMATION ---- */
  const cards = document.querySelectorAll('.tour-card, .testi-card, .why-card');
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
          setTimeout(() => {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
          }, 80 * (entry.target.dataset.index || 0));
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    cards.forEach((card, i) => {
      card.style.opacity = '0';
      card.style.transform = 'translateY(24px)';
      card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
      card.dataset.index = i % 6;
      observer.observe(card);
    });
  }

  /* ---- PAYMENT OPTION RADIO STYLING ---- */
  document.querySelectorAll('.payment-option').forEach(opt => {
    opt.addEventListener('click', () => {
      document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('selected'));
      opt.classList.add('selected');
      const radio = opt.querySelector('input[type="radio"]');
      if (radio) radio.checked = true;
    });
  });

  /* ---- BOOKING FORM: SYNC GUEST COUNTS ---- */
  const guestsSelect = document.getElementById('guests');
  const adultsSelect = document.getElementById('adults');
  const childrenSelect = document.getElementById('children');

  function syncGuestCount() {
    if (!guestsSelect || !adultsSelect || !childrenSelect) return;
    const total = parseInt(guestsSelect.value) || 1;
    const adults = parseInt(adultsSelect.value) || 1;
    const children = parseInt(childrenSelect.value) || 0;
    if (adults + children > total) {
      childrenSelect.value = Math.max(0, total - adults);
    }
    if (typeof updateTotal === 'function') updateTotal();
  }

  if (guestsSelect) guestsSelect.addEventListener('change', syncGuestCount);
  if (adultsSelect) adultsSelect.addEventListener('change', syncGuestCount);
  if (childrenSelect) childrenSelect.addEventListener('change', syncGuestCount);

  /* ---- FORM VALIDATION FEEDBACK ---- */
  const bookingForm = document.getElementById('booking-form');
  if (bookingForm) {
    const inputs = bookingForm.querySelectorAll('input[required], select[required], textarea[required]');
    inputs.forEach(input => {
      input.addEventListener('blur', () => {
        validateField(input);
      });
      input.addEventListener('input', () => {
        if (input.dataset.invalid) validateField(input);
      });
    });

    function validateField(field) {
      const val = field.value.trim();
      let valid = true;
      if (field.type === 'email') {
        valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
      } else {
        valid = val.length > 0;
      }
      field.style.borderColor = valid ? 'var(--border)' : 'rgba(231,76,60,0.6)';
      field.dataset.invalid = valid ? '' : 'true';
    }
  }

  /* ---- MINI TOAST NOTIFICATION ---- */
  window.showToast = function (msg, type = 'success') {
    const toast = document.createElement('div');
    toast.style.cssText = `
      position:fixed;bottom:2rem;right:2rem;z-index:9999;
      background:${type === 'success' ? '#2ECC71' : '#E74C3C'};
      color:#fff;padding:0.85rem 1.5rem;border-radius:2rem;
      font-size:0.88rem;font-weight:500;font-family:'Outfit',sans-serif;
      box-shadow:0 4px 20px rgba(0,0,0,0.3);
      animation:slideInToast 0.3s ease;
    `;
    toast.textContent = msg;
    document.body.appendChild(toast);
    const style = document.createElement('style');
    style.textContent = '@keyframes slideInToast{from{transform:translateY(20px);opacity:0}to{transform:translateY(0);opacity:1}}';
    document.head.appendChild(style);
    setTimeout(() => toast.remove(), 3500);
  };

  /* ---- CATEGORY FILTER (tours page) ---- */
  const filterPills = document.querySelectorAll('.filter-pill');
  filterPills.forEach(pill => {
    pill.addEventListener('click', function () {
      filterPills.forEach(p => p.classList.remove('active'));
      this.classList.add('active');
    });
  });

  /* ---- DETAILS/ACCORDION ANIMATION ---- */
  document.querySelectorAll('details').forEach(detail => {
    detail.addEventListener('toggle', function () {
      if (this.open) {
        const content = this.querySelector('p');
        if (content) {
          content.style.animation = 'fadeSlideDown 0.25s ease';
        }
      }
    });
  });
  const style = document.createElement('style');
  style.textContent = '@keyframes fadeSlideDown{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}';
  document.head.appendChild(style);

  /* ---- HERO PARALLAX (subtle) ---- */
  const orbs = document.querySelectorAll('.floating-orb');
  if (orbs.length) {
    window.addEventListener('scroll', () => {
      const y = window.scrollY;
      orbs.forEach((orb, i) => {
        const speed = (i + 1) * 0.06;
        orb.style.transform = `translateY(${y * speed}px)`;
      });
    }, { passive: true });
  }

  /* ---- WHATSAPP FLOAT BUTTON ---- */
  const wa = document.createElement('a');
  wa.href = 'https://wa.me/18765550192?text=Hi%2C%20I%27d%20like%20to%20book%20a%20Jamaica%20Wild%20Tour!';
  wa.target = '_blank';
  wa.rel = 'noopener';
  wa.setAttribute('aria-label', 'Chat on WhatsApp');
  wa.style.cssText = `
    position:fixed;bottom:1.75rem;right:1.75rem;z-index:888;
    width:56px;height:56px;border-radius:50%;
    background:#25D366;color:#fff;
    display:flex;align-items:center;justify-content:center;
    font-size:1.5rem;box-shadow:0 4px 20px rgba(0,0,0,0.3);
    transition:transform 0.2s,box-shadow 0.2s;
    text-decoration:none;
  `;
  wa.textContent = '💬';
  wa.title = 'WhatsApp Us';
  wa.addEventListener('mouseenter', () => {
    wa.style.transform = 'scale(1.12)';
    wa.style.boxShadow = '0 6px 28px rgba(37,211,102,0.4)';
  });
  wa.addEventListener('mouseleave', () => {
    wa.style.transform = '';
    wa.style.boxShadow = '0 4px 20px rgba(0,0,0,0.3)';
  });
  document.body.appendChild(wa);

});
