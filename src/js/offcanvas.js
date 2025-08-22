const transitionDuration = 300;

let activeSidebar = null;
let lastTrigger = null;

function openSidebar(sidebar, trigger) {
  activeSidebar = sidebar;
  lastTrigger = trigger;

  const overlay = document.createElement('div');
  overlay.className = 'offcanvas-overlay';
  document.body.appendChild(overlay);

  overlay.addEventListener('click', closeSidebar);

  sidebar.classList.add('showing');
  overlay.classList.add('show');
  document.body.classList.add('no-scroll');

  setTimeout(() => {
    sidebar.classList.remove('showing');
    sidebar.classList.add('show');
  }, transitionDuration);

  trigger.setAttribute('aria-expanded', 'true');
  sidebar.setAttribute('aria-hidden', 'false');

  sidebar.focus();
}

function closeSidebar() {
  if (!activeSidebar) return;

  const overlay = document.querySelector('.offcanvas-overlay');
  document.body.removeChild(overlay);

  overlay.removeEventListener('click', closeSidebar);

  activeSidebar.classList.add('hiding');
  overlay.classList.remove('show');

  lastTrigger.setAttribute('aria-expanded', 'false');
  activeSidebar.setAttribute('aria-hidden', 'true');

  setTimeout(() => {
    document.body.classList.remove('no-scroll');
    activeSidebar.classList.remove('hiding');
    activeSidebar.classList.remove('show');
    
    activeSidebar = null;
    lastTrigger = null;

    lastTrigger.focus();
  }, transitionDuration);
}

document.querySelectorAll('[data-toggle="offcanvas"]').forEach((trigger) => {
  const targetId = trigger.getAttribute('data-target');
  const sidebar = document.querySelector(targetId);

  trigger.setAttribute('aria-expanded', 'false');

  trigger.addEventListener('click', () => openSidebar(sidebar, trigger));
});

document.querySelectorAll('.offcanvas .btn-close').forEach((btn) => {
  btn.addEventListener('click', closeSidebar);
});

document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape' || e.key === 'Esc') {
    if (activeSidebar) closeSidebar();
  }
});

document.addEventListener('keydown', (e) => {
  if (!activeSidebar || e.key !== 'Tab') return;

  const focusableEls = activeSidebar.querySelectorAll(
    'a, button, input, textarea, select, [tabindex]:not([tabindex="-1"])',
  );
  if (!focusableEls.length) return;

  const firstEl = focusableEls[0];
  const lastEl = focusableEls[focusableEls.length - 1];

  if (e.shiftKey && document.activeElement === firstEl) {
    e.preventDefault();
    lastEl.focus();
  } else if (!e.shiftKey && document.activeElement === lastEl) {
    e.preventDefault();
    firstEl.focus();
  }
});
