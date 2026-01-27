document.addEventListener( 'DOMContentLoaded', () => {
	const query = UTK_CSE.query;
	if ( ! query ) return; // No search executed yet

	const resultsContainer = document.getElementById(
		'utk-site-search-results'
	);
	const paginationContainer = document.getElementById(
		'utk-site-search-pagination'
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

		const totalResults =
			data.searchInformation.formattedTotalResults || '0';
		const searchTime = data.searchInformation.formattedSearchTime || '0';

		let html = `<div class="utk-search-information">About ${ totalResults } results (${ searchTime } seconds)</div>`;

		data.items.forEach( ( item ) => {
			const title = item.title;
			const snippet = item.htmlSnippet || '';
			const url = item.link;
			const linkText = item.displayLink;

			// Extract thumbnail
			let image = null;

			if ( item.pagemap?.cse_thumbnail?.[ 0 ]?.src ) {
				image = item.pagemap.cse_thumbnail[ 0 ].src;
			}

			html += `
				<div class="utk-search-item">

						<h5><a href="${ url }">${ title }</a></h5>
						<p>${ snippet }</p>
						<a href="${ url }">${ linkText }</a>

				</div>
			`;
		} );

		resultsContainer.innerHTML = html;

		renderPagination( data );
	}

	/**
	 * Render pagination links (Next, Previous)
	 */
	// function renderPagination( data ) {
	// 	let html = '';

	// 	if ( data.queries?.previousPage ) {
	// 		const prevStart = data.queries.previousPage[ 0 ].startIndex;
	// 		html += `<button data-start="${ prevStart }" class="page-btn">Previous</button>`;
	// 	}

	// 	if ( data.queries?.nextPage ) {
	// 		const nextStart = data.queries.nextPage[ 0 ].startIndex;
	// 		html += `<button data-start="${ nextStart }" class="page-btn">Next</button>`;
	// 	}

	// 	paginationContainer.innerHTML = html;

	// 	// Bind pagination events
	// 	document.querySelectorAll( '.page-btn' ).forEach( ( btn ) => {
	// 		btn.addEventListener( 'click', ( e ) => {
	// 			const start = e.target.getAttribute( 'data-start' );
	// 			fetchResults( start );
	// 		} );
	// 	} );
	// }
	/**
	 * Render pagination links (Previous, numbered pages, Next)
	 */
	function renderPagination( data ) {
		let html = '';

		const queries = data.queries;
		if ( ! queries?.request ) return;

		const request = queries.request[ 0 ];
		const startIndex = request.startIndex;
		const resultsPerPage = request.count;

		const totalResults = parseInt(
			data.searchInformation.totalResults,
			10
		);

		// Limit to 10 pages per API limits
		const totalPages = Math.min(
			10,
			Math.ceil( totalResults / resultsPerPage )
		);

		// Current page
		const currentPage =
			Math.floor( ( startIndex - 1 ) / resultsPerPage ) + 1;

		const maxPagesToShow = 5;
		const half = Math.floor( maxPagesToShow / 2 );

		let startPage = Math.max( 1, currentPage - half );
		let endPage = Math.min( totalPages, startPage + maxPagesToShow - 1 );

		// Re-adjust if we’re near the end
		startPage = Math.max( 1, endPage - maxPagesToShow + 1 );

		// Previous link
		if ( queries.previousPage ) {
			const prevStart = queries.previousPage[ 0 ].startIndex;
			html += `<a href="#" data-start="${ prevStart }" class="page-link prev">Previous</a>`;
		}

		// Numbered page links
		for ( let page = startPage; page <= endPage; page++ ) {
			html += pageLink( page, currentPage, resultsPerPage );
		}

		// Next link
		if ( queries.nextPage && currentPage < totalPages ) {
			const nextStart = queries.nextPage[ 0 ].startIndex;
			html += `<a href="#" data-start="${ nextStart }" class="page-link next">Next</a>`;
		}

		paginationContainer.innerHTML = html;

		// Bind pagination events
		paginationContainer
			.querySelectorAll( 'a.page-link' )
			.forEach( ( link ) => {
				link.addEventListener( 'click', ( e ) => {
					e.preventDefault();
					const start = e.currentTarget.getAttribute( 'data-start' );
					fetchResults( start );
				} );
			} );
	}

	/**
	 * Helper: build a single page link
	 */
	function pageLink( page, currentPage, resultsPerPage ) {
		const start = ( page - 1 ) * resultsPerPage + 1;

		if ( page === currentPage ) {
			return `<span class="page-link current">${ page }</span>`;
		}

		return `
		<a
			href="#"
			data-start="${ start }"
			class="page-link"
		>${ page }</a>
	`;
	}

	// Trigger first load
	fetchResults();
} );
