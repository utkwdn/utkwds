const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');
const fs = require('fs');
const glob = require('glob');

const conditionalReplace = (propValue, searchString, replaceString) => {
	if (Array.isArray(propValue)) {
		propValue.map((filePath) => filePath.replace(searchString, replaceString));
	} else {
		propValue = propValue.replace(searchString, replaceString);
	}

	return propValue;
};

const rename = () => {
	const { join } = path;

	const blockJsonFiles = glob.sync(
		join(process.cwd(), 'build', '**', 'block.json')
	);

	if (blockJsonFiles) {
		blockJsonFiles.forEach((filePath) => {
			let blockJson = require(filePath);

			if (blockJson?.editorScript) {
				blockJson.editorScript = blockJson.editorScript.replace('.tsx', '.js');
			}

			if (blockJson?.script) {
				blockJson.script = conditionalReplace(blockJson.script, '.tsx', '.js');
			}

			if (blockJson?.viewScript) {
				blockJson.viewScript = conditionalReplace(
					blockJson.viewScript,
					'.ts',
					'.js'
				);
			}

			if (blockJson?.editorStyle) {
				blockJson.editorStyle = blockJson.editorStyle.replace('.scss', '.css');
				blockJson.editorStyle = conditionalReplace(
					blockJson.editorStyle,
					'.scss',
					'.css'
				);
			}

			if (blockJson?.style) {
				blockJson.style = conditionalReplace(blockJson.style, '.scss', '.css');
			}

			fs.writeFile(
				filePath,
				JSON.stringify(blockJson, null, 2),
				function writeJSON(error) {
					if (error) {
						return console.log(error);
					}
				}
			);
		});
	}
};

module.exports = (env) => {
	return {
		...defaultConfig,

		module: {
			...defaultConfig.module,
		},

		plugins: [
			...defaultConfig.plugins,

			{
				apply: (compiler) => {
					compiler.hooks.afterEmit.tap('rename', rename);
				},
			},
		],
	};
};
