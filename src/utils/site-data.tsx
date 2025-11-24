import { store as coreStore } from '@wordpress/core-data';

// Get the title of the current WordPress site. Should be used inside a
// `useEffect()` call, e.g.:
//
// const title = useSelect( getSiteTitle, [] );
//
const getSiteTitle = ( select ) => {
	const { canUser, getEntityRecord, getEditedEntityRecord } =
		select( coreStore );
	const canEdit = canUser( 'update', 'settings' );
	const settings = canEdit ? getEditedEntityRecord( 'root', 'site' ) : {};
	const readOnlySettings = getEntityRecord( 'root', '__unstableBase' );

	return canEdit ? settings?.title : readOnlySettings?.name;
};

export { getSiteTitle };
