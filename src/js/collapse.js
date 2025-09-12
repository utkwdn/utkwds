function toggleCollapse(toggle, target) {
  const isShown = target.classList.contains('show');

  if (isShown) {
    target.style.height = target.scrollHeight + 'px';
    target.classList.remove('collapse', 'show');
    target.classList.add('collapsing');

    requestAnimationFrame(() => {
      target.style.height = '0';
      toggle.setAttribute('aria-expanded', 'false');
    });

    target.addEventListener('transitionend', () => {
      target.classList.remove('collapsing');
      target.classList.add('collapse');
      target.style.height = null;
    }, { once: true });

  } else {
    target.classList.remove('collapse');
    target.classList.add('collapsing');
    target.style.height = '0';
    toggle.setAttribute('aria-expanded', 'true');

    requestAnimationFrame(() => {
      target.style.height = target.scrollHeight + 'px';
    });

    target.addEventListener('transitionend', () => {
      target.classList.remove('collapsing');
      target.classList.add('collapse', 'show');
      target.style.height = null;
    }, { once: true });
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