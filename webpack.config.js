// WordPress webpack config.
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

// Utilities.
const path = require( 'path' );

// Plugins.
const RemoveEmptyScriptsPlugin = require( 'webpack-remove-empty-scripts' );
const CopyPlugin = require( 'copy-webpack-plugin' );

// Filter out the default CopyPlugin so we can replace it with a merged one
const defaultPluginsWithoutCopy = defaultConfig.plugins.filter(
	( plugin ) => plugin.constructor.name !== 'CopyPlugin'
);

module.exports = {
	...defaultConfig,
	entry: {
		// Auto-detected block entries from block.json files
		...defaultConfig.entry(),

		// Custom JavaScript
		'js/block-variations': path.resolve(
			process.cwd(),
			'src/js',
			'block-variations.js'
		),
		'js/unregister': path.resolve(
			process.cwd(),
			'src/js',
			'unregister.js'
		),
		'js/utk': path.resolve( process.cwd(), 'src/js', 'utk.js' ),
		'js/search-slider': path.resolve(
			process.cwd(),
			'src/js',
			'search-slider.js'
		),
		'js/tabs': path.resolve( process.cwd(), 'src/js', 'tabs.js' ),
		'js/dropdowns': path.resolve( process.cwd(), 'src/js', 'dropdowns.js' ),
		'js/collapse': path.resolve( process.cwd(), 'src/js', 'collapse.js' ),
		'js/offcanvas': path.resolve( process.cwd(), 'src/js', 'offcanvas.js' ),

		// SCSS-only entries
		'editor-restrict': path.resolve(
			process.cwd(),
			'src/scss',
			'editor-restrict.scss'
		),
		screen: path.resolve( process.cwd(), 'src', 'screen.scss' ),
		editor: path.resolve( process.cwd(), 'src', 'editor-style.scss' ),
	},
	plugins: [
		...defaultPluginsWithoutCopy,
		new RemoveEmptyScriptsPlugin( {
			stage: RemoveEmptyScriptsPlugin.STAGE_AFTER_PROCESS_PLUGINS,
		} ),
		new CopyPlugin( {
			patterns: [
				// Default: copy block.json and PHP files to build
				{
					from: '**/block.json',
					context: 'src',
					noErrorOnMissing: true,
				},
				{ from: '**/*.php', context: 'src', noErrorOnMissing: true },
				// Your custom theme files
				{ from: 'src/screenshot.png' },
				{ from: 'src/readme.txt' },
				{ from: 'src/style.css' },
				{ from: 'src/theme.json' },
				{
					from: '**/*',
					context: 'src/assets',
					to: ( { context, absoluteFilename } ) => {
						const relativePath = path.relative(
							context,
							absoluteFilename
						);
						return path.join( 'assets', relativePath );
					},
				},
				{ from: 'src/parts', to: 'parts' },
				{ from: 'src/templates', to: 'templates' },
				{ from: 'src/tests', to: 'tests' },
			],
		} ),
	],
};
