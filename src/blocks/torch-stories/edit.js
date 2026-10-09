/**
 * WordPress dependencies.
 */
import { __ } from '@wordpress/i18n';
import {
	InspectorControls,
	RichText,
	URLInput,
	useBlockProps,
} from '@wordpress/block-editor';
import {
	Disabled,
	Notice,
	PanelBody,
	SelectControl,
	ToggleControl,
} from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Internal dependencies.
 */
import SourceControls from './source-controls';
import StoryOverride from './story-override';
import './editor.scss';

const COLOR_SCHEMES = [
	{ label: __( 'White', 'utk-wds' ), value: 'white' },
	{ label: __( 'Light Gray', 'utk-wds' ), value: 'light-gray' },
	{ label: __( 'Smokey', 'utk-wds' ), value: 'smokey' },
];

// Preset color classes per scheme (must match render.php).
const COLOR_CLASSES = {
	white: '',
	'light-gray': 'has-background has-light-background-color',
	smokey: 'has-background has-smokey-background-color has-text-color has-white-color',
};

const DISPLAY_STYLES = [
	{ label: __( '3up (three stories)', 'utk-wds' ), value: '3up' },
	{
		label: __( '2up Alternating (two stories)', 'utk-wds' ),
		value: '2up-alternating',
	},
];

const HEADING_STYLES = [
	{
		label: __( 'Section heading and single link', 'utk-wds' ),
		value: 'link',
	},
	{
		label: __( 'Section heading and description', 'utk-wds' ),
		value: 'description',
	},
	{ label: __( 'No section heading', 'utk-wds' ), value: 'none' },
];

/**
 * Editable section heading, rendered with the same markup as render.php.
 *
 * @param {Object}   props
 * @param {Object}   props.attributes
 * @param {Function} props.setAttributes
 * @return {Element|null} Heading.
 */
function SectionHeading( { attributes, setAttributes } ) {
	const { headingStyle, heading, linkText, description } = attributes;

	const title = (
		<RichText
			tagName="h2"
			className="wp-block-heading torch-stories__title"
			value={ heading }
			onChange={ ( value ) => setAttributes( { heading: value } ) }
			placeholder={ __( 'Section Heading', 'utk-wds' ) }
			allowedFormats={ [] }
			disableLineBreaks
		/>
	);

	if ( headingStyle === 'link' ) {
		return (
			<div className="torch-stories__heading torch-stories__heading--link">
				{ title }
				<p className="is-style-utkwds-single-link torch-stories__link">
					{ /* eslint-disable-next-line jsx-a11y/anchor-is-valid */ }
					<a>
						<RichText
							tagName="span"
							value={ linkText }
							onChange={ ( value ) =>
								setAttributes( { linkText: value } )
							}
							placeholder={ __( 'Single Link', 'utk-wds' ) }
							allowedFormats={ [] }
							disableLineBreaks
						/>
					</a>
				</p>
			</div>
		);
	}

	if ( headingStyle === 'description' ) {
		return (
			<div className="torch-stories__heading torch-stories__heading--description">
				<div className="torch-stories__heading-col torch-stories__heading-col--title">
					{ title }
				</div>
				<div className="torch-stories__heading-col torch-stories__heading-col--description">
					<RichText
						tagName="p"
						className="torch-stories__description"
						value={ description }
						onChange={ ( value ) =>
							setAttributes( { description: value } )
						}
						placeholder={ __(
							'Add descriptive copy for this section.',
							'utk-wds'
						) }
						allowedFormats={ [
							'core/bold',
							'core/italic',
							'core/link',
						] }
					/>
				</div>
			</div>
		);
	}

	return null;
}

