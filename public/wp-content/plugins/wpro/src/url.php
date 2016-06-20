<?php

// There is no normalizing of URLs anymore. If some backend needs normalizing, it should be in the backend code...

if (!defined('ABSPATH')) exit();

class WPRO_Url {

	function __construct() {
		add_filter('upload_dir', array($this, 'upload_dir')); // Sets the paths and urls for uploads.
	}

	// Returns the URL to an attachment. $file can be a URL or a file path.
	function attachmentUrl($file) {
		$baseurl = apply_filters('wpro_backend_retrieval_baseurl', '');
		return rtrim($baseurl, '/') . '/' . ltrim($this->relativePath($file), '/');
	}

	// Returns a temporary location in the filesystem, where we can store the file during the current request.
	function tmpFilePath($file) {
		$path = wpro()->tmpdir->reqTmpDir() . '/' . ltrim($this->relativePath($file), '/');
		if (!is_dir(dirname($path))) mkdir(dirname($path), 0777, true);
		return $path;
	}

	// Returns the relative part (the ending) of a url or file path.
	function relativePath($url) {
		$file = explode('/', $url);
		$parts = count($file);
		$file = $file[$parts - 3] . '/' . $file[$parts - 2] . '/' . $file[$parts - 1];
		return $file;
	}

	function upload_dir($data) {
		$log = wpro()->debug->logblock('WPRO_Url::upload_dir()');

		$backend = wpro()->backends->active_backend;
		if (is_null($backend)) return $log->logreturn($data);

		$baseurl = trim(apply_filters('wpro_backend_retrieval_baseurl', $data['baseurl']), '/');

		return $log->logreturn(array(
			'path' => wpro()->tmpdir->reqTmpDir() . $data['subdir'],
			'url' => $baseurl . $data['subdir'],
			'subdir' => $data['subdir'],
			'basedir' => wpro()->tmpdir->reqTmpDir(),
			'baseurl' => $baseurl,
			'error' => false
		));

	}

}
