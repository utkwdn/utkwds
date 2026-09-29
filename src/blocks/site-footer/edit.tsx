/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { Fragment } from 'react';

import {
	RichText,
	useBlockProps,
	BlockAttributes,
} from '@wordpress/block-editor';

import { useSelect } from '@wordpress/data';
import { getSiteTitle } from '../../utils/site-data';

import type { TemplateArray } from 'wordpress__blocks';
import type { Element } from '@wordpress/element';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

type EditProps = {
	context: {};
	attributes: {
		contactInfo: string;
		panelContact: string;
		panelText: string;
	};
	setAttributes: any;
};

const utkLogoPath = '/assets/svg/utk-logo-white.svg';

const UtkLogo = () => {
	const utkLogoUrl = UTKWDS.theme_url + utkLogoPath;
	return (
		<img
			src={ utkLogoUrl }
			alt="University of Tennessee Knoxville"
			className="utk-logo"
		/>
	);
};

/**
 * These are the same on every site using this theme and are
 * not meant to be edited per-site.
 */
const UNIVERSAL_LINKS: { text: string; url: string }[] = [
	{ text: 'Accessibility', url: 'https://dae.utk.edu/eoa/ada/' },
	{ text: 'Privacy', url: 'https://www.utk.edu/aboutut/privacy/' },
	{ text: 'Safety', url: 'https://safety.utk.edu/' },
	{ text: 'Title IX', url: 'https://titleix.utk.edu/' },
	{ text: 'Employee Hub', url: 'https://hub.utk.edu/' },
	{ text: 'Employment', url: 'https://hr.utk.edu/' },
];

const UniversalLinks = () => (
	<nav aria-label="Universal links">
		<ul className="panel-links universal-footer-links">
			{ UNIVERSAL_LINKS.map( ( link ) => (
				<li key={ link.url }>
					<a href={ link.url }>{ link.text }</a>
				</li>
			) ) }
		</ul>
	</nav>
);

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
const Edit = function Edit( {
	attributes,
	setAttributes,
	context,
}: EditProps ): Element {
	const blockProps = useBlockProps();

	return (
		<Fragment>
			<div { ...blockProps }>
				<a href="https://www.utk.edu/">
					<UtkLogo />
				</a>
				<div className="panel-text-wrapper">
					<RichText
						tagName="div"
						allowedFormats={ [
							'core/bold',
							'core/italic',
							'core/link',
						] }
						className="panel-contact"
						onChange={ ( content: string ) => {
							setAttributes( { content, panelContact: content } );
						} }
						value={ attributes.panelContact }
						placeholder={ __( 'Add contact info…' ) }
					/>
					<RichText
						tagName="div"
						allowedFormats={ [
							'core/bold',
							'core/italic',
							'core/link',
						] }
						className="panel-text"
						onChange={ ( content: string ) => {
							setAttributes( { content, panelText: content } );
						} }
						value={ attributes.panelText }
						placeholder={ __( 'Add text…' ) }
					/>
					<UniversalLinks />
				</div>
			</div>
		</Fragment>
	);
};

interface SaveAttributes extends BlockAttributes {
	contactInfo: string;
	panelContact: string;
	panelText: string;
}

const Save = function Save( { attributes }: { attributes: SaveAttributes } ) {
	const blockProps = useBlockProps.save();
	const utkLogoUrl = UTKWDS.theme_url + utkLogoPath;
	return (
		<Fragment>
			<div { ...blockProps }>
				<a href="https://www.utk.edu/">
					<UtkLogo />
				</a>
				<div className="panel-text-wrapper">
					<RichText.Content
						tagName="div"
						className="panel-contact"
						value={ attributes.panelContact }
					/>
					<RichText.Content
						tagName="div"
						className="panel-text"
						value={ attributes.panelText }
					/>
					<UniversalLinks />
				</div>
			</div>
		</Fragment>
	);
};

interface SaveV1Attributes extends BlockAttributes {
	panelContact: string;
	panelText: string;
	panelLinks: string;
}

/**
 * Original save output, from before the universal links were pulled out
 * of the editable panelLinks attribute into the hardcoded UniversalLinks
 * component. Kept for the block's deprecation entry so footers already
 * saved into a site's database (e.g. via a customized Site Editor
 * template part) don't get flagged as invalid content.
 */
const SaveV1 = function SaveV1( {
	attributes,
}: {
	attributes: SaveV1Attributes;
} ) {
	const blockProps = useBlockProps.save();
	return (
		<Fragment>
			<div { ...blockProps }>
				<a href="https://www.utk.edu/">
					<UtkLogo />
				</a>
				<div className="panel-text-wrapper">
					<RichText.Content
						tagName="div"
						className="panel-contact"
						value={ attributes.panelContact }
					/>
					<RichText.Content
						tagName="div"
						className="panel-text"
						value={ attributes.panelText }
					/>
					<RichText.Content
						tagName="div"
						className="panel-links universal-footer-links"
						value={ attributes.panelLinks }
					/>
				</div>
			</div>
		</Fragment>
	);
};

export { Edit, Save, SaveV1 };
