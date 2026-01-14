/**
 * Set: PERCY_BRANCH=prd percy exec -- node snapshots.js
 * Compare: PERCY_BRANCH=dev PERCY_TARGET_BRANCH=prd percy exec -- node snapshots.js
 */

const fs = require( 'fs' );
const path = require( 'path' );
const puppeteer = require( 'puppeteer' );
const percySnapshot = require( '@percy/puppeteer' );

( async () => {
	// Create a new browser instance
	const browser = await puppeteer.launch( {
		headless: true,
		args: [ '--no-sandbox', '--disable-setuid-sandbox' ],
	} );
	const page = await browser.newPage();
	await page.setViewport( { width: 1080, height: 1024 } );

	const PERCY_BRANCH = process.env.PERCY_BRANCH;
	let BASE_URL = '';

	switch ( PERCY_BRANCH ) {
		case 'prd':
			BASE_URL = 'https://wds-prd.utk.edu';
			break;
		case 'stg':
			BASE_URL = 'https://wds-stg.utk.edu';
			break;
		case 'dev':
			BASE_URL = 'https://wds-dev.utk.edu';
			break;
		default:
			console.error(
				'Please set the PERCY_BRANCH environment variable to either dev, stg, or prd'
			);
			process.exit( 1 );
	}

	// Define the path to your JSON file.
	const jsonFilePath = '/var/www/html/exported_pages.json';
	fs.readFile( jsonFilePath, 'utf8', async ( err, data ) => {
		if ( err ) {
			console.error( `Error reading file ${ jsonFilePath }:`, err );
			return;
		}

		let jsonData;
		try {
			jsonData = JSON.parse( data );
		} catch ( parseError ) {
			console.error(
				`Error parsing JSON data from ${ jsonFilePath }:`,
				parseError
			);
			return;
		}

		if ( ! Array.isArray( jsonData ) ) {
			console.error( 'Expected JSON data to be an array.' );
			return;
		}

		for ( const item of jsonData ) {
			// limit testing to first 5 for speed
			// if (jsonData.indexOf(item) >= 5) {
			//   break;
			// }
			if ( item.url ) {
				console.log( `Processing URL: ${ item.url }` );
				let uri = item.url.replace( /^https?:\/\/[^\/]+/i, '' );
				// let url = `${BASE_URL}${uri}`;
				let url = item.url;
				console.log( `Navigating to ${ url }` );
				try {
					await page.goto( url, {
						waitUntil: 'networkidle0',
						timeout: 60000,
					} );
					await percySnapshot( page, uri );
				} catch ( error ) {
					console.error(
						'An error occurred while taking snapshots:',
						error
					);
				}
			} else {
				console.warn( 'No "url" property found in item:', item );
			}
		}

		// It's important to close the browser only after processing all snapshots.
		await browser.close();
	} );
} )();
