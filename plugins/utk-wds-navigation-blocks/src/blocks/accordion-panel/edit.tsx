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
	BlockAttributes
} from '@wordpress/block-editor';

import {useEffect} from 'react';

import type {BlockSaveProps} from 'wordpress__blocks';
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

	const blockProps = useBlockProps();

	useEffect(() => {
		setAttributes({ headingLevel: context['utk-wds-accordion/headingLevel'] });
	  }, [context, setAttributes]);

	return (
		<div {...blockProps}>
			<HeadingDynamic level={ attributes.headingLevel } className="utk-wds-accordion__heading">
				<RichText
					tagName="div"
					allowedFormats={ [ 'core/bold', 'core/italic' ] }
					onChange={ ( content: string ) => {
						setAttributes( { content, panelTitle: content } ) ;
						}
					}
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

interface PanelSaveAttributes extends BlockAttributes {
	panelTitle: string;
	headingLevel: 'h2' | 'h3';
  }

export function Save( { attributes }: {attributes: PanelSaveAttributes}  ) {
	const blockProps = useBlockProps.save();
	return (
		<div {...blockProps}>
			<HeadingDynamic level={ attributes.headingLevel } className="utk-wds-accordion__heading" data-accordion-heading >
				<RichText.Content
					tagName="div"
					value={attributes.panelTitle}
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