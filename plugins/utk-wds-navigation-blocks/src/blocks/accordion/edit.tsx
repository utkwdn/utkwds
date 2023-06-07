/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

import {
	Notice,
	PanelBody,
	RangeControl,
	ToggleControl,
} from '@wordpress/components';

import {
	InnerBlocks,
	RichText,
	useBlockProps,
	store as blockEditorStore,
} from '@wordpress/block-editor';

import { withDispatch, useDispatch, useSelect } from '@wordpress/data';
import {
	createBlock,
	store as blocksStore,
} from '@wordpress/blocks';

import type {TemplateArray} from 'wordpress__blocks';
import type {WPElement} from '@wordpress/element';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * Allowed blocks constant is passed to InnerBlocks precisely as specified here.
 * The contents of the array should never change.
 * The array should contain the name of each block that is allowed.
 * In Accordion block, the only block we allow is 'utk-wds/accordion-panel'.
 *
 * @constant
 * @type {string[]}
 */
const ALLOWED_BLOCKS: string[] = ['utk-wds/accordion-panel'];

/**
 * Accordion template constant is passed to InnerBlocks precisely as specified here.
 * The contents of the array should never change.
 * The array should contain arrays, each of which should include the name of
 * a block to be included in the Template.
 *
 * @constant
 * @type {TemplateArray}
 */
const ACCORDION_TEMPLATE: TemplateArray = [['utk-wds/accordion-panel']];

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export function Edit(props: { attributes: { content: any; }; setAttributes: any; className: any; }): WPElement {
	const {
		attributes: { content },
		setAttributes,
		className,
	} = props;
	const blockProps = useBlockProps();
	const onChangeContent = (newContent: any) => {
		setAttributes({ content: newContent });
	};
	return (
		<div {...blockProps}>
			<InnerBlocks
				allowedBlocks={ALLOWED_BLOCKS}
				template={ACCORDION_TEMPLATE}
				renderAppender={InnerBlocks.ButtonBlockAppender}
			/>
		</div>
	);
}

// return (
// 	<div {...useBlockProps()}>
// 		<InspectorControls key="setting">
// 			<div id="utk-wds-accordion-controls">
// 				<fieldset>
// 					<legend className="blocks-base-control__label">
// 						{__('Background color', 'utk-wds')}
// 					</legend>
// 					<ColorPalette // Element Tag for Gutenberg standard colour selector
// 						onChange={onChangeBGColor} // onChange event callback
// 					/>
// 				</fieldset>
// 			</div>
// 		</InspectorControls>

// 		<p>This is an accordion. Its background color is {attributes.bg_color}</p>
// 		<InnerBlocks
// 			allowedBlocks={ALLOWED_BLOCKS}
// 			template={ACCORDION_TEMPLATE}
// 		/>
// 	</div>
// );
// }

export function Save(props: { attributes: { content: string; }; }) {
	const blockProps = useBlockProps.save();
	return (
		<RichText.Content
			{...blockProps}
			tagName="p"
			value={props.attributes.content}
		/>
	);
}
