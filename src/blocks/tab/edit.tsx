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

import { withDispatch, useDispatch, useSelect, select } from '@wordpress/data';

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


  useEffect(() => {
    setAttributes({ headingLevel: context['utk-wds-tab-group/headingLevel'] });

  }, [context, setAttributes]);

  const setTabNames = (parentBlock: any) => {

    const tabsTitle: string[] = [];

    //console.log("parent " + parentBlock);

    const childBlocks = select('core/block-editor').getBlocksByClientId(parentBlock);

    //console.log(childBlocks);

    childBlocks[0].innerBlocks.map((block: { attributes: { tabShow: any, tabName: any, tabSlug: any, tabActive: any } }, index: number) => {
      if (index === 0) {
        setAttributes({ tabActive: 'active', tabShow: 'show' });
      }
      console.log(block.attributes);
      tabsTitle.push({ tabNames: block.attributes.tabName, tabSlug: block.attributes.tabSlug, tabActive: block.attributes.tabActive });
    });

    //console.log(tabsTitle);

    setAttributes({ tabNames: tabsTitle });

  }

  const parentBlock = select('core/block-editor').getBlockParents(clientId);

  return (
    <div {...blockProps}>
      <RichText
        tagName='h3'
        className={"tab-name"}
        value={attributes.tabName}
        onChange={(value) => {
          setAttributes({ tabName: value, tabSlug: 'tab-' + cleanForSlug(value) });

          setTabNames(parentBlock);
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