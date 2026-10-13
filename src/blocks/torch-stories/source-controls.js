/**
 * WordPress dependencies.
 */
import { __ } from '@wordpress/i18n';
import { SelectControl } from '@wordpress/components';
import { useDebounce } from '@wordpress/compose';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import { useState } from '@wordpress/element';

/**
 * Internal dependencies.
 */
import TermCombobox from './term-combobox';

const INTERNAL_TAXONOMIES = [
	{ label: __( 'Category', 'utk-wds' ), value: 'category' },
	{ label: __( 'Tag', 'utk-wds' ), value: 'post_tag' },
	{ label: __( 'Location', 'utk-wds' ), value: 'locations' },
];

/**
 * Search string state with a debounced setter for ComboboxControl typing.
 *
 * @return {[string, Function]} Current search and debounced setter.
 */
function useDebouncedSearch() {
	const [ search, setSearch ] = useState( '' );
	const debounced = useDebounce( setSearch, 300 );
	return [ search, debounced ];
}

/**
 * Pickers for stories from this site.
 *
 * @param {Object}   props
 * @param {Object}   props.attributes
 * @param {Function} props.setAttributes
 * @return {Element} Controls.
 */
function InternalSource( { attributes, setAttributes } ) {
	const { taxonomy, termId } = attributes;
	const [ search, setSearch ] = useDebouncedSearch();

	const { terms, selectedTerm } = useSelect(
		( select ) => {
			const { getEntityRecords, getEntityRecord } = select( coreStore );
			const query = {
				per_page: 50,
				hide_empty: true,
				orderby: search ? 'name' : 'count',
				order: search ? 'asc' : 'desc',
				_fields: 'id,name,count',
				context: 'view',
			};
			if ( search ) {
				query.search = search;
			}
			return {
				terms: getEntityRecords( 'taxonomy', taxonomy, query ),
				selectedTerm: termId
					? getEntityRecord( 'taxonomy', taxonomy, termId, {
							context: 'view',
					  } )
					: null,
			};
		},
		[ taxonomy, termId, search ]
	);

	return (
		<>
			<SelectControl
				__next40pxDefaultSize
				__nextHasNoMarginBottom
				label={ __( 'Filter by', 'utk-wds' ) }
				value={ taxonomy }
				options={ INTERNAL_TAXONOMIES }
				onChange={ ( value ) =>
					setAttributes( { taxonomy: value, termId: 0 } )
				}
			/>
			<TermCombobox
				label={
					INTERNAL_TAXONOMIES.find( ( t ) => t.value === taxonomy )
						?.label || __( 'Term', 'utk-wds' )
				}
				terms={ terms }
				selectedId={ termId }
				selectedName={ selectedTerm?.name }
				onSearch={ setSearch }
				onChange={ ( id ) => setAttributes( { termId: id } ) }
			/>
		</>
	);
}

/**
 * Story source controls.
 *
 * @param {Object}   props
 * @param {Object}   props.attributes
 * @param {Function} props.setAttributes
 * @return {Element} Controls.
 */
export default function SourceControls( { attributes, setAttributes } ) {
	return (
		<InternalSource
			attributes={ attributes }
			setAttributes={ setAttributes }
		/>
	);
}
