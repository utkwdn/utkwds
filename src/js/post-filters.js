document.addEventListener( 'change', function ( e ) {
	const select = e.target.closest( '.utkwds-post-filters-form select' );
	if ( ! select ) return;

	// Disable empty selects so they're left out of the query string
	// entirely, rather than submitting as an empty param.
	select.form.querySelectorAll( 'select' ).forEach( function ( field ) {
		field.disabled = ! field.value;
	} );

	select.form.submit();
} );
