<p align="center">
  <a href="https://www.utk.edu/">
    <img src="https://images.utk.edu/designsystem/2020/assets/i/icon-114x114.png" alt="Power T">
  </a>
</p>

<h3 align="center">University of Tennessee, Knoxville Design System Theme</h3>

---

The Official UT Digital Design System Theme (UTKSDS) was made to help UT web developers build interfaces that match UT's visual identity and make consistent the user interface of a variety of digital products.

---

This repository includes a theme and a plugin.

The theme is built from the `src` directory, using the directions listed under [Installing this project](#installing-this-project). When build, all theme files will be in the `build` directory. This directory can be copied or symlinked into a WordPress site's `wp-content/themes/` directory and activated like any other theme.

The plugin, `utk-wds-breadcrumbs`, is located in the `/plugins/` directory. This plugin must be active in order for the
breadcrumb navigation in the page headers to work. If the plugin is not installed and active, the site will be unaffected except that the breadcrumbs will be absent. Consult the `ReadMe.md` file in the plugin's directory for more information about using the breadcrumb navigation block.

## Installing this project

### Step 1, Installing the requirements

The UTKSDS uses Node and Gulp to compile and compress Javascript and CSS from source files. To modify this project, you must use Node 14 and Gulp.

1. Not required, but highly recommended. [Install NVM by following these instructions](https://github.com/nvm-sh/nvm#installing-and-updating). **Mac Users**: If you get an "nvm: command not found" error after running the install script (and you likely will), be sure to [follow the troubleshooting steps](https://github.com/nvm-sh/nvm#troubleshooting-on-macos).
2. Install Node.js **Important**: [Install using NVM (recommended)](https://www.linode.com/docs/guides/how-to-install-use-node-version-manager-nvm/#using-nvm-to-install-node).

### Step 2, Installing the this project

1. Download or `git clone` this project by typing `git clone git@github.com:utkwdn/utksds-framework.git`.
2. In your terminal, change to the new `/utksds-framework/` directory.
3. Ensure you are running Node.js 14 prior to installation, by typing `node -v`
4. Type `npm install` to install dependencies.

### Step 3, Building the Plugin(s)

For each plugin in the `/plugins/` directory, check for a `ReadMe` file. Perform any build steps indicated in the plugin documentation.

---

## Developing or building the theme

The NPM commands are:

- `npm run dev` runs continually and watches the `\src\` directory for changes. When you change a file, it rebuilds the theme in the `\build\` directory.
- `npm run build` will build a testing theme.
- `npm run dist` will minimize all images and css and javascript for production and place a production ready version of the theme in the `\dist\` directory.

**Note**: The JS and CSS is edited in the framework project. The theme references [javascript](https://images.utk.edu/designsystem/v1/latest/assets/js/utk.js) and [css](https://images.utk.edu/designsystem/v1/latest/assets/css/style.css) files on the images server.
