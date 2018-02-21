Plugin Update Checker
=====================

This is a custom update checker library for WordPress plugins. It lets you add automatic update notifications and one-click upgrades to your commercial and private plugins. All you need to do is put your plugin details in a JSON file, place the file on your server, and pass the URL to the library. The library periodically checks the URL to see if there's a new version available and displays an update notification to the user if necessary.

From the users' perspective, it works just like with plugins hosted on WordPress.org. The update checker uses the default plugin upgrade UI that will already be familiar to most WordPress users.

[See this blog post](http://w-shadow.com/blog/2010/09/02/automatic-updates-for-any-plugin/) for  more information and usage instructions.

Getting Started
---------------

### Self-hosted Plugins

1. Make a JSON file that describes your plugin. Here's a minimal example:

	```json
    {
    	"name" : "My Cool Plugin",
    	"version" : "2.0",
    	"author" : "John Smith",
    	"download_url" : "http://example.com/plugins/my-cool-plugin.zip",
    	"sections" : {
    		"description" : "Plugin description here. You can use HTML."
    	}
    }
	```
	See [this table](https://spreadsheets.google.com/pub?key=0AqP80E74YcUWdEdETXZLcXhjd2w0cHMwX2U1eDlWTHc&authkey=CK7h9toK&hl=en&single=true&gid=0&output=html) for a full list of supported fields.
2. Upload this file to a publicly accessible location.
3. Download [the update checker](https://github.com/YahnisElsts/plugin-update-checker/releases/latest), unzip the archive and copy the `plugin-update-checker` directory to your plugin.
4. Add the following code to the main plugin file:

	```php
	require 'plugin-update-checker/plugin-update-checker.php';
	$myUpdateChecker = PucFactory::buildUpdateChecker(
		'http://example.com/path/to/metadata.json',
		__FILE__
	);
	```

#### Notes
- You could use [wp-update-server](https://github.com/YahnisElsts/wp-update-server) to automatically generate JSON metadata from ZIP packages.
- The second argument passed to `buildUpdateChecker` should be the full path to the main plugin file.
- There are more options available - see the [blog](http://w-shadow.com/blog/2010/09/02/automatic-updates-for-any-plugin/) for details.

### Plugins Hosted on GitHub

*(GitHub support is experimental.)*

1. Download [the latest release](https://github.com/YahnisElsts/plugin-update-checker/releases/latest), unzip it and copy the `plugin-update-checker` directory to your plugin.
2. Add the following code to the main file of your plugin:

	```php
	require 'plugin-update-checker/plugin-update-checker.php';
	$className = PucFactory::getLatestClassVersion('PucGitHubChecker');
	$myUpdateChecker = new $className(
		'https://github.com/user-name/plugin-repo-name/',
		__FILE__,
		'master'
	);
	```
	The third argument specifies the branch to use for updating your plugin. The default is `master`. If the branch name is omitted or set to `master`, the update checker will use the latest release or tag (if available). Otherwise it will use the specified branch.
3. Optional: Add a `readme.txt` file formatted according to the [WordPress.org plugin readme standard](https://wordpress.org/plugins/about/readme.txt). The contents of this file will be shown when the user clicks the "View version 1.2.3 details" link.

#### Notes

If your GitHub repository requires an access token, you can specify it like this:
```php
$myUpdateChecker->setAccessToken('your-token-here');
```

The GitHub version of the library will pull update details from the following parts of a release/tag/branch:

- Changelog
	- The "Changelog" section of `readme.txt`.
	- One of the following files:
		CHANGES.md, CHANGELOG.md, changes.md, changelog.md
	- Release notes.
- Version number
	- The "Version" plugin header.
	- The latest release or tag name.
- Required and tested WordPress versions
	- The "Requires at least" and "Tested up to" fields in `readme.txt`.
	- The following plugin headers:
		`Required WP`, `Tested WP`, `Requires at least`, `Tested up to`
- "Last updated" timestamp
	- The creation timestamp of the latest release.
	- The latest commit of the selected tag or branch that changed the main plugin file.
- Number of downloads
	- The `download_count` statistic of the latest release.
	- If you're not using GitHub releases, there will be no download stats.
- Other plugin details - author, homepage URL, description
	- The "Description" section of `readme.txt`.
	- Remote plugin headers (i.e. the latest version on GitHub).
	- Local plugin headers (i.e. the currently installed version).
- Ratings, banners, screenshots
	- Not supported.
