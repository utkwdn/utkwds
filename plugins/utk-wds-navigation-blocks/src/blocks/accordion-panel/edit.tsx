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

import { HeadingDynamic } from '../../utils/customElements';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

type HeadingTag = 'h2' | 'h3';

type EditProps = {
	"context": {
		'utk-wds-accordion/headingLevel': HeadingTag
	},
	"attributes": {
		"panelTitle": string,
		"headingLevel": 'h2' | 'h3',
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

	const ALLOWED_BLOCKS: string[] = [
		'core/paragraph',
		'core/heading',
		'core/list',
		'core/image',
		'core/quote'
	];

	const blockProps = useBlockProps();

	const onChangeTitle = ( newTitle: string ) => {
		setAttributes( { panelTitle: newTitle } );
	};

	
	setAttributes( { headingLevel: context['utk-wds-accordion/headingLevel'] } );

	return (
		<div {...blockProps}>
			<HeadingDynamic level={ attributes.headingLevel } className="utk-wds-accordion__heading">
				<RichText
					tagName="div"
					allowedFormats={ [ 'core/bold', 'core/italic' ] }
					onChange={ onChangeTitle }
					value={ attributes.panelTitle }
					placeholder={ __('Add a panel title…')}
				/>
			</HeadingDynamic>
			<div className="utk-wds-accordion__panel-body">
				<InnerBlocks />
			</div>
		</div>
	);
}

export function Save( props: BlockSaveProps<{panelTitle: string; headingLevel: HeadingTag;}> ) {
	const blockProps = useBlockProps.save();
	console.log(props.attributes.headingLevel);
	return (
		<div {...blockProps}>
			<HeadingDynamic level={ props.attributes.headingLevel } className="utk-wds-accordion__heading" data-accordion-heading >
				<RichText.Content
					tagName="div"
					value={props.attributes.panelTitle}
				/>
			</HeadingDynamic>
				<section data-accordion-section>
					<div className="utk-wds-accordion__panel-body">
						<InnerBlocks.Content />
					</div>
				</section>
		</div>
	);
}