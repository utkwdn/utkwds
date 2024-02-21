/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { Fragment, useEffect } from 'react';

import {
  Notice,
  PanelBody,
  SelectControl,
  RangeControl,
  TextControl,
  ToggleControl,
} from '@wordpress/components';

import {
  InnerBlocks,
  RichText,
  useBlockProps,
  store as blockEditorStore,
  InspectorControls,
} from '@wordpress/block-editor';

import { withDispatch, useDispatch, useSelect, select } from '@wordpress/data';

import {
  createBlock,
  store as blocksStore,
} from '@wordpress/blocks';

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
	tabNames?: Pick<TabAttributes, 'tabName' | 'tabSlug' | 'tabActive'>[];
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

	const childBlocks = useSelect(_select => (
		_select as typeof select
	)('core/block-editor').getBlocks(clientId), [clientId]);

	useEffect(() => {
		console.log('tab-group Edit effect running to update `tabNames` attribute');

		const tabNames = childBlocks.map((block) => {
			const { tabName, tabSlug, tabActive } = block.attributes as TabAttributes;
			return {
				tabName,
				tabSlug,
				/*
					TODO: Set up control for this `tabActive` value in the Tab's Edit component.
					What does it even do? Maybe Bootstrap docs will tell us.
					Coordinate value w/ Save function in this file. (Maybe use boolean for this instead of string?)
				*/
				tabActive
			};
		});
	
		setAttributes({ tabNames });
	}, [childBlocks]); // don't run on re-render unless `childBlocks` has changed

  return (
    <Fragment>
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
    </Fragment>
  );
}

export function Save(props: {
	attributes: TabGroupAttributes
}) {
  const blockProps = useBlockProps.save();
	const { tabNames = [] } = props.attributes;

  const listItems = tabNames.map(({ tabName, tabSlug, tabActive }) => (
		<li className="nav-item" role="presentation">
			<button
				className={"nav-link " + (tabActive || '')} /* TODO: figure out this `tabActive` business */
				id={tabSlug + "-tab"}
				data-bs-toggle="tab"
				data-bs-target={"#" + tabSlug}
				type="button"
				role="tab"
				aria-controls={tabSlug}
				aria-selected="true" /* TODO: probably shouldn't be `true` by default? */
			>{tabName}</button>
		</li>
	));

  return (
    <div {...blockProps}>
      <ul className={"nav nav-tabs"} id={props.attributes.tabId}>
        {listItems}
      </ul>
      <div data-tab className={"utk-wds-tab-wrapper tab-content"} >
        <InnerBlocks.Content
        />
      </div>
    </div>
  );
}
