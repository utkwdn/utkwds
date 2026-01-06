// ========================================================================================================================
// ===[ Control the focus .  ]=======================================================================================
// ========================================================================================================================

var myModalEl = document.getElementById( 'searchModal' );
myModalEl.addEventListener( 'shown.bs.modal', function ( event ) {
	var utksearch = document.querySelector( '#q' );
	utksearch.focus();
} );
var tabEl = document.getElementById( 'events-tab' );
tabEl.addEventListener( 'shown.bs.tab', function ( event ) {
	var utksearch2 = document.querySelector( '#q-events' );
	utksearch2.focus();
} );

var tabEl = document.getElementById( 'news-tab' );
tabEl.addEventListener( 'shown.bs.tab', function ( event ) {
	var utksearch3 = document.querySelector( '#q-news' );
	utksearch3.focus();
} );
var tabEl = document.getElementById( 'this-site-tab' );
tabEl.addEventListener( 'shown.bs.tab', function ( event ) {
	var utksearch4 = document.querySelector( '#q' );
	utksearch4.focus();
} );

// ========================================================================================================================
// ===[ Search CSE.                ]=======================================================================================
// ========================================================================================================================

function executeQuery( evt ) {
	evt.preventDefault();
	var input = document.getElementById( 'q' );
	var element1 = google.search.cse.element.getElement( 'this-site-results' );
	if ( input.value == '' ) {
		element1.clearAllResults();
	} else {
		element1.execute( input.value );
	}
	return false;
}

document
	.getElementById( 'cse-searchbox-form' )
	.addEventListener( 'submit', executeQuery );

function eventSearch( evt ) {
	evt.preventDefault();
	var input = document.getElementById( 'q-events' );
	var q_events = input.value;
	input.value = '';
	document.getElementById( 'q-news' ).value = '';
	document.getElementById( 'q' ).value = '';
	window.location.href =
		'https://calendar.utk.edu/search/events?search=' + q_events;
}

document
	.getElementById( 'events-searchbox-form' )
	.addEventListener( 'submit', eventSearch );

function newsSearch( evt ) {
	evt.preventDefault();
	var input = document.getElementById( 'q-news' );
	var q_news = input.value;
	input.value = '';
	document.getElementById( 'q-events' ).value = '';
	document.getElementById( 'q' ).value = '';
	window.location.href = 'https://news.utk.edu/?s=' + q_news;
}

document
	.getElementById( 'news-searchbox-form' )
	.addEventListener( 'submit', newsSearch );

var search_box = document.getElementById( 'searchModal' );

search_box.addEventListener( 'focusout', ( e ) => {
	const leavingSearch = ! search_box.contains( e.relatedTarget );

	if ( leavingSearch ) {
		document.getElementById( 'q' ).value = '';
		document.getElementById( 'q-events' ).value = '';
		document.getElementById( 'q-news' ).value = '';
	}
} );
