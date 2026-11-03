/**
 * WordPress dependencies.
 */
import { __, sprintf } from '@wordpress/i18n';
import {
	Button,
	Notice,
	RadioControl,
	SelectControl,
	Spinner,
	TextControl,
	Flex,
	FlexItem,
} from '@wordpress/components';
import { useDebounce } from '@wordpress/compose';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import { useCallback, useEffect, useState } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';

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
 * Validate a remote site through this site's REST proxy.
 *
 * @param {string} initialUrl Saved site URL (validated on mount).
 * @return {[Object, Function]} State ({ status, site, error }) and check( url, refresh ).
 */
function useRemoteSite( initialUrl ) {
	const [ state, setState ] = useState( {
		status: initialUrl ? 'loading' : 'idle',
		site: null,
		error: '',
	} );

	const check = useCallback( ( url, refresh = false ) => {
		if ( ! url ) {
			setState( { status: 'idle', site: null, error: '' } );
			return Promise.resolve( null );
		}

		setState( ( prev ) => ( { ...prev, status: 'loading', error: '' } ) );

		return apiFetch( {
			path: addQueryArgs( '/utk-wds/v1/torch-stories/site', {
				url,
				refresh,
			} ),
		} )
			.then( ( site ) => {
				setState( { status: 'ready', site, error: '' } );
				return site;
			} )
			.catch( ( error ) => {
				setState( {
					status: 'error',
					site: null,
					error:
						error?.message ||
						__( 'That site could not be verified.', 'utk-wds' ),
				} );
				return null;
			} );
	}, [] );

	// Re-validate the saved site once when the block is opened.
	useEffect( () => {
		if ( initialUrl ) {
			check( initialUrl );
		}
		// eslint-disable-next-line react-hooks/exhaustive-deps
	}, [] );

	return [ state, check ];
}

/**
 * Load terms for a taxonomy on a validated remote site.
 *
 * @param {Object|null} site     Validated site.
 * @param {string}      restBase Taxonomy REST base.
 * @param {string}      search   Search string.
 * @return {Array|null} Terms, or null while loading.
 */
function useRemoteTerms( site, restBase, search ) {
	const [ terms, setTerms ] = useState( null );
	const siteUrl = site?.url;

	useEffect( () => {
		if ( ! siteUrl || ! restBase ) {
			setTerms( [] );
			return;
		}

		let cancelled = false;
		setTerms( null );

		apiFetch( {
			path: addQueryArgs( '/utk-wds/v1/torch-stories/terms', {
				url: siteUrl,
				taxonomy: restBase,
				search,
			} ),
		} )
			.then( ( result ) => ! cancelled && setTerms( result ) )
			.catch( () => ! cancelled && setTerms( [] ) );

		return () => {
			cancelled = true;
		};
	}, [ siteUrl, restBase, search ] );

	return terms;
}

/**
 * Controls for stories from another site.
 *
 * @param {Object}   props
 * @param {Object}   props.attributes
 * @param {Function} props.setAttributes
 * @return {Element} Controls.
 */
