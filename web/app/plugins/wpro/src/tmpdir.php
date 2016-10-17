<?php

if (!defined('ABSPATH')) exit();

class WPRO_TmpDir {

	private $reqTmpDirCache = '.';
	public $cleanUpDirs = array(); // Temporary directories to remove at shutdown.

	function __construct() {
		$log = wpro()->debug->logblock('WPRO_TmpDir::__construct()');
		add_filter('shutdown', array($this, 'cleanUp')); // Remove temporary directory
		return $log->logreturn(true);
	}

	// Returns the system temporary dir, or any temporary dir we may be able to use:
	function sysTmpDir() {
		$log = wpro()->debug->logblock('WPRO_TmpDir::sysTmpDir()');

		$tmp = wpro()->options->get('wpro-tempdir');

		if (!is_string($tmp) || strlen($tmp) < 1) {
			if (!function_exists('sys_get_temp_dir')) {
				$tmp = '/tmp';
				if ($t = getenv('TMP'))  $tmp = $t;
				if ($t = getenv('TMPDIR')) $tmp = $t;
				if ($t = getenv('TEMP')) $tmp = $t;
			} else {
				$tmp = sys_get_temp_dir();
			}
		}

		if (substr($tmp, -1) == '/') $tmp = substr($tmp, 0, -1);

		return $log->logreturn($tmp);
	}

	// temporary directory for this request only:
	function reqTmpDir() {
		$log = wpro()->debug->logblock('WPRO_TmpDir::reqTmpDir()');
		if ($this->reqTmpDirCache !== '.') return $log->logreturn($this->reqTmpDirCache);
		while (is_dir($this->reqTmpDirCache)) $this->reqTmpDirCache = $this->sysTmpDir() . '/wpro' . time() . rand(0, 999999);
		$this->cleanUpDirs[] = $this->reqTmpDirCache;
		return $log->logreturn($this->reqTmpDirCache);

	}

	function rmdirRecursive($dir) {
		$log = wpro()->debug->logblock('WPRO_TmpDir::rmdirRecursive()');
		$files = array_diff(scandir($dir), array('.', '..'));
		foreach ($files as $file) {
			if (is_dir($dir .'/' . $file)) {
				$this->rmdirRecursive($dir . '/' . $file);
			} else {
				unlink($dir . '/' . $file);
			}
		}
		return $log->logreturn(rmdir($dir));
	}

	function cleanUp() {
		$log = wpro()->debug->logblock('WPRO_TmpDir::cleanUp()');
		foreach ($this->cleanUpDirs as $tmpDir) {
			$log->log('Clean up dir: ' . $tmpDir);
			if (is_dir($tmpDir)) {
				$this->rmdirRecursive($tmpDir);
			}
		}
		return $log->logreturn(true);
	}

}
