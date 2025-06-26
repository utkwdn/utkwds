function throttleTrailing(func, wait) {
  let timeout = null;
  let lastArgs = null;

  return function throttled(...args) {
    lastArgs = args;
    if (!timeout) {
      timeout = setTimeout(() => {
        timeout = null;
        func.apply(this, lastArgs);
        lastArgs = null;
      }, wait);
    }
  };
}

const tabses = document.querySelectorAll('.nav-tabs.main-tabs');
tabses.forEach(tabs => {
  // add wrappers around tabgroup

  const outerDiv = document.createElement('div');
  outerDiv.classList.add('tabgroup-outer-wrapper');

  const innerDiv = document.createElement('div');
  innerDiv.classList.add('tabgroup-inner-wrapper');

  outerDiv.appendChild(innerDiv);

  tabs.replaceWith(outerDiv);
  innerDiv.appendChild(tabs);

  // scroll to tab when it's selected (needed for the scrollable/overflow treatment)

  const mutationObserver = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      if (mutation.attributeName === 'aria-selected') {
        const tabButton = mutation.target;
        if (tabButton.getAttribute('aria-selected') === 'true') {
          // scroll it into view horizontally within the scrollable container
          tabButton.scrollIntoView({ behavior: 'smooth', inline: 'start', block: 'nearest' });
        }
      }
    });
  });

  const tabButtons = tabs.querySelectorAll('[role="tab"]');
  tabButtons.forEach(tabButton => {
    mutationObserver.observe(tabButton, { attributes: true, attributeFilter: ['aria-selected'] });
  });

  // hide/show the "shadows" that signal that the region is scrollable (on resize and on scroll)
  
  const resizeObserver = new ResizeObserver((entries) => {
    entries.forEach((entry) => {
      const { target } = entry;
      const { scrollWidth, clientWidth, scrollLeft, offsetWidth } = target;

      if (scrollWidth > clientWidth) {
        if (scrollLeft === 0) {
          outerDiv.classList.add('is-scrolled-left');
        } else {
          outerDiv.classList.remove('is-scrolled-left');
        }
        if (scrollLeft + offsetWidth >= scrollWidth - 1) {
          outerDiv.classList.add('is-scrolled-right');
        } else {
          outerDiv.classList.remove('is-scrolled-right');
        }
      } else {
        outerDiv.classList.add('is-scrolled-left', 'is-scrolled-right');
      }
    });
  });
  resizeObserver.observe(innerDiv);

  innerDiv.addEventListener('scroll', throttleTrailing(() => {
    const { scrollLeft, scrollWidth, offsetWidth } = innerDiv;

    if (scrollLeft === 0) {
      outerDiv.classList.add('is-scrolled-left');
    } else {
      outerDiv.classList.remove('is-scrolled-left');
    }

    if (scrollLeft + offsetWidth >= scrollWidth - 1) {
      outerDiv.classList.add('is-scrolled-right');
    } else {
      outerDiv.classList.remove('is-scrolled-right');
    }
  }, 100));

  // set border width for innerDiv based on width of tabs
  const resizeObserver2 = new ResizeObserver((entries) => {
    entries.forEach((entry) => {
      const { scrollWidth } = entry.target;
      innerDiv.style.setProperty('--tabgroup-width', `${scrollWidth}px`);
    });
  });
  resizeObserver2.observe(tabs);

  // prevent initial flash of scroll-shadow transition
  requestAnimationFrame(() => {
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        outerDiv.classList.add('is-ready');
      });
    });
  });
});