function ExternalSource( { attributes, setAttributes } ) {
	const { externalUrl, externalTaxonomy, externalTermId, externalTermName } =
		attributes;

	const [ urlInput, setUrlInput ] = useState( externalUrl );
	const [ { status, site, error }, check ] = useRemoteSite( externalUrl );
	const [ search, setSearch ] = useDebouncedSearch();

	const taxonomyAvailable = site?.taxonomies?.some(
		( t ) => t.rest_base === externalTaxonomy
	);
	const terms = useRemoteTerms(
		site,
		taxonomyAvailable ? externalTaxonomy : '',
		search
	);

	const connect = ( refresh = false ) =>
		check( urlInput.trim(), refresh ).then( ( result ) => {
			if ( ! result ) {
				return;
			}

			setUrlInput( result.url );

			if ( result.url !== externalUrl ) {
				const keepTaxonomy = result.taxonomies.some(
					( t ) => t.rest_base === externalTaxonomy
				);
				setAttributes( {
					externalUrl: result.url,
					externalTaxonomy: keepTaxonomy
						? externalTaxonomy
						: result.taxonomies[ 0 ]?.rest_base || 'categories',
					externalTermId: 0,
					externalTermName: '',
				} );
			}
		} );

	const inputChanged = urlInput.trim() !== externalUrl;

	return (
		<>
			<TextControl
				__next40pxDefaultSize
				__nextHasNoMarginBottom
				label={ __( 'Site URL', 'utk-wds' ) }
				type="url"
				placeholder="https://www.utk.edu/news"
				value={ urlInput }
				onChange={ setUrlInput }
				onKeyDown={ ( event ) => {
					if ( event.key === 'Enter' ) {
						event.preventDefault();
						connect();
					}
				} }
				help={ __(
					'Enter the URL of a UTK Wordpress site.',
					'utk-wds'
				) }
			/>

			<Flex justify="flex-start" style={ { margin: '8px 0 16px' } }>
				<FlexItem>
					<Button
						variant="secondary"
						onClick={ () => connect() }
						isBusy={ status === 'loading' }
						disabled={ ! urlInput.trim() || status === 'loading' }
					>
						{ __( 'Check site', 'utk-wds' ) }
					</Button>
				</FlexItem>
				{ site && ! inputChanged && (
					<FlexItem>
						<Button
							variant="tertiary"
							onClick={ () => connect( true ) }
							disabled={ status === 'loading' }
						>
							{ __( 'Refresh', 'utk-wds' ) }
						</Button>
					</FlexItem>
				) }
				{ status === 'loading' && (
					<FlexItem>
						<Spinner />
					</FlexItem>
				) }
			</Flex>

			{ status === 'error' && (
				<Notice
					className="torch-stories__error-notice"
					status="error"
					isDismissible={ false }
				>
					{ error }
				</Notice>
			) }

			{ site && inputChanged && (
				<div style={ { marginBottom: '16px' } }>
					<Notice status="warning" isDismissible={ false }>
						{ __(
							'Click “Check site” to switch to the new URL.',
							'utk-wds'
						) }
					</Notice>
				</div>
			) }

			{ site && (
				<>
					<Notice status="success" isDismissible={ false }>
						{ sprintf(
							/* translators: %s: remote site name. */
							__( 'Connected to %s', 'utk-wds' ),
							site.name || site.url
						) }
					</Notice>

					<div style={ { marginTop: '16px' } }>
						<SelectControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Filter by', 'utk-wds' ) }
							value={ externalTaxonomy }
							options={ site.taxonomies.map( ( t ) => ( {
								label: t.name,
								value: t.rest_base,
							} ) ) }
							onChange={ ( value ) =>
								setAttributes( {
									externalTaxonomy: value,
									externalTermId: 0,
									externalTermName: '',
								} )
							}
						/>
					</div>

					<div style={ { marginTop: '16px' } }>
						<TermCombobox
							label={
								site.taxonomies.find(
									( t ) => t.rest_base === externalTaxonomy
								)?.name || __( 'Term', 'utk-wds' )
							}
							terms={ terms }
							selectedId={ externalTermId }
							selectedName={ externalTermName }
							onSearch={ setSearch }
							onChange={ ( id, name ) =>
								setAttributes( {
									externalTermId: id,
									externalTermName: name,
								} )
							}
						/>
					</div>
				</>
			) }
		</>
	);
}

/**
 * Story source controls (this site vs. another site).
 *
 * @param {Object}   props
 * @param {Object}   props.attributes
 * @param {Function} props.setAttributes
 * @return {Element} Controls.
 */
export default function SourceControls( { attributes, setAttributes } ) {
	return (
		<>
			<RadioControl
				label={ __( 'Pull stories from', 'utk-wds' ) }
				selected={ attributes.sourceType }
				options={ [
					{ label: __( 'This site', 'utk-wds' ), value: 'internal' },
					{
						label: __( 'Another UTK site', 'utk-wds' ),
						value: 'external',
					},
				] }
				onChange={ ( value ) => setAttributes( { sourceType: value } ) }
			/>
			<div style={ { marginTop: '16px' } }>
				{ attributes.sourceType === 'external' ? (
					<ExternalSource
						attributes={ attributes }
						setAttributes={ setAttributes }
					/>
				) : (
					<InternalSource
						attributes={ attributes }
						setAttributes={ setAttributes }
					/>
				) }
			</div>
		</>
	);
}
