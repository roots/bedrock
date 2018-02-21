<?php

if ( !class_exists('PucGitHubChecker_2_0') ):

class PucGitHubChecker_2_0 extends PluginUpdateChecker_2_0 {
	/**
	 * @var string GitHub username.
	 */
	protected $userName;
	/**
	 * @var string GitHub repository name.
	 */
	protected $repositoryName;

	/**
	 * @var string Either a fully qualified repository URL, or just "user/repo-name".
	 */
	protected $repositoryUrl;

	/**
	 * @var string The branch to use as the latest version. Defaults to "master".
	 */
	protected $branch;

	/**
	 * @var string GitHub authentication token. Optional.
	 */
	protected $accessToken;

	public function __construct(
		$repositoryUrl,
		$pluginFile,
		$branch = 'master',
		$checkPeriod = 12,
		$optionName = '',
		$muPluginFile = ''
	) {

		$this->repositoryUrl = $repositoryUrl;
		$this->branch = empty($branch) ? 'master' : $branch;

		$path = @parse_url($repositoryUrl, PHP_URL_PATH);
		if ( preg_match('@^/?(?P<username>[^/]+?)/(?P<repository>[^/#?&]+?)/?$@', $path, $matches) ) {
			$this->userName = $matches['username'];
			$this->repositoryName = $matches['repository'];
		} else {
			throw new InvalidArgumentException('Invalid GitHub repository URL: "' . $repositoryUrl . '"');
		}

		parent::__construct($repositoryUrl, $pluginFile, '', $checkPeriod, $optionName, $muPluginFile);
	}

	/**
	 * Retrieve details about the latest plugin version from GitHub.
	 *
	 * @param array $unusedQueryArgs Unused.
	 * @return PluginInfo
	 */
	public function requestInfo($unusedQueryArgs = array()) {
		$info = new PluginInfo_2_0();
		$info->filename = $this->pluginFile;
		$info->slug = $this->slug;
		$info->sections = array();

		$this->setInfoFromHeader($this->getPluginHeader(), $info);

		//Figure out which reference (tag or branch) we'll use to get the latest version of the plugin.
		$ref = $this->branch;
		if ( $this->branch === 'master' ) {
			//Use the latest release.
			$release = $this->getLatestRelease();
			if ( $release !== null ) {
				$ref = $release->tag_name;
				$info->version = ltrim($release->tag_name, 'v'); //Remove the "v" prefix from "v1.2.3".
				$info->last_updated = $release->created_at;
				$info->download_url = $release->zipball_url;

				if ( !empty($release->body) ) {
					$info->sections['changelog'] = $this->parseMarkdown($release->body);
				}
				if ( isset($release->assets[0]) ) {
					$info->downloaded = $release->assets[0]->download_count;
				}
			} else {
				//Failing that, use the tag with the highest version number.
				$tag = $this->getLatestTag();
				if ( $tag !== null ) {
					$ref = $tag->name;
					$info->version = $tag->name;
					$info->download_url = $tag->zipball_url;
				}
			}
		}

		if ( empty($info->download_url) ) {
			$info->download_url = $this->buildArchiveDownloadUrl($ref);
		}

		//Get headers from the main plugin file in this branch/tag. Its "Version" header and other metadata
		//are what the WordPress install will actually see after upgrading, so they take precedence over releases/tags.
		$mainPluginFile = basename($this->pluginFile);
		$remotePlugin = $this->getRemoteFile($mainPluginFile, $ref);
		if ( !empty($remotePlugin) ) {
			$remoteHeader = $this->getFileHeader($remotePlugin);
			$this->setInfoFromHeader($remoteHeader, $info);
		}

		//Try parsing readme.txt. If it's formatted according to WordPress.org standards, it will contain
		//a lot of useful information like the required/tested WP version, changelog, and so on.
		if ( $this->readmeTxtExistsLocally() ) {
			$readmeTxt = $this->getRemoteFile('readme.txt', $ref);
			if ( !empty($readmeTxt) ) {
				$readme = $this->parseReadme($readmeTxt);

				if ( isset($readme['sections']) ) {
					$info->sections = array_merge($info->sections, $readme['sections']);
				}
				if ( !empty($readme['tested_up_to']) ) {
					$info->tested = $readme['tested_up_to'];
				}
				if ( !empty($readme['requires_at_least']) ) {
					$info->requires = $readme['requires_at_least'];
				}

				if ( isset($readme['upgrade_notice'], $readme['upgrade_notice'][$info->version]) ) {
					$info->upgrade_notice = $readme['upgrade_notice'][$info->version];
				}
			}
		}

		//The changelog might be in a separate file.
		if ( empty($info->sections['changelog']) ) {
			$info->sections['changelog'] = $this->getRemoteChangelog($ref);
			if ( empty($info->sections['changelog']) ) {
				$info->sections['changelog'] = 'There is no changelog available.';
			}
		}

		if ( empty($info->last_updated) ) {
			//Fetch the latest commit that changed the main plugin file and use it as the "last_updated" date.
			//It's reasonable to assume that every update will change the version number in that file.
			$latestCommit = $this->getLatestCommit($mainPluginFile, $ref);
			if ( $latestCommit !== null ) {
				$info->last_updated = $latestCommit->commit->author->date;
			}
		}

		$info = apply_filters('puc_request_info_result-' . $this->slug, $info, null);
		return $info;
	}

