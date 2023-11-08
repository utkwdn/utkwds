/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { Fragment } from 'react';

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

import type { TemplateArray } from 'wordpress__blocks';
import type { Element } from '@wordpress/element';

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
* @return {Element} Element to render.
*/
export function Edit(props: { attributes: { content: any; headingLevel: string; colorScheme: string; }; setAttributes: any; className: any; context: any; }): Element {
	const {
		attributes: { content },
		context,
		setAttributes,
		className,
	} = props;

	const blockProps = useBlockProps();

	const ACCORDION_TEMPLATE: TemplateArray = [['utk-wds/tab']];

	const onChangeContent = (newContent: any) => {
		setAttributes({ content: newContent });
	};

	const onChangeHeadingLevel = (newLevel: string) => {
		setAttributes({ headingLevel: newLevel });
	};

	const onChangeColorScheme = (newColorScheme: string) => {
		setAttributes({ colorScheme: newColorScheme });
	};

	return (
		<Fragment>
			<InspectorControls>
				<PanelBody title="Heading Level" initialOpen={true}>
					<SelectControl
						label="Heading Level"
						value={props.attributes.headingLevel}
						help={__("Changes the heading level of all panel headings. Use `Heading 3` if the accordion comes after a level 2 heading.")}
						options={[
							{ value: 'h2', label: 'Heading 2' },
							{ value: 'h3', label: 'Heading 3' },
						]}
						onChange={onChangeHeadingLevel}
					/>
					<SelectControl
						label="Color Scheme"
						value={props.attributes.colorScheme}
						help={__("Use this setting to change the colors of the accordion so that they work against different background colors. Changing this setting does not change the background color.")}
						options={[
							{ value: 'light', label: 'On White Background' },
							{ value: 'medium', label: 'On Light Background' },
							{ value: 'dark', label: 'On Dark Background' },
						]}
						onChange={onChangeColorScheme}
					/>
				</PanelBody>
			</InspectorControls>
			<div {...blockProps}>
				<div data-accordion className={"utk-wds-accordion-wrapper"} data-color-scheme={props.attributes.colorScheme}>
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

export function Save(props: { attributes: { content: string; colorScheme: string; }; }) {
	const blockProps = useBlockProps.save();
	return (
		<div {...blockProps}>
			<div data-accordion className={"utk-wds-accordion-wrapper"} data-color-scheme={props.attributes.colorScheme}>
				<InnerBlocks.Content
				/>
			</div>
		</div>
	);
}
