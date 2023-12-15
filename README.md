<p align="center">
  <a href="https://www.utk.edu/">
    <img src="https://images.utk.edu/designsystem/2020/assets/i/icon-114x114.png" alt="Power T">
  </a>
</p>

<h3 align="center">University of Tennessee, Knoxville Web Design System Theme</h3>

---

The Official UT Web Design System Theme (UTKWDS) was made to help UT web developers build interfaces that match UT's visual identity and make consistent the user interface of a variety of digital products.

---

The theme is built from the `src` directory, using the directions listed under [Installing this project](#installing-this-project). When built, all theme files will be in the `build` directory.

## Installing this project

### Step 1, Installing the requirements

The UTKWDS uses Node and Webpack compile the theme. You will need to install Node.js and NPM to build the theme.

1. Not required, but highly recommended. [Install NVM by following these instructions](https://github.com/nvm-sh/nvm#installing-and-updating). **Mac Users**: If you get an "nvm: command not found" error after running the install script (and you likely will), be sure to [follow the troubleshooting steps](https://github.com/nvm-sh/nvm#troubleshooting-on-macos).
2. Install Node.js **Important**: [Install using NVM (recommended)](https://www.linode.com/docs/guides/how-to-install-use-node-version-manager-nvm/#using-nvm-to-install-node).

### Step 2, Installing the this project

1. Download or `git clone` this project by typing `git clone git@github.com:utkwdn/utkwds.git`.
2. In your terminal, change to the new `/utkwds/` directory.
3. Ensure you are running Node.js 16 prior to installation, by typing `node -v`
4. Type `npm install` to install dependencies.

### Step 3, Building the theme

1. In your terminal, change to the `/utkwds/` directory.
2. Type `npm run build` to build the theme.
3. The theme will be built in the `/build/` directory.

**Note**: If you are using Visual Studio Code, the build process will automatically run when you open the editor. Tasks can be stopped and restarted using the `Terminal` menu.

---

## Developing or building the theme

The NPM commands are:

- `npm run dev` runs continually and watches the `\src\` directory for changes. When you change a file, it rebuilds the theme in the `\build\` directory.
- `npm run build` will build a testing theme.
- `npm run dist` will minimize all images and css and javascript for production and place a production ready version of the theme in the `\dist\` directory along with a zip file of the theme that can be uploaded to WordPress.
- `npm run wp-env start` will start a local WordPress environment for testing the theme. This requires Docker to be installed on your machine.
- `npm run wp-env stop` will stop the local WordPress environment.
- `npm run wp-env -- --xdebug` will restart the local WordPress environment with Xdebug enabled.
