/**
 * Reveals each Gradient Hero once it scrolls into view by adding
 * .is-visible, which style.scss uses to run the entrance transitions.
 */
const heroes = document.querySelectorAll(
	'.wp-block-utk-wds-hero-gradient[data-animate]'
);

const observer = new window.IntersectionObserver(
	( entries ) => {
		entries.forEach( ( entry ) => {
			if ( entry.isIntersecting ) {
				entry.target.classList.add( 'is-visible' );
				observer.unobserve( entry.target );
			}
		} );
	},
	{ threshold: 0.2 }
);

heroes.forEach( ( hero ) => observer.observe( hero ) );