	/**
	 * Get the latest release from GitHub.
	 *
	 * @return StdClass|null
	 */
	protected function getLatestRelease() {
		$releases = $this->api('/repos/:user/:repo/releases');
		if ( is_wp_error($releases) || !is_array($releases) || !isset($releases[0]) ) {
			return null;
		}

		$latestRelease = $releases[0];
		return $latestRelease;
	}

	/**
	 * Get the tag that looks like the highest version number.
	 *
	 * @return StdClass|null
	 */
	protected function getLatestTag() {
		$tags = $this->api('/repos/:user/:repo/tags');

		if ( is_wp_error($tags) || empty($tags) || !is_array($tags) ) {
			return null;
		}

		usort($tags, array($this, 'compareTagNames')); //Sort from highest to lowest.
		return $tags[0];
	}

	/**
	 * Compare two GitHub tags as if they were version number.
	 *
	 * @param string $tag1
	 * @param string $tag2
	 * @return int
	 */
	protected function compareTagNames($tag1, $tag2) {
		if ( !isset($tag1->name) ) {
			return 1;
		}
		if ( !isset($tag2->name) ) {
			return -1;
		}
		return -version_compare($tag1->name, $tag2->name);
	}

	/**
	 * Get the latest commit that changed the specified file.
	 *
	 * @param string $filename
	 * @param string $ref Reference name (e.g. branch or tag).
	 * @return StdClass|null
	 */
	protected function getLatestCommit($filename, $ref = 'master') {
		$commits = $this->api(
			'/repos/:user/:repo/commits',
			array(
				'path' => $filename,
				'sha' => $ref,
			)
		);
		if ( !is_wp_error($commits) && is_array($commits) && isset($commits[0]) ) {
			return $commits[0];
		}
		return null;
	}

	protected function getRemoteChangelog($ref = '') {
		$filename = $this->getChangelogFilename();
		if ( empty($filename) ) {
			return null;
		}

		$changelog = $this->getRemoteFile($filename, $ref);
		if ( $changelog === null ) {
			return null;
		}
		return $this->parseMarkdown($changelog);
	}

	protected function getChangelogFilename() {
		$pluginDirectory = dirname($this->pluginAbsolutePath);
		if ( empty($this->pluginAbsolutePath) || !is_dir($pluginDirectory) || ($pluginDirectory === '.') ) {
			return null;
		}

		$possibleNames = array('CHANGES.md', 'CHANGELOG.md', 'changes.md', 'changelog.md');
		$files = scandir($pluginDirectory);
		$foundNames = array_intersect($possibleNames, $files);

		if ( !empty($foundNames) ) {
			return reset($foundNames);
		}
		return null;
	}

	/**
	 * Convert Markdown to HTML.
	 *
	 * @param string $markdown
	 * @return string
	 */
	protected function parseMarkdown($markdown) {
		if ( !class_exists('Parsedown') ) {
			require_once(dirname(__FILE__) . '/vendor/Parsedown.php');
		}

		$instance = Parsedown::instance();
		return $instance->text($markdown);
	}

	/**
	 * Perform a GitHub API request.
	 *
	 * @param string $url
	 * @param array $queryParams
	 * @return mixed|WP_Error
	 */
	protected function api($url, $queryParams = array()) {
		$variables = array(
			'user' => $this->userName,
			'repo' => $this->repositoryName,
		);
		foreach ($variables as $name => $value) {
			$url = str_replace('/:' . $name, '/' . urlencode($value), $url);
		}
		$url = 'https://api.github.com' . $url;

		if ( !empty($this->accessToken) ) {
			$queryParams['access_token'] = $this->accessToken;
		}
		if ( !empty($queryParams) ) {
			$url = add_query_arg($queryParams, $url);
		}

		$response = wp_remote_get($url, array('timeout' => 10));
		if ( is_wp_error($response) ) {
			return $response;
		}

		$code = wp_remote_retrieve_response_code($response);
		$body = wp_remote_retrieve_body($response);
		if ( $code === 200 ) {
			$document = json_decode($body);
			return $document;
		}

		return new WP_Error(
			'puc-github-http-error',
			'GitHub API error. HTTP status: ' . $code
		);
	}

