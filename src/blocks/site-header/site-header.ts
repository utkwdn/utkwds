
const setupOffcanvas = () => {
    const offcanvasContainer = document.getElementById('mobileMainNav');
    if (! offcanvasContainer) {
        return;
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