/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
	useBlockProps,
	RichText,
	InnerBlocks,
	InspectorControls,
	ColorPalette,
} from '@wordpress/block-editor';

import { Placeholder, TextControl } from '@wordpress/components';

import type {TemplateArray, BlockEditProps, BlockSaveProps, Block} from 'wordpress__blocks';
import type {WPElement} from '@wordpress/element';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

type HeadingLevel = '2' | '3';
type HeadingTag = 'h2' | 'h3';
const getTagName = (headingLevel:HeadingLevel ): HeadingTag => `h${headingLevel}`;

type EditProps = {
	"context": {
		'utk-wds-accordion/headingLevel': HeadingTag
	},
	"attributes": {
		"panelTitle": string
	},
	"setAttributes": any
}

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
*
* @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
*
* @return {WPElement} Element to render.
*/
export function Edit({ context, attributes, setAttributes }: EditProps ): WPElement {

	const blockProps = useBlockProps();

	const onChangeTitle = ( newTitle: string ) => {
		setAttributes( { panelTitle: newTitle } );
	};

	return (
		<div {...blockProps}>
			<RichText
				tagName={ context['utk-wds-accordion/headingLevel'] }
				allowedFormats={ [ 'core/bold', 'core/italic' ] }
				className="utk-wds-accordion__heading"
				onChange={ onChangeTitle }
				value={ attributes.panelTitle }
				placeholder={ __('Add a panel title…')}
			/>
			<div style={{ border: 'solid 1px red' }}>
				Panel content
				{/* <InnerBlocks /> */}
			</div>
		</div>
	);
}

export function Save( props: BlockSaveProps<{panelTitle: string; headingLevel: HeadingLevel;}> ) {
	const blockProps = useBlockProps.save();
	return (
		<div {...blockProps}><RichText.Content tagName={getTagName(props.attributes.headingLevel)} className="utk-wds-accordion__heading" value={props.attributes.panelTitle} /><div style={{ border: 'solid 1px red' }}>Panel content</div></div>
	);
}