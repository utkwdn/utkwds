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
import {
  useBlockProps,
  RichText,
  InnerBlocks,
  BlockAttributes
} from '@wordpress/block-editor';

import { cleanForSlug } from '@wordpress/url';

import { useEffect } from 'react';

import { withDispatch, useDispatch, useSelect, select, dispatch } from '@wordpress/data';

import type { BlockSaveProps } from 'wordpress__blocks';
import type { Element } from '@wordpress/element';

import { HeadingDynamic } from '../../utils/customElements';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

type HeadingTag = 'h2' | 'h3';

type EditProps = {
  "context": {
    'utk-wds-tab-group/headingLevel': HeadingTag
  },
  "attributes": {
    "panelTitle": string,
    "headingLevel": 'h2' | 'h3',
    "tabName": string,
  },
  "setAttributes": any,
  "clientId": any
}





/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
*
* @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
*
* @return {Element} Element to render.
*/
export function Edit({ context, attributes, setAttributes, clientId }: EditProps): Element {

  const blockProps = useBlockProps();

  // TODO: make sure that this first element is always the immediate tab-group parent.
  const [parentBlock]: string[] = select('core/block-editor').getBlockParents(clientId);

  const setTabNames = () => {
    const [parentBlockObj] = select('core/block-editor').getBlocksByClientId(parentBlock);

    if (!parentBlockObj) return;

    const tabNames = parentBlockObj.innerBlocks.map((block) => ({
      tabName: block.attributes.tabName,
      tabSlug: block.attributes.tabSlug,
      /*
        TODO: Set up control for this `tabActive` value.
        What does it even do? Maybe Bootstrap docs will tell us.
        Coordinate value w/ tab-group Save function. (Maybe use boolean for this?)
      */
      tabActive: block.attributes.tabActive
    }));

    console.log({ tabNames });

    dispatch('core/block-editor').updateBlockAttributes(
      parentBlock,
      { tabNames }
    );
  };

  useEffect(() => {
    setAttributes({ headingLevel: context['utk-wds-tab-group/headingLevel'] });
  }, [context, setAttributes]);

  useEffect(() => {
    setTabNames();
    return () => {
      // Not sure if this is necessary, but run on component un-mount in case it's needed for the deletion case.
      setTabNames();
    }
  }, [setTabNames]); // right now will run on every render (b/c `setTabNames` always gets redefined); good or bad?

  return (
    <div {...blockProps}>
      <RichText
        tagName='h3'
        className={"tab-name"}
        value={attributes.tabName}
        onChange={(value) => {
          setAttributes({ tabName: value, tabSlug: 'tab-' + cleanForSlug(value) });
        }}
      />
      <div className="utk-wds-tab__panel-body">
        <InnerBlocks />
      </div>
    </div>
  );
}

interface PanelSaveAttributes extends BlockAttributes {
  panelTitle: string;
  tabNames: string;
}

export function Save({ attributes }: { attributes: PanelSaveAttributes }) {
  const blockProps = useBlockProps.save();
  return (
    <div {...blockProps}>
      <section data-tab-section>
        <div className="utk-wds-tab__panel-body">
          <InnerBlocks.Content />
        </div>
      </section>
    </div>
  );
}