	/**
	 * Set the access token that will be used to make authenticated GitHub API requests.
	 *
	 * @param string $accessToken
	 */
	public function setAccessToken($accessToken) {
		$this->accessToken = $accessToken;
	}

	/**
	 * Get the contents of a file from a specific branch or tag.
	 *
	 * @param string $path File name.
	 * @param string $ref
	 * @return null|string Either the contents of the file, or null if the file doesn't exist or there's an error.
	 */
	protected function getRemoteFile($path, $ref = 'master') {
		$apiUrl = '/repos/:user/:repo/contents/' . $path;
		$response = $this->api($apiUrl, array('ref' => $ref));

		if ( is_wp_error($response) || !isset($response->content) || ($response->encoding !== 'base64') ) {
			return null;
		}
		return base64_decode($response->content);
	}

	/**
	 * Parse plugin metadata from the header comment.
	 * This is basically a simplified version of the get_file_data() function from /wp-includes/functions.php.
	 *
	 * @param $content
	 * @return array
	 */
	protected function getFileHeader($content) {
		$headers = array(
			'Name' => 'Plugin Name',
			'PluginURI' => 'Plugin URI',
			'Version' => 'Version',
			'Description' => 'Description',
			'Author' => 'Author',
			'AuthorURI' => 'Author URI',
			'TextDomain' => 'Text Domain',
			'DomainPath' => 'Domain Path',
			'Network' => 'Network',

			//The newest WordPress version that this plugin requires or has been tested with.
			//We support several different formats for compatibility with other libraries.
			'Tested WP' => 'Tested WP',
			'Requires WP' => 'Requires WP',
			'Tested up to' => 'Tested up to',
			'Requires at least' => 'Requires at least',
		);

		$content = str_replace("\r", "\n", $content); //Normalize line endings.
		$results = array();
		foreach ($headers as $field => $name) {
			$success = preg_match('/^[ \t\/*#@]*' . preg_quote($name, '/') . ':(.*)$/mi', $content, $matches);
			if ( ($success === 1) && $matches[1] ) {
				$results[$field] = _cleanup_header_comment($matches[1]);
			} else {
				$results[$field] = '';
			}
		}

		return $results;
	}

	/**
	 * Copy plugin metadata from a file header to a PluginInfo object.
	 *
	 * @param array $fileHeader
	 * @param PluginInfo_2_0 $pluginInfo
	 */
	protected function setInfoFromHeader($fileHeader, $pluginInfo) {
		$headerToPropertyMap = array(
			'Version' => 'version',
			'Name' => 'name',
			'PluginURI' => 'homepage',
			'Author' => 'author',
			'AuthorName' => 'author',
			'AuthorURI' => 'author_homepage',

			'Requires WP' => 'requires',
			'Tested WP' => 'tested',
			'Requires at least' => 'requires',
			'Tested up to' => 'tested',
		);
		foreach ($headerToPropertyMap as $headerName => $property) {
			if ( isset($fileHeader[$headerName]) && !empty($fileHeader[$headerName]) ) {
				$pluginInfo->$property = $fileHeader[$headerName];
			}
		}

		if ( !isset($pluginInfo->sections) ) {
			$pluginInfo->sections = array();
		}
		if ( !empty($fileHeader['Description']) ) {
			$pluginInfo->sections['description'] = $fileHeader['Description'];
		}
	}

	protected function parseReadme($content) {
		if ( !class_exists('PucReadmeParser') ) {
			require_once(dirname(__FILE__) . '/vendor/readme-parser.php');
		}
		$parser = new PucReadmeParser();
		return $parser->parse_readme_contents($content);
	}

	/**
	 * Check if the currently installed version has a readme.txt file.
	 *
	 * @return bool
	 */
	protected function readmeTxtExistsLocally() {
		$pluginDirectory = dirname($this->pluginAbsolutePath);
		if ( empty($this->pluginAbsolutePath) || !is_dir($pluginDirectory) || ($pluginDirectory === '.') ) {
			return false;
		}
		return is_file($pluginDirectory . '/readme.txt');
	}

	/**
	 * Generate a URL to download a ZIP archive of the specified branch/tag/etc.
	 *
	 * @param string $ref
	 * @return string
	 */
	protected function buildArchiveDownloadUrl($ref = 'master') {
		$url = sprintf(
			'https://api.github.com/repos/%1$s/%2$s/zipball/%3$s',
			urlencode($this->userName),
			urlencode($this->repositoryName),
			urlencode($ref)
		);
		if ( !empty($this->accessToken) ) {
			$url = add_query_arg('access_token', $this->accessToken, $url);
		}
		return $url;
	}
}

endif;