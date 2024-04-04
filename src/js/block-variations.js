import { registerBlockVariation, registerBlockStyle } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

registerBlockVariation(

  'core/paragraph', {
    name: 'fancy-link',
    title: 'Fancy Link',
    attributes: 
      { 
        className: 'is-style-utkwds-fancy-link',
        content: '<a href="https://www.utk.edu/">Fancy Link</a>',
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
    attributes: 
      { 
        className: 'is-style-utkwds-link-group-2up',
      },
    icon: 'editor-ul',
    innerBlocks: [
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 1</a>' } ],
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 2</a>' } ],
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 3</a>' } ],
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
    attributes: 
      { 
        className: 'is-style-utkwds-link-group-3up',
      },
    icon: 'editor-ul',
    innerBlocks: [
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 1</a>' } ],
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 2</a>' } ],
      [ 'core/list-item', { content: '<a href="https://www.utk.edu/">Link 3</a>' } ],
    ],
    isActive: [
      'className'
    ],
    scope: ['block'],
  }
);