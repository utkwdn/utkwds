document.addEventListener( 'DOMContentLoaded', () => {
	const query = UTK_CSE.query;
	if ( ! query ) return; // No search executed yet

	const resultsContainer = document.getElementById( 'utk-search-results' );
	const paginationContainer = document.getElementById(
		'utk-search-pagination'
	);

	/**
	 * Fetch results from Google CSE API.
	 */
	function fetchResults( startIndex = 1 ) {
		const url = `${ UTK_CSE.endpoint }?key=${ UTK_CSE.apiKey }&cx=${
			UTK_CSE.cx
		}&q=${ encodeURIComponent( query ) }&start=${ startIndex }`;

		resultsContainer.innerHTML = `<p>Loading…</p>`;
		paginationContainer.innerHTML = '';

		fetch( url )
			.then( ( res ) => res.json() )
			.then( renderResults )
			.catch( ( err ) => {
				resultsContainer.innerHTML = `<p>Error loading results.</p>`;
				console.error( err );
			} );
	}

	/**
	 * Render search results and pagination.
	 */
	function renderResults( data ) {
		if ( ! data.items || data.items.length === 0 ) {
			resultsContainer.innerHTML = `<p>No results found.</p>`;
			return;
		}

		let html = '';

		data.items.forEach( ( item ) => {
			const title = item.title;
			const snippet = item.snippet || '';
			const url = item.link;
			const linkText = item.displayLink;

			// Extract thumbnail
			let image = null;

			if ( item.pagemap?.cse_thumbnail?.[ 0 ]?.src ) {
				image = item.pagemap.cse_thumbnail[ 0 ].src;
			}

			html += `
				<div class="utk-search-item">
					<div class="content" style="margin-bottom:1em;">
						<h5 style="margin: 0 0 10px 0;"><a href="${ url }">${ title }</a></h5>
						<div class="image-and-snippet" style="display:flex;">
							${
								image
									? `<div class="thumb" style="margin-right:10px;"><img style="width:150px;" src="${ image }" alt=""></div>`
									: ''
							}
							<div class="snippet">
								<p style="margin: 0;">${ snippet }</p>
								<a href="${ url }">${ linkText }</a>
							</div>
						</div>
					</div>
				</div>
			`;
		} );

		resultsContainer.innerHTML = html;

		renderPagination( data );
	}

	/**
	 * Render pagination links (Next, Previous)
	 */
	function renderPagination( data ) {
		let html = '';

		if ( data.queries?.previousPage ) {
			const prevStart = data.queries.previousPage[ 0 ].startIndex;
			html += `<button data-start="${ prevStart }" class="page-btn">Previous</button>`;
		}

		if ( data.queries?.nextPage ) {
			const nextStart = data.queries.nextPage[ 0 ].startIndex;
			html += `<button data-start="${ nextStart }" class="page-btn">Next</button>`;
		}

		paginationContainer.innerHTML = html;

		// Bind pagination events
		document.querySelectorAll( '.page-btn' ).forEach( ( btn ) => {
			btn.addEventListener( 'click', ( e ) => {
				const start = e.target.getAttribute( 'data-start' );
				fetchResults( start );
			} );
		} );
	}

	// Trigger first load
	fetchResults();
} );
