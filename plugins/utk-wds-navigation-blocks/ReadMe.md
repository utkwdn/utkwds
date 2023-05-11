---
Name: UTK Navigation Blocks
Contributors:      NewCity &#x2F; UTK
Tags:              block
Tested up to:      6.1
Stable tag:        0.1.0
License:           NONE
---

Breadcrumb navigation intended for use in the global site header.

## Description

Adds a block that contains an auto-generated list of breadcrumb links with minimal formatting.

The block is intended to be used within block patterns and template parts, such as a page header, and is not available in the block inserter.

## Installation

1. If you are building this plugin from source, run `npm run build` from the plugin's root directory (the same directory where this ReadMe file is located)
2. Upload the plugin files to the `/wp-content/plugins/utk-wds-navigation-blocks` directory
3. Activate the plugin through the 'Plugins' screen in WordPress

<!-- ## Frequently Asked Questions

### A question that someone might have

An answer to that question.

### What about foo bar?

Answer to foo bar dilemma.

## Screenshots

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

## Changelog

### 0.1.0

* Release -->

## Using the Breadcrumbs block

Although this plugin registers a WordPress Block, that block is not available in the editor. Instead, it can be added to block patterns and templates using its markup:

```html
<!-- wp:utk-wds/breadcrumbs /-->
```

## Breadcrumb Navigation behavior by context

### Front Page

If the current page returns `true` for `is_front_page()`, no links will be displayed.

### Pages / Hierarchical Post Types

Returns a list of links starting with `Home` and including each ancestor of the current page.

**Example:** `Home / Section / Sub-Section / This Page`

### Posts / Non-Hierarchical Post Types

For the `post` post type, returns a list that includes `Home` and the current post.

For other non-Hierarchical post types, includes a link to the post type's archive page.

**Example:** `Home > People > John Doe`

### Archive Pages

Link to Home, followed by the name of the current archive.

**Example:** `Home > People`

## Customizing the Breadcrumbs

### Breadcrumbs Markup

For reference, the default HTML markup with class names is:

```html
<div class="utk-breadcrumbs-wrapper">
  <ul class="utk-breadcrumbs">
    <li><a href="#">Home</a></li>
    <li><a href="#">Parent Page</a></li>
    <li><a href="#" aria-disabled="true">Current Page</a></li>
  </ul>
</div>

```

### CSS settings

The appearance of the breacrumb navigation can be modified using CSS. Although you can target any part of the block using their CSS selectors, the safest way to modify most common settings is by using a set of CSS custom properties provided by the plugin.

```css
.utk-breadcrumbs {
  /* Sets the appearance of the dividers between items, using the `content` property
     on each breadcrumb's `::before` pseudo-element */
  --utk-breadcrumb--divider--content: '/'; // Default: '/'

  /* Sets the amount of space on either side of the divider */
  --utk-breadcrumb--divider--spacing: 0.25rem; // Default: 0.25rem

  /* Regular and hover state colors for linked items. If not set, these will use your site's
     global link color settings. */
  --utk-breadcrumb--link-color: var(--wp--preset--color--link); // Default: var(--wp--preset--color--link)
  --utk-breadcrumb--link-hover-color: ''; // Default: ''

  /* Color of the divider (if you want it to be different than the base text color) */
  --utk-breadcrumb--divider--color: inherit; // Default: inherit
}
```

### Adding Classes to the Root

To add a class directly to the root object for the block, pass a value to the block's `className` attribute
when you insert it:

```html
<!-- wp:utk-wds/breadcrumbs {"className": "my-custom-class another-custom-class"} /-->
```

## Local Development

This plugin was created with the official [`@wordpress/create-block`](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-create-block/) scaffolding tool. Its source files must be built before the plugin can function.

To enable automated builds whenever you change the source files, run `npm start` from the plugin's root directory.

To perform a one-time build, use `npm run build`.

The plugin's `readme.txt` file, which is formatted according to WordPress standards, is auto-generated from this MarkDown ReadMe file. It should not be edited directly or committed to version control. A new copy of the text file will be generated every time `npm run build` is run; it will not be auto-built along with the rest of the plugin when you use `npm start`. To manually update `readme.txt`, run `npm run wp-readme`.
