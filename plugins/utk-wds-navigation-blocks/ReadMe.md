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

## Using the Nav Menu block

The Nav Menu block retrieves the links inside of a WordPress menu (created using the
settings page at `Appearance > Menus`) and displays them as an HTML [`<menu>`](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/menu) element.

At this time, the block does not support nested menus. That feature may be added in a later release.

Although this plugin registers a WordPress Block, that block is not available in the editor. Instead, it can be added to block patterns and templates using its markup.

The block requires a `menuName` attribute to function. The attribute value can be a menu name, slug, or id,
as described in the WordPress documentation for [`wp_get_nav_menu_items()`](http://developer.wordpress.org/reference/functions/wp_get_nav_menu_items/).

If no `menuName` is passed, if there is no menu matching `menuName`, or if the matching menu has no items,
the block will return an empty string.

```html
<!-- wp:utk-wds/nav-menu { "menuName": "Main Nav Menu" } /-->
```

## Customizing a Nav Menu

### Nav Menu Markup

For reference, the default HTML markup with class names is:

```html
<div class="wp-block-utk-wds-nav-menu utk-nav-menu-wrapper">
  <menu class="utk-nav-menu">
    <li><a href="#">First Menu Item</a></li>
    <li><a href="#">Second Menu Item</a></li>
    <li><a href="#">Third Menu Item</a></li>
  </menu>
</div>

```

### Supporting Nested Menus

If you want to display multiple levels of menus, i.e. menu items that are children of
other menu items, pass a value for the `depth` property when you insert the block.

```html
<!-- wp:utk-wds/nav-menu { "menuName": "Main Nav Menu", "depth": 1 } /-->
```

```html
<!-- Example Output -->
<div class="wp-block-utk-wds-nav-menu utk-nav-menu-wrapper">
  <menu class="utk-nav-menu">
    <li><a href="#">First Menu Item</a>
      <ul>
        <li><a href="#">Submenu Item 1</a></li>
        <li><a href="#">Submenu Item 2</a></li>
      </ul>
    </li>
    <li><a href="#">Second Menu Item</a></li>
    <li><a href="#">Third Menu Item</a></li>
  </menu>
</div>
```

### Nav Menu CSS settings

The appearance of any nav menu can be modified using CSS. Although you can target any part of the block using its CSS selector, the safest way to modify most common settings is by using a set of CSS custom properties provided by the plugin.

The available custom properties and their default values are listed below:

```css
.some-parent-class {
  /* Unless you can guarantee full browser support for the
  * gap property for Flexbox (https://caniuse.com/flexbox-gap),
  * (mostly an issue with Safari before version 14.1),
  * `--utk-nav-menu--item--spacing-y` should be 0 when
  * `--utk-nav-menu--direction` is `row`, and
  * `--utk-nav-menu--item--spacing-x` should be 0 when
  * `--utk-nav-menu--direction` is `column`.
 */
 --utk-nav-menu--direction: row;        // <row|column|row-reverse|column-reverse>
 --utk-nav-menu--item--spacing-x: 1rem; // <length|percentage>
 --utk-nav-menu--item--spacing-y: 0;    // <length|percentage>

  --utk-nav-menu--font-size: inherit;

 /* Sets the appearance of the optional dividers between items, using the `content` property
     on each breadcrumb's `::before` pseudo-element. If left as `none`, no divider will be
     rendered at all. A fallback of an empty string will be used on browsers that support it. */
  --utk-nav-menu--divider--content: none; // <string|none>
  /* Color of the divider (if you want it to be different than the base text color) */
  --utk-nav-menu--divider--color: inherit; // <color|inherit>

  /* Regular and hover state colors for linked items. If not set, these will use your site's
     global link color settings. */
  --utk-nav-menu--link-color: blue;       // <color|inherit>
  --utk-nav-menu--link-hover-color: purple; // <color|inherit>

  /* By default, disabled links look like normal text */
  --utk-nav-menu--link-disabled-color: inherit; // <color|inherit>

}
```

## Using the Breadcrumbs block

Although this plugin registers a WordPress Block, that block is not available in the editor. Instead, it can be added to block patterns and templates using its markup:

```html
<!-- wp:utk-wds/breadcrumbs /-->
```

### Breadcrumb Navigation behavior by context

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
<div class="wp-block-utk-wds-breadcrumbs utk-breadcrumbs-wrapper">
  <ul class="utk-breadcrumbs">
    <li><a href="#">Home</a></li>
    <li><a href="#">Parent Page</a></li>
    <li><a href="#" aria-disabled="true">Current Page</a></li>
  </ul>
</div>

```

### Breadcrumbs CSS settings

The appearance of the breadcrumb navigation can be modified using CSS. Although you can target any part of the block using its CSS selector, the safest way to modify most common settings is by using a set of CSS custom properties provided by the plugin.

The available custom properties and their default values are listed below:

```css
.some-parent-class {
  --utk-breadcrumb--font-size: inherit; // <length|percentage?inherit>

  /* Sets the appearance of the optional dividers between items, using the `content` property
     on each breadcrumb's `::before` pseudo-element. If left as `none`, no divider will be
     rendered at all. A fallback of an empty string will be used on browsers that support it. */
  --utk-breadcrumb--divider--content: '/'; // <string|none>

  /* Color of the divider (if you want it to be different than the base text color) */
  --utk-breadcrumb--divider--color: inherit; // <color|inherit>

  /* Sets the amount of space on either side of the divider */
  --utk-breadcrumb--item--spacing-x: 0.5rem; // <length|percentage>

  /* Regular and hover state colors for linked items. If not set, these will use your site's
     global link color settings. */
  --utk-breadcrumb--link-color: var(--wp--preset--color--link); // <color|inherit>
  --utk-breadcrumb--link-hover-color: var(--wp--preset--color--link-hover); // <color|inherit>
  --utk-breadcrumb--link-disabled-color: inherit; // <color|inherit>
}
```

## Adding Classes to the Root

For all block types in this plugin, to add a class directly to the root object for the block,
pass a value to the block's `className` attribute when you insert it:

```html
<!-- wp:utk-wds/breadcrumbs {"className": "my-custom-class another-custom-class"} /-->
<!-- wp:utk-wds/nav-menu {menuName="Main Nav Menu", "className": "my-custom-class another-custom-class"} /-->
```

## Local Development

This plugin was created with the official [`@wordpress/create-block`](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-create-block/) scaffolding tool. Its source files must be built before the plugin can function.

To enable automated builds whenever you change the source files, run `npm start` from the plugin's root directory.

To perform a one-time build, use `npm run build`.

The plugin's `readme.txt` file, which is formatted according to WordPress standards, is auto-generated from this MarkDown ReadMe file. It should not be edited directly or committed to version control. A new copy of the text file will be generated every time `npm run build` is run; it will not be auto-built along with the rest of the plugin when you use `npm start`. To manually update `readme.txt`, run `npm run wp-readme`.
