/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { Fragment } from 'react';

import {
  Notice,
  PanelBody,
  SelectControl,
  RangeControl,
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

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
*
* @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
*
* @return {Element} Element to render.
*/
export function Edit(props: { attributes: { content: any; headingLevel: string; colorScheme: string; childValues: any; }; setAttributes: any; className: any; context: any; clientId: any; }): Element {
  const {
    attributes: { content, childValues },
    context,
    setAttributes,
    className,
    clientId,
  } = props;

  const blockProps = useBlockProps();

  const childBlocks = useSelect(

    (select) => select('core/block-editor').getBlocks(clientId),
    [clientId]);

  console.log(childBlocks);

  const TAB_TEMPLATE: TemplateArray = [['utk-wds/tab']];

  const onChangeContent = (newContent: any) => {
    setAttributes({ content: newContent });
  };

  return (
    <Fragment>
      <div {...blockProps}>
        <div data-tab className={"utk-wds-tab-wrapper"} >
          <InnerBlocks
            allowedBlocks={ALLOWED_BLOCKS}
            template={TAB_TEMPLATE}
            renderAppender={InnerBlocks.ButtonBlockAppender}
          />
        </div>
      </div>
    </Fragment>
  );
}

export function Save(props: { attributes: { content: string; colorScheme: string; }; }) {
  const blockProps = useBlockProps.save();
  return (
    <div {...blockProps}>
      <div data-tab className={"utk-wds-tab-wrapper"} >
        <InnerBlocks.Content
        />
      </div>
    </div>
  );
}
