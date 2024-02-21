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

export type TabAttributes = {
  panelTitle?: string;
  tabName: string;
  tabPlaceholder?: string;
  tabSlug: string;
  tabActive?: string;
  tabShow?: string;
}

type EditProps = {
  attributes: TabAttributes,
  setAttributes: (attributes: Partial<TabAttributes>) => void;
  clientId: string;
}

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
*
* @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
*
* @return {Element} Element to render.
*/
export function Edit({ attributes, setAttributes, clientId }: EditProps): Element {

  const blockProps = useBlockProps();

  // TODO: figure out the whole `tabActive` thing

  return (
    <div {...blockProps}>
      <RichText
        tagName='h3'
        className={"tab-name"}
        value={attributes.tabName || ''}
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

export function Save({ attributes }: { attributes: TabAttributes }) {
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