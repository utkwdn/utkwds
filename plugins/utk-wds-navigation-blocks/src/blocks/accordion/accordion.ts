const setUpAccordions = () => {
    const accordions = document.querySelectorAll('[data-accordion]');
    if (!accordions.length) return;
  
    type HTMLSectionElement = Omit<HTMLElement, 'tagName'> & {
      tagName: 'SECTION';
    };
  
    const isHTMLSectionElement = (el: HTMLElement): el is HTMLSectionElement =>
      el.tagName === 'SECTION';
  
    /*
      The main accordion mechanism here is loosely based on:
      - Bootstrap's `collapse.js`: https://github.com/twbs/bootstrap/blob/c3c65911665ab64bdaa15d405db65ee81655dbf3/js/src/collapse.js
      - https://css-tricks.com/using-css-transitions-auto-dimensions/
    */
  
    const HEIGHT_TRANSITION = 'height 400ms ease';
    /**
     * Presence of this class on a panel's `section` is used in the
     * `Panel` instance's `.isOpen()` method to determine whether the
     * `section` is open.
     * Gets added to the `section` when open-transition finishes.
     * Gets removed from the `section` just before close-transition starts.
     */
    const CLASS_NAME_IS_OPEN = 'is-open';
    const CLASS_NAME_IS_OPEN_POINTER_EVENTS_AUTO =
      /* tw */ '[&.is-open]:pointer-events-auto';
  
    class Panel {
      button: HTMLButtonElement;
  
      section: HTMLSectionElement;
  
      constructor(button: HTMLButtonElement, section: HTMLSectionElement) {
        this.button = button;
        this.section = section;
  
        this.section.style.transition = HEIGHT_TRANSITION;
  
        /*
          Just in case: if transition is canceled, remove section's `transitionend` listeners
          and set to closed state. This prevents the accordion from breaking if, say,
          a breakpoint is crossed that causes it to go `display: none` *in the middle of a transition*.
        */
        section.addEventListener(
          'transitioncancel',
          ({ target, currentTarget }) => {
            if (target !== currentTarget) return;
            section.removeEventListener(
              'transitionend',
              this._closeTransitionEnd
            );
            section.removeEventListener('transitionend', this._openTransitionEnd);
            this._closeImmediately();
          }
        );
      }
  
      /** Should run after open-transition. */
      _toOpenState() {
        this.isTransitioning = false;
        this.section.style.removeProperty('height');
        this.section.classList.add(CLASS_NAME_IS_OPEN);
  
        // undo making elements within section un-focusable (restoring original `tabindex` if applicable)
        this.section.querySelectorAll('*').forEach((el) => {
          if (!(el instanceof HTMLElement) && !(el instanceof SVGElement)) return;
          const { originalTabIndex } = el.dataset;
          if (originalTabIndex) {
            el.setAttribute('tabindex', originalTabIndex);
          } else {
            el.removeAttribute('tabindex');
          }
        });
  
        // scroll button into view if needed
        const { IntersectionObserver } = window;
        if (!IntersectionObserver) return;
        new IntersectionObserver(([entry], observer) => {
          // use 0.9 instead of 1 because of some Safari weirdness
          if (entry.intersectionRatio < 0.9) {
            this.button.scrollIntoView();
          }
          observer.disconnect();
        }).observe(this.button);
      }
  
      /** Should run after close-transition. */
      _toClosedState() {
        this.isTransitioning = false;
        this.section.setAttribute('aria-hidden', 'true');
      }
  
      /** For abruptly setting to closed-state. */
      _closeImmediately() {
        this.section.style.height = '0';
        this.section.classList.remove(CLASS_NAME_IS_OPEN);
        this.button.setAttribute('aria-expanded', 'false');
        this._toClosedState();
      }
  
      /**
       * Removes itself as a listener and calls `this._toOpenState()`.
       */
      _openTransitionEnd: EventListener = ({ target, currentTarget }) => {
        if (target !== currentTarget) return;
        this.section.removeEventListener(
          'transitionend',
          this._openTransitionEnd
        );
        this._toOpenState();
      };
  
      /**
       * Removes itself as a listener and calls `this._toClosedState()`.
       */
      _closeTransitionEnd: EventListener = ({ target, currentTarget }) => {
        if (target !== currentTarget) return;
        this.section.removeEventListener(
          'transitionend',
          this._closeTransitionEnd
        );
        this._toClosedState();
      };
  
      isTransitioning = false;
  
      isOpen() {
        return this.section.classList.contains(CLASS_NAME_IS_OPEN);
      }
  
      open() {
        if (this.isTransitioning || this.isOpen()) return;
  
        this.isTransitioning = true;
  
        this.section.addEventListener('transitionend', this._openTransitionEnd);
        this.section.setAttribute('aria-hidden', 'false');
        this.section.style.height = `${this.section.scrollHeight}px`;
        this.button.setAttribute('aria-expanded', 'true');
      }
  
      close() {
        if (this.isTransitioning || !this.isOpen()) return;
  
        this.isTransitioning = true;
  
        // prevent focus-within during transition
        this.section.querySelectorAll('*').forEach((el) => {
          if (!(el instanceof HTMLElement) && !(el instanceof SVGElement)) return;
          el.tabIndex = -1;
        });
        if (
          this.section.contains(document.activeElement) &&
          (document.activeElement instanceof HTMLElement ||
            document.activeElement instanceof SVGElement)
        ) {
          document.activeElement.blur();
        }
  
        const height = this.section.scrollHeight;
        this.section.classList.remove(CLASS_NAME_IS_OPEN);
        this.section.style.removeProperty('transition');
  
        requestAnimationFrame(() => {
          this.section.addEventListener(
            'transitionend',
            this._closeTransitionEnd
          );
          this.section.style.height = `${height}px`;
          this.section.style.transition = HEIGHT_TRANSITION;
  
          requestAnimationFrame(() => {
            this.section.style.height = '0';
            this.button.setAttribute('aria-expanded', 'false');
          });
        });
      }
  
      toggle() {
        if (this.isOpen()) {
          this.close();
        } else {
          this.open();
        }
      }
    }
  
    /** Increment each time we make a new panel, so that each panel's id will be unique. */
    let panelId = 1;
  
    for (const accordion of accordions) {
      if (!(accordion instanceof HTMLElement)) continue;
  
      /** If `true`, only one panel-section can be open at a time. */
      const closeOthersOnOpen = accordion.matches('[data-close-others-on-open]');
      /**
       * To keep track of whether more panels can be open on load,
       * in case `closeOthersOnOpen` is `true`.
       */
      let canOpenOnLoad = true;
  
      const panels: Panel[] = [];
  
      /*
        "Prepare" `panels` by setting up the markup and initial states,
        but don't add event-listeners yet (`panels` must be filled first).
      */
      for (const el of accordion.children) {
        if (!(el instanceof HTMLElement)) continue;
  
        const heading = el.querySelector('[data-accordion-heading]');
        const section = el.querySelector('[data-accordion-section]');
  
        if (!(heading instanceof HTMLHeadingElement)) {
          console.error(
            'A `[data-accordion-heading]` element is missing or is not an h-tag.'
          );
          continue;
        }
        if (!(section instanceof HTMLElement) || !isHTMLSectionElement(section)) {
          console.error(
            'A `[data-accordion-section]` element is missing or is not a `<section>`.'
          );
          continue;
        }
  
        // No more `continue`-ing allowed after this point (b/c of `canOpenOnLoad`)
  
        let open = false;
  
        const tryOpen = el.matches('[data-open]');
  
        if (tryOpen && canOpenOnLoad) {
          open = true;
          if (closeOthersOnOpen) {
            canOpenOnLoad = false;
          }
        }
  
        const buttonId = `accordion-button-${panelId}`;
        const sectionId = `accordion-contents-${panelId}`;
        panelId++;
  
        section.id = sectionId;
        section.setAttribute('aria-labelledby', buttonId);
        section.classList.add(
          /* tw */ 'aria-hidden:hidden',
          /* tw */ 'overflow-hidden',
          /* tw */ 'pointer-events-none',
          CLASS_NAME_IS_OPEN_POINTER_EVENTS_AUTO
        );
  
        // store original tabindex for each element in section that has one
        section.querySelectorAll('*').forEach((e) => {
          if (!(e instanceof HTMLElement) && !(e instanceof SVGElement)) return;
          const originalTabIndex = e.getAttribute('tabindex');
          if (originalTabIndex) {
            e.dataset.originalTabIndex = originalTabIndex;
          }
        });
  
        const button = document.createElement('button');
        button.id = buttonId;
        button.setAttribute('aria-controls', sectionId);
        button.textContent = heading.textContent;
        const { buttonClasses } = heading.dataset;
        if (buttonClasses) {
          button.className = buttonClasses;
        }
  
        heading.textContent = null;
        heading.appendChild(button);
  
        // set initial state
        if (open) {
          section.classList.add(CLASS_NAME_IS_OPEN);
          section.setAttribute('aria-hidden', 'false');
          button.setAttribute('aria-expanded', 'true');
        } else {
          section.style.height = '0';
          section.setAttribute('aria-hidden', 'true');
          button.setAttribute('aria-expanded', 'false');
        }
  
        panels.push(new Panel(button, section));
      }
  
      panels.forEach((panel) => {
        panel.button.addEventListener(
          'click',
          closeOthersOnOpen
            ? () => {
                if (panels.some(({ isTransitioning }) => isTransitioning)) return;
                if (panel.isOpen()) {
                  panel.close();
                } else {
                  panels.forEach((otherPanel) => {
                    if (panel !== otherPanel) {
                      otherPanel.close();
                    }
                  });
                  panel.open();
                }
              }
            : () => {
                panel.toggle();
              }
        );
      });
    }
  };
  
setUpAccordions();