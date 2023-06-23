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
		title: string,
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
	// useSelect( (select ) => {
	// 	setAttributes( { title:  getSiteTitle(select) } );
	// }, [] );

	return (
		<Fragment>
		<div {...blockProps}>
			<div className="container-fluid universal-footer mt-auto" id="universal-footer">
				<div className="container-xxl">
					<div className="row pt-3">
						<div className="site-info col-12 col-md-6">
							{/* <h2>{ attributes.title }</h2> */}
						<RichText
							tagName="div"
							allowedFormats={ [ 'core/bold', 'core/italic', 'core/link' ] }
							onChange={ ( content: string ) => {
								setAttributes( { content, contactInfo: content } ) ;
								}
							}
							value={ attributes.contactInfo }
							placeholder={ __('Add contact info…')}
						/>
							<div className="contact-info mt-5 has-white-color has-text-color">
								<div id="custom-sidebar" className="sidebar">
								</div>
							</div>
						</div>
						<div id="utk-identifier" className="col-12 col-md-6 col-lg-5 ms-lg-auto mt-md-n5 p-4 utk-identifier has-f">
							<a href="https://www.utk.edu/">
								<UtkLogo />
							</a>
							<RichText
								tagName="div"
								allowedFormats={ [ 'core/bold', 'core/italic', 'core/link' ] }
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
								onChange={ ( content: string ) => {
									setAttributes( { content, panelText: content } ) ;
									}
								}
								value={ attributes.panelText }
								placeholder={ __('Add text…')}
							/>

							<RichText
								tagName="div"
								className="universal-footer-links"
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
				</div>
			</div>
		</div>
		</Fragment>
	);
}

interface SaveAttributes extends BlockAttributes {
	title: string,
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
			<div className="container-fluid universal-footer mt-auto" id="universal-footer">
				<div className="container-xxl">
					<div className="row pt-3">
						<div className="site-info col-12 col-md-6">
							{/* <h2>{ attributes.title }</h2> */}
						<RichText.Content
							tagName="div"
							value={ attributes.contactInfo }
						/>
							<div className="contact-info mt-5 has-white-color has-text-color">
								<div id="custom-sidebar" className="sidebar">
								</div>
							</div>
						</div>
						<div id="utk-identifier" className="col-12 col-md-6 col-lg-5 ms-lg-auto mt-md-n5 p-4 utk-identifier has-f">
							<a href="https://www.utk.edu/">
								<UtkLogo />
							</a>
							<RichText.Content
								tagName="div"
								value={ attributes.panelContact }
							/>

							<RichText.Content
								tagName="div"
								value={ attributes.panelText }
							/>

							<RichText.Content
								tagName="div"
								className="universal-footer-links"
								value={ attributes.panelLinks }
							/>
						</div>
					</div>
				</div>
			</div>
		</div>
		</Fragment>
	);
}

export { Edit, Save };