/**
 * The block editor component.
 *
 * The heading is edited inline. The three stories are rendered by render.php.
 *
 * @param {Object}   props
 * @param {Object}   props.attributes
 * @param {Function} props.setAttributes
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const {
		headingStyle,
		linkText,
		linkUrl,
		displayStyle,
		colorScheme = 'white',
		showDate,
		showCategories,
		overrides,
	} = attributes;

	// Positions the chosen layout shows (overrides on hidden ones are ignored).
	const storyIndexes =
		displayStyle === '2up-alternating' ? [ 0, 1 ] : [ 0, 1, 2 ];

	const blockProps = useBlockProps( {
		className:
			`torch-stories has-global-padding torch-stories--heading-${ headingStyle } torch-stories--color-${ colorScheme } ${
				COLOR_CLASSES[ colorScheme ] || ''
			}`.trim(),
	} );

	const setOverride = ( index, value ) => {
		const next = [ 0, 1, 2 ].map(
			( i ) => ( overrides && overrides[ i ] ) || {}
		);
		next[ index ] = value;
		setAttributes( { overrides: next } );
	};

	const previewAttributes = {
		...attributes,
		headingStyle: 'none',
		colorScheme: 'white',
		style: {},
		className: undefined,
		anchor: undefined,
	};

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Section heading', 'utk-wds' ) }
					initialOpen={ false }
				>
					<SelectControl
						__next40pxDefaultSize
						__nextHasNoMarginBottom
						label={ __( 'Heading style', 'utk-wds' ) }
						value={ headingStyle }
						options={ HEADING_STYLES }
						onChange={ ( value ) =>
							setAttributes( { headingStyle: value } )
						}
					/>
					{ headingStyle === 'link' && (
						<div style={ { marginTop: '16px' } }>
							<URLInput
								__nextHasNoMarginBottom
								isFullWidth
								className="torch-stories__url-input"
								label={ __( 'Link URL', 'utk-wds' ) }
								value={ linkUrl }
								onChange={ ( value ) =>
									setAttributes( { linkUrl: value } )
								}
							/>
							{ linkText && ! linkUrl && (
								<Notice
									status="warning"
									isDismissible={ false }
								>
									{ __(
										'The link is hidden on the front end until a URL is set.',
										'utk-wds'
									) }
								</Notice>
							) }
						</div>
					) }
				</PanelBody>

				<PanelBody
					title={ __( 'Display', 'utk-wds' ) }
					initialOpen={ false }
				>
					<div style={ { marginBottom: '16px' } }>
						<SelectControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Layout', 'utk-wds' ) }
							value={ displayStyle }
							options={ DISPLAY_STYLES }
							onChange={ ( value ) =>
								setAttributes( { displayStyle: value } )
							}
						/>
					</div>
					<div style={ { marginBottom: '16px' } }>
						<SelectControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Color', 'utk-wds' ) }
							value={ colorScheme }
							options={ COLOR_SCHEMES }
							onChange={ ( value ) =>
								setAttributes( { colorScheme: value } )
							}
						/>
					</div>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Show date', 'utk-wds' ) }
						checked={ showDate }
						onChange={ ( value ) =>
							setAttributes( { showDate: value } )
						}
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Show categories', 'utk-wds' ) }
						checked={ showCategories }
						onChange={ ( value ) =>
							setAttributes( { showCategories: value } )
						}
					/>
				</PanelBody>

				<PanelBody
					title={ __( 'Story source', 'utk-wds' ) }
					initialOpen={ false }
				>
					<SourceControls
						attributes={ attributes }
						setAttributes={ setAttributes }
					/>
				</PanelBody>

				{ storyIndexes.map( ( index ) => (
					<StoryOverride
						key={ index }
						index={ index }
						value={ ( overrides && overrides[ index ] ) || {} }
						onChange={ ( value ) => setOverride( index, value ) }
					/>
				) ) }
			</InspectorControls>

			<div { ...blockProps }>
				<SectionHeading
					attributes={ attributes }
					setAttributes={ setAttributes }
				/>

				<Disabled>
					<ServerSideRender
						block="utk-wds/torch-stories"
						attributes={ previewAttributes }
						httpMethod="POST"
					/>
				</Disabled>
			</div>
		</>
	);
}
