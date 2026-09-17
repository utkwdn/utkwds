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
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';

/**
 * Editor UI components.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-components/
 */
import {
	PanelBody,
	TextControl,
	RangeControl,
	Placeholder,
} from '@wordpress/components';

/**
 * Renders the block on the server so the editor preview matches the front end.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-server-side-render/
 */
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
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
	const { feedUrl, itemsToShow } = attributes;
	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Feed Settings', 'utk-wds' ) }>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'RSS Feed URL', 'utk-wds' ) }
						help={ __(
							'Paste the full URL of the RSS feed to display.',
							'utk-wds'
						) }
						type="url"
						placeholder="https://"
						value={ feedUrl }
						onChange={ ( value ) =>
							setAttributes( { feedUrl: value } )
						}
					/>
					<RangeControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Number of items to display', 'utk-wds' ) }
						value={ itemsToShow }
						onChange={ ( value ) =>
							setAttributes( { itemsToShow: value } )
						}
						min={ 3 }
						max={ 20 }
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				{ feedUrl ? (
					<ServerSideRender
						block="utk-wds/meltwater-rss"
						attributes={ attributes }
					/>
				) : (
					<Placeholder
						icon="rss"
						label={ __( 'Meltwater RSS', 'utk-wds' ) }
						instructions={ __(
							'Enter an RSS feed URL in the block settings to display news items.',
							'utk-wds'
						) }
					/>
				) }
			</div>
		</>
	);
}
