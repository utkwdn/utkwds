const fs = require('fs');
const path = require('path');

var wp_readme_replace = function (target_file) {
	if (!fs.existsSync(target_file)) {
		throw new Error(`File not found: ${target_file}`);
	}

	const realDirName = path.dirname(fs.realpathSync(target_file));

	fs.access(realDirName, fs.constants.W_OK, (err) => {
		if (err) {
			throw new Error(`Directory not writeable: ${realDirName}`);
		}
	});

	// Create a new file in the same directory with the same filename, but with the .txt extension
	let target_file_txt = target_file.replace(/\.md$/i, '.txt');
	// If the file already exists, rename it with the .bak extension
	if (fs.existsSync(target_file_txt)) {
		fs.renameSync(target_file_txt, target_file_txt + '.bak');
	}
	// Run the contents of target_file through the wp_readme_convert_string function
	let readme_contents = fs.readFileSync(target_file, 'utf8');
	let readme_contents_txt = wp_readme_convert_string(readme_contents);
	// Write the converted contents to the new file
	fs.writeFileSync(target_file_txt, readme_contents_txt);

	return true;
};

function wp_convert_frontmatter(string) {
	// Get frontmatter
	let frontmatter = string.match(/---\n(.*?)\n---/s);

	// Remove all lines that match --- from frontmatter
	frontmatter = frontmatter[0].replace(/---\n?/g, '');

	// If the first line in frontmatter starts with `Name:`, remove `Name:` and add `===` to the beginning of the line and add ` ===` to the end of the line
	frontmatter = frontmatter.replace(/^Name: (.*)$/m, '=== $1 ===');

	// replace original frontmatter with new text
	return string.replace(/---\n(.*?)\n---/s, frontmatter);
}

function remove_comments(string) {
	// Remove all html comments, including multiline comments
	return string.replace(/<!--(.*?)-->/gsu, '');
}

function wp_readme_convert_string(string) {
	// Control visibility.
	string = wp_readme_visibility(string);
	// Replace headers.
	string = string.replace(/^(#+)\s+(.*)/gmu, function (match, p1, p2) {
		var length = p1.length;
		var sep = '';
		for (var i = 1, l = 3 - (length - 1); i <= l; i++) {
			sep += '=';
		}

		return sep + ' ' + p2 + ' ' + sep;
	});

	// Replace frontmatter.
	string = wp_convert_frontmatter(string);

	// Remove comments.
	// string = remove_comments(string);

	// Format code.
	string = string.replace(/```([^\n`]*?)\n(.*?)\n```/gsu, '~~~$1\n$2\n~~~');

	return string;
}

function wp_readme_visibility(string) {
	// Remove github comment
	string = string.replace(
		/<!-- only:github\/ -->(.*?)<!-- \/only:github -->/g,
		''
	);

	string = string.replace(
		/<!-- only:wp>(.*?)<\/only:wp -->/gi,
		function (matches) {
			return matches[0].trim();
		}
	);
	// 	// Handle env variable.
	const readmeEnv = process.env.WP_README_ENV;
	if (readmeEnv) {
		const regex = `/<!-- only:${readmeEnv}>(.*?)</only:${readmeEnv} -->/gi`;
		string = string.replace(regex, function (matches) {
			return matches[1].trim();
		});
		string = string.replace(
			/<!-- not:([^\/]+)\/ -->(.*?)<!-- \/not:[^ ]+ -->/gi,
			function (matches) {
				if (readmeEnv === matches[1]) {
					return matches[2].trim();
				} else {
					return '';
				}
			}
		);
	}
	return string;
}

wp_readme_replace('./ReadMe.md');
