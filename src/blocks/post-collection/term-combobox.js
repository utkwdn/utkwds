/**
 * WordPress dependencies.
 */
import { __, sprintf } from '@wordpress/i18n';
import { ComboboxControl } from '@wordpress/components';
import { decodeEntities } from '@wordpress/html-entities';

/**
 * Searchable term picker shared by internal and external sources.
 *
 * @param {Object}   props
 * @param {string}   props.label        Control label.
 * @param {Array}    props.terms        Terms ({ id, name, count }); null while loading.
 * @param {number}   props.selectedId   Selected term ID (0 = none).
 * @param {string}   props.selectedName Name of the selected term, used when it is not in `terms`.
 * @param {Function} props.onChange     Called with ( id, name ).
 * @param {Function} props.onSearch     Called with the typed search string.
 * @return {Element} Control.
 */
export default function TermCombobox( {
	label,
	terms,
	selectedId,
	selectedName,
	onChange,
	onSearch,
} ) {
	const options = ( Array.isArray( terms ) ? terms : [] ).map( ( term ) => ( {
		value: String( term.id ),
		label:
			typeof term.count === 'number'
				? sprintf(
						/* translators: 1: term name, 2: number of posts. */
						__( '%1$s (%2$d)', 'utk-wds' ),
						decodeEntities( term.name ),
						term.count
				  )
				: decodeEntities( term.name ),
		name: decodeEntities( term.name ),
	} ) );

	// Keep the saved term visible even if it is not in the current result page.
	if (
		selectedId &&
		! options.some( ( option ) => option.value === String( selectedId ) )
	) {
		const name = selectedName || `#${ selectedId }`;
		options.unshift( {
			value: String( selectedId ),
			label: decodeEntities( name ),
			name: decodeEntities( name ),
		} );
	}

	return (
		<ComboboxControl
			__next40pxDefaultSize
			__nextHasNoMarginBottom
			label={ label }
			value={ selectedId ? String( selectedId ) : null }
			options={ options }
			allowReset
			onFilterValueChange={ onSearch }
			onChange={ ( value ) => {
				if ( ! value ) {
					onChange( 0, '' );
					return;
				}
				const match = options.find(
					( option ) => option.value === value
				);
				onChange( parseInt( value, 10 ), match ? match.name : '' );
			} }
			help={ __(
				'Type to search. Leave empty to show the most recent posts.',
				'utk-wds'
			) }
		/>
	);
}
