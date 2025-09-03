function toggleCollapse(toggle, target) {
  const isShown = target.classList.contains('show');

  if (isShown) {
    const startHeight = target.scrollHeight;
    target.style.maxHeight = startHeight + 'px';
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        target.style.maxHeight = '0';
        target.classList.remove('show');
        toggle.setAttribute('aria-expanded', 'false');
      });
    });

    target.addEventListener('transitionend', function handler() {
      target.style.maxHeight = null;
      target.removeEventListener('transitionend', handler);
    });

  } else {
    target.classList.add('show');
    target.style.maxHeight = '0';
    toggle.setAttribute('aria-expanded', 'true');
    requestAnimationFrame(() => {
      const endHeight = target.scrollHeight;
      target.style.maxHeight = endHeight + 'px';
    });

    target.addEventListener('transitionend', function handler() {
      target.removeEventListener('transitionend', handler);
    });
  }
}

document.addEventListener('click', function (e) {
  const toggle = e.target.closest('[data-toggle="collapse"]');
  if (!toggle) return;

  const selector = toggle.getAttribute('data-target');
  const target = document.querySelector(selector);

  if (target) {
    toggleCollapse(toggle, target);
  }
});