import { registerBlockVariation, registerBlockStyle } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

registerBlockVariation(

  'core/paragraph', {
    name: 'cta-link',
    title: 'CTA Link',
    description: 'A call to action is something you want a user to do (versus somewhere you want them to go). Function as a supporting button, taking the user down a task-path that leads to an interaction.',
    keywords: [ __( 'call to action' ), __( 'button' ), __( 'cta' ), __( 'fancy link' ), __( 'arrow' )],
    attributes: 
      { 
        className: 'is-style-utkwds-cta-link',
        content: '<a href="https://www.utk.edu/">CTA Link</a>',
      },
    icon: 'admin-links',
    isActive: [
      'className'
    ],
  }

);

registerBlockVariation(

  'core/paragraph', {
    name: 'single-link',
    title: 'Single Link',
    description: 'For medium emphasis, like at the end of a paragraph. Limit to 30 characters to keep it "clickable."',
    keywords: [ __( 'link' ), __( 'links' ), __( 'single' ), __( 'standalone' ), __( 'fancy' )],
    attributes: 
      { 
        className: 'is-style-utkwds-single-link',
        content: '<a href="https://www.utk.edu/">Single Link</a>',
      },
    icon: 'admin-links',
    isActive: [
      'className'
    ],
  }
);

registerBlockVariation( 

  'core/list', {
    name: 'link-group-2up',
    title: 'Link Group 2up',
    description: 'For a list of links in 2 columns.',
    keywords: [ __( 'links' ), __( 'links' ), __( 'link list' ), __( 'link group' ), __( 'collection'), __( 'columns' ), __( 'columned' ), __( '2'), __( '2up' ), __( 'two' )],
    attributes: 
      { 
        className: 'is-style-utkwds-link-group-2up',
      },
    icon: 'editor-ul',
    innerBlocks: [
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 1</a>' } ],
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 2</a>' } ],
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 3</a>' } ],
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 4</a>' } ],
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 5</a>' } ],
    ],
    isActive: [
      'className'
    ],
    scope: ['block'],
  }
);

registerBlockVariation( 

  'core/list', {
    name: 'link-group-3up',
    title: 'Link Group 3up',
    description: 'For a list of links in 3 columns.',
    keywords: [ __( 'links' ), __( 'links' ), __( 'link list' ), __( 'link group' ), __( 'collection'), __( 'columns' ), __( 'columned' ), __( '3'), __( '3up' ), __( 'three' )],
    attributes: 
      { 
        className: 'is-style-utkwds-link-group-3up',
      },
    icon: 'editor-ul',
    innerBlocks: [
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 1</a>' } ],
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 2</a>' } ],
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 3</a>' } ],
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 4</a>' } ],
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 5</a>' } ],
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 6</a>' } ],
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 7</a>' } ],
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 8</a>' } ],
    ],
    isActive: [
      'className'
    ],
    scope: ['block'],
  }
);