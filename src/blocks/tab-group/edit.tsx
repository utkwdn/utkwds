/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { useEffect } from 'react';

import {
  PanelBody,
  TextControl,
} from '@wordpress/components';

import {
  InnerBlocks,
  useBlockProps,
  InspectorControls,
} from '@wordpress/block-editor';

import { useDispatch, useSelect, select, dispatch } from '@wordpress/data';

import type { TemplateArray } from 'wordpress__blocks';
import type { Element } from '@wordpress/element';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import { TabAttributes } from '../tab/edit';

/**
 * Allowed blocks constant is passed to InnerBlocks precisely as specified here.
 * The contents of the array should never change.
 * The array should contain the name of each block that is allowed.
 * In Tab Group block, the only block we allow is 'utk-wds/tab'.
 *
 * @constant
 * @type {string[]}
 */
const ALLOWED_BLOCKS: string[] = ['utk-wds/tab'];

/**
 * Tab template constant is passed to InnerBlocks precisely as specified here.
 * The contents of the array should never change.
 * The array should contain arrays, each of which should include the name of
 * a block to be included in the Template.
 *
 * @constant
 * @type {TemplateArray}
 */
const TAB_TEMPLATE: TemplateArray = [['utk-wds/tab']];

type TabGroupAttributes = {
  tabId: string;
  tabNames?: Pick<TabAttributes, 'tabName' | 'tabSlug'>[];
};

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
*
* @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
*
* @return {Element} Element to render.
*/
export function Edit(props: {
  attributes: TabGroupAttributes;
  setAttributes: (attributes: Partial<TabGroupAttributes>) => void;
  clientId: string;
}): Element {
  const {
    attributes: { tabId },
    setAttributes,
    clientId,
  } = props;

  const blockProps = useBlockProps();

  const actions: ReturnType<typeof dispatch> = useDispatch('core/block-editor');

  const childBlocks = useSelect(_select => (
    _select as typeof select
  )('core/block-editor').getBlocks(clientId), [clientId]);

  /*
    Runs on mount and then whenever `childBlocks` has changed (i.e., when individual tabs have been edited).
    Does two things:
      1. Keeps this tab-group's `tabNames` attribute in sync with the names/slugs of the individual tabs.
      2. Sets the `tabActive` attribute of the first tab to 'active' and of all others to ''.
  */
  useEffect(() => {
    const tabNames = childBlocks.map((block) => {
      const { tabName, tabSlug } = block.attributes as TabAttributes;
      return {
        tabName,
        tabSlug,
      };
    });

    setAttributes({ tabNames });

    childBlocks.forEach((block, i) => {
      actions.updateBlockAttributes(block.clientId, { tabActive: i === 0 ? 'active' : '', tabShow: i === 0 ? 'show' : '', tabSlug: tabNames[i].tabSlug });
    });
  }, [childBlocks]);

  return (
    <>
      <InspectorControls>
        <PanelBody title='Tabs Properties' initialOpen={true}>
          <TextControl
            label='Tabs ID'
            help='The identifier for the tabs group.'
            value={tabId}
            onChange={(value) => { setAttributes({ tabId: value }); }}
          />
        </PanelBody>
      </InspectorControls>
      <div {...blockProps}>
        <div data-tab className={"utk-wds-tab-wrapper"} >
          <InnerBlocks
            allowedBlocks={ALLOWED_BLOCKS}
            template={TAB_TEMPLATE}
          />
        </div>
      </div>
    </>
  );
}

export function Save(props: {
  attributes: TabGroupAttributes
}) {
  const blockProps = useBlockProps.save();
  const { tabNames = [] } = props.attributes;

  const listItems = tabNames.map(({ tabName, tabSlug }, i) => (
    <li className="nav-item block" role="presentation" key={i}>
      <button
        className={`nav-link ${i === 0 ? 'active' : ''}`}
        id={`${tabSlug}-tab`}
        data-bs-toggle="tab"
        data-bs-target={`#${tabSlug}`}
        type="button"
        role="tab"
        aria-controls={tabSlug}
        aria-selected={i === 0}
      >{tabName}</button>
    </li>
  ));

  return (
    <div {...blockProps}>
      <ul className={"nav nav-tabs main-tabs"} id={props.attributes.tabId} role="tablist">
        {listItems}
      </ul>
      <div data-tab className={"utk-wds-tab-wrapper main-tabs-content tab-content"} >
        <InnerBlocks.Content />
      </div>
    </div>
  );
}
