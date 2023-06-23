/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import {Fragment} from 'react';

import {
	RichText,
	useBlockProps,
	BlockAttributes
} from '@wordpress/block-editor';

import { useSelect } from '@wordpress/data';
import { getSiteTitle } from '../../utils/site-data';

import type {TemplateArray} from 'wordpress__blocks';
import type {WPElement} from '@wordpress/element';


/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';


type EditProps = {
	context: {},
	attributes: {
		contactInfo: string,
		panelContact: string,
		panelText: string,
		panelLinks: string,
	},
	setAttributes: any
}

const utkLogoPath = '/assets/images/utk-logo-white.svg';

const UtkLogo = () => {
	const utkLogoUrl = UTKWDS.plugin_url + utkLogoPath;
	return (
	<img src={ utkLogoUrl } alt="University of Tennessee Knoxville" className="utk-logo" />
)};

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
*
* @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
*
* @return {WPElement} Element to render.
*/
const Edit = function Edit({ attributes, setAttributes, context }: EditProps): WPElement {

	const blockProps = useBlockProps();

	return (
		<Fragment>
		<div {...blockProps}>
				<a href="https://www.utk.edu/">
					<UtkLogo />
				</a>
				<div className="panel-text-wrapper">
					<RichText
						tagName="div"
						allowedFormats={ [ 'core/bold', 'core/italic', 'core/link' ] }
						className="panel-contact"
						onChange={ ( content: string ) => {
							setAttributes( { content, panelContact: content } ) ;
							}
						}
						value={ attributes.panelContact }
						placeholder={ __('Add contact info…')}
					/>
					<RichText
						tagName="div"
						allowedFormats={ [ 'core/bold', 'core/italic', 'core/link' ] }
						className="panel-text"
						onChange={ ( content: string ) => {
							setAttributes( { content, panelText: content } ) ;
							}
						}
						value={ attributes.panelText }
						placeholder={ __('Add text…')}
					/>
					<RichText
						tagName="div"
						className="panel-links universal-footer-links"
						allowedFormats={ [ 'core/link' ] }
						onChange={ ( content: string ) => {
							setAttributes( { content, panelLinks: content } ) ;
							}
						}
						value={ attributes.panelLinks }
						placeholder={ __('Add links…')}
					/>
				</div>
			</div>
		</Fragment>
	);
}

interface SaveAttributes extends BlockAttributes {
	contactInfo: string,
	panelContact: string,
	panelText: string,
	panelLinks: string,
  }

const Save = function Save({ attributes }: { attributes: SaveAttributes }) {
	const blockProps = useBlockProps.save();
	const utkLogoUrl = UTKWDS.plugin_url + utkLogoPath;
	return (
		<Fragment>
		<div {...blockProps}>
			<a href="https://www.utk.edu/">
				<UtkLogo />
			</a>
			<div className="panel-text-wrapper">
				<RichText.Content
					tagName="div"
					className="panel-contact"
					value={ attributes.panelContact }
				/>
				<div className="panel-text">
					<RichText.Content
						tagName="div"
						className="panel-text"
						value={ attributes.panelText }
					/>
				</div>
				<RichText.Content
					tagName="div"
					className="panel-links universal-footer-links"
					value={ attributes.panelLinks }
				/>
			</div>
		</div>
		</Fragment>
	);
}

export { Edit, Save };