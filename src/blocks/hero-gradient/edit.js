/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * Block editor components.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/
 */
import {
	useBlockProps,
	BlockControls,
	InspectorControls,
	MediaReplaceFlow,
	RichText,
} from '@wordpress/block-editor';

/**
 * Editor UI components.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-components/
 */
import {
	PanelBody,
	TextControl,
	ToggleControl,
	Button,
} from '@wordpress/components';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * Shown until an image is chosen. Matches the fallback in render.php.
 * Imported so webpack bundles it and resolves the URL itself.
 */
import PLACEHOLDER_URL from '../../assets/images/repeat-placeholder-1700x700.jpg';

/**
 * The edit function mirrors the markup in render.php so the shared
 * style.scss applies in both places, with the text editable in place.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Block props.
 * @param {Object}   props.attributes    Block attributes.
 * @param {Function} props.setAttributes Setter for block attributes.
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const {
		mediaId,
		mediaUrl,
		smokeyFade,
		heading,
		body,
		videoUrl,
		videoText,
	} = attributes;
	const blockProps = useBlockProps();

	const onSelectMedia = ( media ) =>
		setAttributes( { mediaId: media.id, mediaUrl: media.url } );

	const onRemoveMedia = () => setAttributes( { mediaId: 0, mediaUrl: '' } );

	return (
		<>
			<BlockControls group="other">
				<MediaReplaceFlow
					mediaId={ mediaId }
					mediaURL={ mediaUrl }
					allowedTypes={ [ 'image' ] }
					accept="image/*"
					onSelect={ onSelectMedia }
					name={
						mediaUrl
							? __( 'Replace image', 'utk-wds' )
							: __( 'Add image', 'utk-wds' )
					}
				/>
			</BlockControls>
			<InspectorControls>
				<PanelBody title={ __( 'Background Image', 'utk-wds' ) }>
					<p>
						{ __(
							'The image is decorative and sits behind a dark overlay, so it has no alt text. Use the toolbar to add or replace it. A placeholder image shows until one is chosen.',
							'utk-wds'
						) }
					</p>
					{ mediaUrl && (
						<Button
							variant="secondary"
							isDestructive
							onClick={ onRemoveMedia }
						>
							{ __( 'Remove image', 'utk-wds' ) }
						</Button>
					) }
				</PanelBody>
				<PanelBody title={ __( 'Overlay', 'utk-wds' ) }>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Fade to smokey', 'utk-wds' ) }
						help={ __(
							'Fades the bottom of the image into smokey so it blends into a smokey section below.',
							'utk-wds'
						) }
						checked={ smokeyFade }
						onChange={ ( value ) =>
							setAttributes( { smokeyFade: value } )
						}
					/>
				</PanelBody>
				<PanelBody title={ __( 'Video Link', 'utk-wds' ) }>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Video URL', 'utk-wds' ) }
						help={ __(
							'Paste the full YouTube URL. The link is hidden on the page until a URL is added.',
							'utk-wds'
						) }
						type="url"
						placeholder="https://www.youtube.com/watch?v="
						value={ videoUrl }
						onChange={ ( value ) =>
							setAttributes( { videoUrl: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<img
					className="hero-gradient__image"
					src={ mediaUrl || PLACEHOLDER_URL }
					alt=""
				/>
				<span
					className={
						'hero-gradient__overlay' +
						( smokeyFade
							? ' hero-gradient__overlay--smokey-fade'
							: '' )
					}
					aria-hidden="true"
				/>
				<div className="hero-gradient__content">
					<RichText
						tagName="h1"
						className="wp-block-heading hero-gradient__title"
						value={ heading }
						onChange={ ( value ) =>
							setAttributes( { heading: value } )
						}
						placeholder={ __( 'Add heading…', 'utk-wds' ) }
						allowedFormats={ [ 'core/italic' ] }
					/>
					<RichText
						tagName="p"
						className="is-style-utkwds-paragraph-large hero-gradient__body"
						value={ body }
						onChange={ ( value ) =>
							setAttributes( { body: value } )
						}
						placeholder={ __(
							'Optional body copy: 25 words or fewer. Orient users to what the page is about before they scroll.',
							'utk-wds'
						) }
						allowedFormats={ [ 'core/bold', 'core/italic' ] }
					/>
					<p
						className={
							'hero-gradient__video' +
							( videoUrl ? '' : ' is-missing-url' )
						}
					>
						<RichText
							tagName="span"
							className="hero-gradient__video-link"
							value={ videoText }
							onChange={ ( value ) =>
								setAttributes( { videoText: value } )
							}
							placeholder={ __( 'Watch video', 'utk-wds' ) }
							allowedFormats={ [] }
						/>
					</p>
				</div>
			</div>
		</>
	);
}
