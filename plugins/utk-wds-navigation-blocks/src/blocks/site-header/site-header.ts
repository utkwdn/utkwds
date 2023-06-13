
const setupOffcanvas = () => {
    console.log('Site Header Script');

    const offcanvasContainer = document.getElementById('mobileMainNav');
    if (! offcanvasContainer) {
        console.warn('No offcanvas container found');
        return;
    }
    
    const offcanvasObject = bootstrap.Offcanvas.getOrCreateInstance(offcanvasContainer);
    
    if (! offcanvasObject) {
        console.warn('No offcanvas object retrieved from element');
        return;
    }

    const breakpointWidth = offcanvasContainer.getAttribute('data-max-breakpoint');

    if (! breakpointWidth) {
        return;
    }
    console.log(breakpointWidth);
    const breakpointWidthInt = parseInt(breakpointWidth);

    let resizeObserver = new ResizeObserver( (entries ) => {
        for (const entry of entries) {
            const width = entry.contentRect.width;
            console.log('Width:', entry.contentRect.width);

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