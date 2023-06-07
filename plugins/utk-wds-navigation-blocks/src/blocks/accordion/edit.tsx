/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import {Fragment} from 'react';

import {
	Notice,
	PanelBody,
	SelectControl,
	RangeControl,
	ToggleControl,
} from '@wordpress/components';

import {
	InnerBlocks,
	RichText,
	useBlockProps,
	store as blockEditorStore,
	InspectorControls,
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

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
*
* @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
*
* @return {WPElement} Element to render.
*/
export function Edit(props: { attributes: { content: any; headingLevel: string; }; setAttributes: any; className: any; context: any; }): WPElement {
	const {
		attributes: { content },
		context,
		setAttributes,
		className,
	} = props;

	const blockProps = useBlockProps();

	const ACCORDION_TEMPLATE: TemplateArray = [['utk-wds/accordion-panel']];

	const onChangeContent = (newContent: any) => {
		setAttributes({ content: newContent });
	};

	const onChangeHeadingLevel = (newLevel: string) => {
		setAttributes({ headingLevel: newLevel });
	  };

	return (
		<Fragment>
		<InspectorControls>
          <PanelBody title="Heading Level" initialOpen={true}>
            <SelectControl
              label="Heading Level"
              value={props.attributes.headingLevel}
              options={[
                { value: 'h2', label: 'Heading 2' },
                { value: 'h3', label: 'Heading 3' },
              ]}
              onChange={onChangeHeadingLevel}
            />
          </PanelBody>
        </InspectorControls>
		<div {...blockProps}>
			<div data-accordion className={"utk-wds-accordion-wrapper"}>
			<InnerBlocks
				allowedBlocks={ALLOWED_BLOCKS}
				template={ACCORDION_TEMPLATE}
				renderAppender={InnerBlocks.ButtonBlockAppender}
			/>
			</div>
		</div>
		</Fragment>
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
		<div {...blockProps}>
			<div data-accordion className={"utk-wds-accordion-wrapper"}>
			<InnerBlocks.Content
			/>
			</div>
		</div>
	);
}
