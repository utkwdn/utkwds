/**
 * WordPress dependencies.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {
	PanelBody,
	SelectControl,
	TextControl,
	Notice,
} from '@wordpress/components';
import { decodeEntities } from '@wordpress/html-entities';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Editor-only styles.
 */
import './editor.scss';

/**
 * Build option lists for a SelectControl from a list of taxonomy terms.
 *
 * @param {Array}  terms      Term records (may be null while loading).
 * @param {string} emptyLabel Label for the "none" option.
 * @return {Array} Option objects for SelectControl.
 */
function termOptions( terms, emptyLabel ) {
	const options = [ { label: emptyLabel, value: 0 } ];
	if ( Array.isArray( terms ) ) {
		terms.forEach( ( term ) => {
			options.push( {
				label: decodeEntities( term.name ),
				value: term.id,
			} );
		} );
	}
	return options;
}

/**
 * The block editor component.
 *
 * @param {Object} props               Block props.
 * @param {Object} props.attributes    Block attributes.
 * @param {Function} props.setAttributes Attribute setter.
 * @return {WPElement} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps();

	// Load category and location terms for the sidebar pickers.
	const { categories, locations } = useSelect( ( select ) => {
		const { getEntityRecords } = select( coreStore );
		const query = {
			per_page: -1,
			orderby: 'name',
			order: 'asc',
			_fields: 'id,name',
			context: 'view',
		};
		return {
			categories: getEntityRecords( 'taxonomy', 'category', query ),
			locations: getEntityRecords( 'taxonomy', 'locations', query ),
		};
	}, [] );

	const categoryOptions = termOptions(
		categories,
		__( '— Select a category —', 'utk-wds' )
	);
	const locationOptions = termOptions(
		locations,
		__( '— Select a location —', 'utk-wds' )
	);

	/**
	 * Render a paired category and location picker for one story section.
	 *
	 * @param {string} categoryAttr Attribute key for the category.
	 * @param {string} locationAttr Attribute key for the location.
	 * @return {WPElement} The paired controls.
	 */
	const sectionControls = ( categoryAttr, locationAttr ) => (
		<>
			<SelectControl
				label={ __( 'Category', 'utk-wds' ) }
				value={ attributes[ categoryAttr ] }
				options={ categoryOptions }
				onChange={ ( value ) =>
					setAttributes( { [ categoryAttr ]: parseInt( value, 10 ) } )
				}
				__nextHasNoMarginBottom
			/>
			<SelectControl
				label={ __( 'Location', 'utk-wds' ) }
				value={ attributes[ locationAttr ] }
				options={ locationOptions }
				onChange={ ( value ) =>
					setAttributes( { [ locationAttr ]: parseInt( value, 10 ) } )
				}
				__nextHasNoMarginBottom
			/>
		</>
	);

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Left column — story section', 'utk-wds' ) }
					initialOpen={ true }
				>
					{ sectionControls( 'leftCategory', 'leftLocation' ) }
				</PanelBody>

				<PanelBody
					title={ __( 'Center column — featured story', 'utk-wds' ) }
					initialOpen={ false }
				>
					{ sectionControls( 'centerCategory', 'centerLocation' ) }
				</PanelBody>

				<PanelBody
					title={ __(
						'Right column — top story section',
						'utk-wds'
					) }
					initialOpen={ false }
				>
					{ sectionControls(
						'rightCategoryOne',
						'rightLocationOne'
					) }
				</PanelBody>

				<PanelBody
					title={ __(
						'Right column — bottom story section',
						'utk-wds'
					) }
					initialOpen={ false }
				>
					{ sectionControls(
						'rightCategoryTwo',
						'rightLocationTwo'
					) }
				</PanelBody>

				<PanelBody
					title={ __( 'RSS feed (UT in the News)', 'utk-wds' ) }
					initialOpen={ false }
				>
					<TextControl
						label={ __( 'Feed URL', 'utk-wds' ) }
						type="url"
						value={ attributes.rssFeedUrl }
						onChange={ ( value ) =>
							setAttributes( { rssFeedUrl: value } )
						}
						help={ __(
							'The four most recent items from this feed are displayed.',
							'utk-wds'
						) }
						__nextHasNoMarginBottom
					/>
					{ ! attributes.rssFeedUrl && (
						<Notice status="warning" isDismissible={ false }>
							{ __(
								'No feed URL set — the RSS section will be empty.',
								'utk-wds'
							) }
						</Notice>
					) }
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<ServerSideRender
					block="utk-wds/news-home-hero"
					attributes={ attributes }
				/>
			</div>
		</>
	);
}
