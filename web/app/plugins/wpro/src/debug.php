<?php

// wpro_clean_debug_cache() and wpro_is_in_debug_cache() is used by the unit testing.

if (!defined('ABSPATH')) exit();

class WPRO_Debug {

	var $debug_cache;
	var $indentation;

	private $log_is_enabled = false;
	private $php_error_log_enabled = true;
	private $log_filename = false;

	function __construct() {
		$this->clean_debug_cache();

		$this->log_is_enabled = defined('WPRO_DEBUG') && WPRO_DEBUG;

		if ($this->log_is_enabled) {

			if (defined('WPRO_DEBUG_PHPERRORLOG')) {
				$this->php_error_log_enabled = WPRO_DEBUG_PHPERRORLOG;
			}

			if (defined('WPRO_DEBUG_LOGFILE') && WPRO_DEBUG_LOGFILE) {
				if (!file_exists(WPRO_DEBUG_LOGFILE)) {
					$touched = touch(WPRO_DEBUG_LOGFILE);
					if ($touched) {
						chmod(WPRO_DEBUG_LOGFILE, 0666); // 0666, if web browser user and unit test user are not the same.
						$this->log_filename = WPRO_DEBUG_LOGFILE;
					}
				} else {
					$this->log_filename = WPRO_DEBUG_LOGFILE;
				}
			}
		}

	}

	function clean_debug_cache() {
		$this->debug_cache = array();
	}

	function is_in_cache($str) {
		return in_array(trim($str), $this->debug_cache);
	}

	function logblock($msg) {
		$this->log($msg);
		$this->indentation++;
		return $this;
	}

	function logblockend() {
		$this->indentation--;
	}

	function logreturn($value) {
		$this->log('return: ' . var_export($value, true));
		$this->logblockend();
		return $value;
	}

	function log($msg) {

		if (is_array($msg)) $msg = var_export($msg, true);

		$this->debug_cache[] = trim($msg);

		if ($this->log_is_enabled) {
			$msg = str_repeat('  ', $this->indentation) . $msg;
			$msg = implode("\n" . str_repeat('  ', $this->indentation), explode("\n", $msg));
			if ($this->php_error_log_enabled) {
				foreach (explode("\n", $msg) as $row) {
					error_log($row);
				}
			}
			if ($this->log_filename) {
				file_put_contents($this->log_filename, $msg . "\n", FILE_APPEND);
			}
		}
	}

}

// Log upload errors:
if (!function_exists('wp_handle_upload_error')) {
	function wp_handle_upload_error( &$file, $message) {
		$log = wpro()->debug->logblock('wp_handle_upload_error()');
		$log->log('$file = ' . var_export($file, true));
		$log->log('$message = ' . var_export($message, true));
		if (file_exists($file['tmp_name'])) {
			$log->log('Temporary file still exists.');
			$log->log('File size: ' . filesize($file['tmp_name']));
		} else {
			$log->log('Temporary file does not exist (anymore).');
		}
		$upload_dir = wp_upload_dir();
		if (!is_dir($upload_dir['basedir'])) {
			if (file_exists($upload_dir['basedir'])) {
				$log->log('Upload basedir is NOT a directory: ' . $upload_dir['basedir']);
			} else {
				$log->log('Upload basedir DOES NOT exist: ' . $upload_dir['basedir']);
			}
		} else {
			$log->log('Upload basedir exists: ' . $upload_dir['basedir']);
		}
		return $log->logreturn(array('error' => $message));
	}
}
