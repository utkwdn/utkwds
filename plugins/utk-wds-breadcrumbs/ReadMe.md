---
Name: Breadcrumbs
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
2. Upload the plugin files to the `/wp-content/plugins/utk-wds-breadcrumbs` directory
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

## Local Development

This plugin was created with the official [`@wordpress/create-block`](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-create-block/) scaffolding tool. Its source files must be built before the plugin can function.

To enable automated builds whenever you change the source files, run `npm start` from the plugin's root directory.

To perform a one-time build, use `npm run build`.

The plugin's `readme.txt` file, which is formatted according to WordPress standards, is auto-generated from this MarkDown ReadMe file. It should not be edited directly or committed to version control. A new copy of the text file will be generated every time `npm run build` is run; it will not be auto-built along with the rest of the plugin when you use `npm start`. To manually update `readme.txt`, run `npm run wp-readme`.
