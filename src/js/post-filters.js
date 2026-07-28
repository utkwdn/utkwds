document.addEventListener( 'change', function ( e ) {
	const select = e.target.closest( '.utkwds-post-filters-form select' );
	if ( ! select ) return;

	select.form.submit();
} );
