document.addEventListener( 'change', function ( e ) {
	const select = e.target.closest( '.utkwds-post-filters-form select' );
	if ( ! select ) return;

	// Changing the category invalidates any selected month, since a
	// month with posts in one category may have none in another.
	if ( select.name === 'post-category' ) {
		const monthSelect = select.form.querySelector( 'select[name="post-month"]' );
		if ( monthSelect ) {
			monthSelect.value = '';
		}
	}

	// Disable empty selects so they're left out of the query string
	// entirely, rather than submitting as an empty param.
	select.form.querySelectorAll( 'select' ).forEach( function ( field ) {
		field.disabled = ! field.value;
	} );

	select.form.submit();
} );
