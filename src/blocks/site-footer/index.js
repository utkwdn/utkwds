/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './style.scss';

/**
 * Internal dependencies
 */
import { Edit, Save, SaveV1 } from './edit';
import metadata from './block.json';

/**
 * Deprecations let previously-saved block markup keep validating after the
 * save() output changes. This covers the only shape that's actually live
 * on any site today: panelLinks as an editable attribute rendered into a
 * flat <div>, no <nav> landmark, no <ul>/<li>. panelLinks is no longer a
 * live attribute (the universal links are now hardcoded in UniversalLinks,
 * not editable), so this entry carries its own attributes definition
 * rather than reusing metadata.attributes.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-deprecation/
 */
const deprecated = [
	{
		attributes: {
			...metadata.attributes,
			panelLinks: { type: 'string' },
		},
		save: SaveV1,
	},
];

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( metadata.name, {
	/**
	 * @see ./edit.js
	 */
	edit: Edit,
	save: Save,
	deprecated,
} );
