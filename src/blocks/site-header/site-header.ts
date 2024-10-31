
const setupOffcanvas = () => {
    const offcanvasContainer = document.getElementById('mobileMainNav');
    if (! offcanvasContainer) {
        return;
    }

    // check for desktop safari browser
    const userAgent = navigator.userAgent;
    const isSafari = /^((?!chrome|android).)*safari/i.test(userAgent);
    const isDesktop = !/Mobi|Android/i.test(userAgent);

    if (isSafari && isDesktop) {
        offcanvasContainer.dataset.bsScroll = "true";
    }
    
    const offcanvasObject = bootstrap.Offcanvas.getOrCreateInstance(offcanvasContainer);
    
    if (! offcanvasObject) {
        return;
    }

    const breakpointWidth = offcanvasContainer.getAttribute('data-max-breakpoint');

    if (! breakpointWidth) {
        return;
    }
    const breakpointWidthInt = parseInt(breakpointWidth);

    let resizeObserver = new ResizeObserver( (entries ) => {
        for (const entry of entries) {
            const width = entry.contentRect.width;

            if (width <= breakpointWidthInt) {
                return;
            }

            offcanvasObject.hide();
        }
    });

    resizeObserver.observe(document.body);
}

document.addEventListener('DOMContentLoaded', function() {
    setupOffcanvas();
 });