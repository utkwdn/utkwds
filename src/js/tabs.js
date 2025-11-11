function throttleTrailing( func, wait ) {
	let timeout = null;
	let lastArgs = null;

	return function throttled( ...args ) {
		lastArgs = args;
		if ( ! timeout ) {
			timeout = setTimeout( () => {
				timeout = null;
				func.apply( this, lastArgs );
				lastArgs = null;
			}, wait );
		}
	};
}

document.addEventListener( 'DOMContentLoaded', function () {
	const tabButtons = document.querySelectorAll( '[data-toggle="tab"]' );

	tabButtons.forEach( ( tab ) => {
		tab.addEventListener( 'click', () => {
			if ( tab.classList.contains( 'active' ) ) return;

			const tablist = tab.closest( '[role="tablist"]' );
			const tabsInList = tablist.querySelectorAll( '[role="tab"]' );
			const targetId = tab.getAttribute( 'aria-controls' );
			const targetPane = document.getElementById( targetId );

			// Deactivate other tabs
			tabsInList.forEach( ( t ) => {
				if ( t === tab ) return;
				t.classList.remove( 'active' );
				t.setAttribute( 'aria-selected', 'false' );
				t.setAttribute( 'tabindex', '-1' );

				const paneId = t.getAttribute( 'aria-controls' );
				const pane = document.getElementById( paneId );
				if ( pane && pane !== targetPane ) {
					pane.classList.remove( 'show' );
					pane.classList.remove( 'active' );
				}
			} );

			tab.classList.add( 'active' );
			tab.setAttribute( 'aria-selected', 'true' );
			tab.setAttribute( 'tabindex', '0' );

			if ( targetPane ) {
				targetPane.classList.add( 'active' );
				setTimeout( () => targetPane.classList.add( 'show' ), 150 );
			}
		} );

		tab.addEventListener( 'keydown', ( e ) => {
			const tablist = tab.closest( '[role="tablist"]' );
			const tabsInList = Array.from(
				tablist.querySelectorAll( '[role="tab"]' )
			);
			const currentIndex = tabsInList.indexOf( tab );

			let newIndex = null;

			switch ( e.key ) {
				case 'ArrowRight':
					newIndex = ( currentIndex + 1 ) % tabsInList.length;
					break;
				case 'ArrowLeft':
					newIndex =
						( currentIndex - 1 + tabsInList.length ) %
						tabsInList.length;
					break;
				case 'Home':
					newIndex = 0;
					break;
				case 'End':
					newIndex = tabsInList.length - 1;
					break;
			}

			if ( newIndex !== null ) {
				e.preventDefault();
				tabsInList[ newIndex ].focus();
			}
		} );
	} );
} );

const tabses = document.querySelectorAll( '.nav-tabs.main-tabs' );
tabses.forEach( ( tabs ) => {
	// add wrappers around tabgroup
	const outerDiv = document.createElement( 'div' );
	outerDiv.classList.add( 'tabgroup-outer-wrapper' );

	const innerDiv = document.createElement( 'div' );
	innerDiv.classList.add( 'tabgroup-inner-wrapper' );

	outerDiv.appendChild( innerDiv );

	tabs.replaceWith( outerDiv );
	innerDiv.appendChild( tabs );

	// scroll to tab when it's selected (needed for the scrollable/overflow treatment)
	const mutationObserver = new MutationObserver( ( mutations ) => {
		mutations.forEach( ( mutation ) => {
			if ( mutation.attributeName === 'aria-selected' ) {
				const tabButton = mutation.target;
				if ( tabButton.getAttribute( 'aria-selected' ) === 'true' ) {
					// scroll it into view horizontally within the scrollable container
					tabButton.scrollIntoView( {
						behavior: 'smooth',
						inline: 'start',
						block: 'nearest',
					} );
				}
			}
		} );
	} );

	const tabButtons = tabs.querySelectorAll( '[role="tab"]' );
	tabButtons.forEach( ( tabButton ) => {
		mutationObserver.observe( tabButton, {
			attributes: true,
			attributeFilter: [ 'aria-selected' ],
		} );
	} );

	// hide/show the "shadows" that signal that the region is scrollable (on resize and on scroll)
	const resizeObserver = new ResizeObserver( ( entries ) => {
		entries.forEach( ( entry ) => {
			const { target } = entry;
			const { scrollWidth, clientWidth, scrollLeft, offsetWidth } =
				target;

			if ( scrollWidth > clientWidth ) {
				if ( scrollLeft === 0 ) {
					outerDiv.classList.add( 'is-scrolled-left' );
				} else {
					outerDiv.classList.remove( 'is-scrolled-left' );
				}
				if ( scrollLeft + offsetWidth >= scrollWidth - 1 ) {
					outerDiv.classList.add( 'is-scrolled-right' );
				} else {
					outerDiv.classList.remove( 'is-scrolled-right' );
				}
			} else {
				outerDiv.classList.add(
					'is-scrolled-left',
					'is-scrolled-right'
				);
			}
		} );
	} );
	resizeObserver.observe( innerDiv );

	innerDiv.addEventListener(
		'scroll',
		throttleTrailing( () => {
			const { scrollLeft, scrollWidth, offsetWidth } = innerDiv;

			if ( scrollLeft === 0 ) {
				outerDiv.classList.add( 'is-scrolled-left' );
			} else {
				outerDiv.classList.remove( 'is-scrolled-left' );
			}

			if ( scrollLeft + offsetWidth >= scrollWidth - 1 ) {
				outerDiv.classList.add( 'is-scrolled-right' );
			} else {
				outerDiv.classList.remove( 'is-scrolled-right' );
			}
		}, 100 )
	);

	// set border width for innerDiv based on width of tabs
	const resizeObserver2 = new ResizeObserver( ( entries ) => {
		entries.forEach( ( entry ) => {
			const { scrollWidth } = entry.target;
			innerDiv.style.setProperty(
				'--tabgroup-width',
				`${ scrollWidth }px`
			);
		} );
	} );
	resizeObserver2.observe( tabs );

	// prevent initial flash of scroll-shadow transition
	requestAnimationFrame( () => {
		requestAnimationFrame( () => {
			requestAnimationFrame( () => {
				outerDiv.classList.add( 'is-ready' );
			} );
		} );
	} );
} );
