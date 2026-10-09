/**
 * WordPress dependencies.
 */
import { __, sprintf } from '@wordpress/i18n';
import {
	BaseControl,
	Button,
	Flex,
	PanelBody,
	TextControl,
	TextareaControl,
	ToggleControl,
} from '@wordpress/components';
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';

/**
 * Sidebar panel for manually overriding one of the three stories.
 *
 * @param {Object}   props
 * @param {number}   props.index    Story index (0–2).
 * @param {Object}   props.value    Override ({ enabled, imageId, title, excerpt, url }).
 * @param {Function} props.onChange Called with the new override object.
 * @return {Element} Panel.
 */
export default function StoryOverride( { index, value = {}, onChange } ) {
	const {
		enabled = false,
		imageId = 0,
		title = '',
		excerpt = '',
		url = '',
	} = value;

	const media = useSelect(
		( select ) =>
			imageId
				? select( coreStore ).getMedia( imageId, { context: 'view' } )
				: null,
		[ imageId ]
	);

	const update = ( patch ) => onChange( { ...value, ...patch } );
	const previewUrl =
		media?.media_details?.sizes?.medium_large?.source_url ||
		media?.media_details?.sizes?.medium?.source_url ||
		media?.source_url;

	return (
		<PanelBody
			title={
				sprintf(
					/* translators: %d: story number. */
					__( 'Story %d', 'utk-wds' ),
					index + 1
				) + ( enabled ? ` — ${ __( 'overridden', 'utk-wds' ) }` : '' )
			}
			initialOpen={ false }
		>
			<ToggleControl
				__nextHasNoMarginBottom
				label={ __( 'Override this story', 'utk-wds' ) }
				checked={ enabled }
				onChange={ ( checked ) => update( { enabled: checked } ) }
				help={
					enabled
						? __(
								'This story is now written by hand: fill in the image, title, excerpt and link below. Placeholder content shows until you do. While any story is overridden, the date and categories are hidden on all three stories.',
								'utk-wds'
						  )
						: __(
								'Insert your own story here. The stories from the source move down one position to make room.',
								'utk-wds'
						  )
				}
			/>

			{ enabled && (
				<div style={ { marginTop: '16px' } }>
					<BaseControl __nextHasNoMarginBottom>
						<BaseControl.VisualLabel>
							{ __( 'Image', 'utk-wds' ) }
						</BaseControl.VisualLabel>
						<MediaUploadCheck>
							<MediaUpload
								allowedTypes={ [ 'image' ] }
								value={ imageId }
								onSelect={ ( item ) =>
									update( { imageId: item.id } )
								}
								render={ ( { open } ) => (
									<div style={ { marginTop: '8px' } }>
										{ previewUrl && (
											<img
												src={ previewUrl }
												alt=""
												style={ {
													display: 'block',
													width: '100%',
													aspectRatio: '3 / 2',
													objectFit: 'cover',
													marginBottom: '8px',
												} }
											/>
										) }
										{ ! previewUrl && (
											<p
												style={ {
													margin: '0 0 8px',
													color: '#757575',
												} }
											>
												{ __(
													'Showing a placeholder image.',
													'utk-wds'
												) }
											</p>
										) }
										<Flex justify="flex-start">
											<Button
												variant="secondary"
												onClick={ open }
											>
												{ imageId
													? __(
															'Replace image',
															'utk-wds'
													  )
													: __(
															'Choose image',
															'utk-wds'
													  ) }
											</Button>
											{ imageId > 0 && (
												<Button
													variant="tertiary"
													isDestructive
													onClick={ () =>
														update( { imageId: 0 } )
													}
												>
													{ __(
														'Remove',
														'utk-wds'
													) }
												</Button>
											) }
										</Flex>
									</div>
								) }
							/>
						</MediaUploadCheck>
					</BaseControl>

					<div style={ { marginTop: '16px' } }>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Title', 'utk-wds' ) }
							placeholder={ __( 'Story Title', 'utk-wds' ) }
							value={ title }
							onChange={ ( next ) => update( { title: next } ) }
						/>
					</div>

					<div style={ { marginTop: '16px' } }>
						<TextareaControl
							__nextHasNoMarginBottom
							label={ __( 'Excerpt', 'utk-wds' ) }
							placeholder={ __(
								'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
								'utk-wds'
							) }
							value={ excerpt }
							rows={ 3 }
							onChange={ ( next ) => update( { excerpt: next } ) }
						/>
					</div>

					<div style={ { marginTop: '16px' } }>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							type="url"
							label={ __( 'Link', 'utk-wds' ) }
							placeholder="https://"
							value={ url }
							onChange={ ( next ) =>
								update( { url: next.trim() } )
							}
							help={ __(
								'Paste the full URL this story should link to. Without one, the title is not linked.',
								'utk-wds'
							) }
						/>
					</div>

					<Button
						variant="link"
						isDestructive
						style={ { marginTop: '16px' } }
						onClick={ () => onChange( {} ) }
					>
						{ __( 'Clear override', 'utk-wds' ) }
					</Button>
				</div>
			) }
		</PanelBody>
	);
}
