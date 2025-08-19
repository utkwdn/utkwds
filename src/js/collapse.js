function toggleCollapse(target) {
  const isShown = target.classList.contains('show');

  if (isShown) {
    const startHeight = target.scrollHeight;
    target.style.maxHeight = startHeight + 'px';
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        target.style.maxHeight = '0';
        target.classList.remove('show');
      });
    });

    target.addEventListener('transitionend', function handler() {
      target.style.maxHeight = null;
      target.removeEventListener('transitionend', handler);
    });

  } else {
    target.classList.add('show');
    target.style.maxHeight = '0';
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
  const toggleBtn = e.target.closest('[data-toggle="collapse"]');
  if (!toggleBtn) return;

  const selector = toggleBtn.getAttribute('data-target');
  const target = document.querySelector(selector);

  if (target) {
    toggleCollapse(target);
  }
});