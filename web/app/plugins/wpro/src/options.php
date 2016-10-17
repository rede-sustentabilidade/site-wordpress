<?php

if (!defined('ABSPATH')) exit();

class WPRO_Options {

	private $option_keys = array(
		'wpro-service',
		'wpro-folder',
		'wpro-tempdir'
	);
	private $multisite_option_keys = array(
		'wpro-mu-subdirs'
	);

	function __construct() {
		$log = wpro()->debug->logblock('WPRO_Options::__construct()');
		add_action('init', array($this, 'init')); // Register the settings.
		return $log->logreturn(true);
	}

	function deregister($option) {
		$log = wpro()->debug->logblock('WPRO_Options::deregister()');
		if (($key = array_search($option, $this->option_keys)) !== false) {
			unset($this->option_keys[$key]);
			//delete_site_option($option);
		}
		return $log->logreturn(true);
	}

	// The difference between get_option() and get() is that get() will check wheather
	// the option is a registered setting or not.
	// get_option() is only supposed to be used directly when rendering admin forms (which needs
	// access to all options for all backends).
	// get() is supposed to be used for everything else.

	function get_option($option, $default = false) {
		$log = wpro()->debug->logblock('WPRO_Options::get_option($option = "' . $option . '", $default)');

		if (!defined('WPRO_ON') || !WPRO_ON) {
			return $log->logreturn(get_site_option($option, $default));
		}
		$constantName = strtoupper(str_replace('-', '_', $option));
		if (defined($constantName)) {
			return $log->logreturn(constant($constantName));
		}
		return $log->logreturn($default);
	}

	function get($option, $default = false) {
		$log = wpro()->debug->logblock('WPRO_Options::get($option = "' . $option . '", $default)');
		if (!$this->is_an_option($option)) return $log->logreturn(null);
		return $log->logreturn($this->get_option($option, $default));
	}

	function get_all_options() {
		$log = wpro()->debug->logblock('WPRO_Options::get_all_options()');
		$result = array();
		foreach ($this->option_keys as $key) {
			$result[$key] = $this->get($key);
		}
		return $log->logreturn($result);
	}

	function init() {
		$log = wpro()->debug->logblock('WPRO_Options::init()');

		// if multisite, add the multisite options to options array:
		if (is_multisite()) {
			foreach ($this->multisite_option_keys as $key) {
				$this->option_keys[] = $key;
			}
		}

		// Register all settings:
		foreach ($this->option_keys as $key) {
			add_site_option($key, '');
		}

		return $log->logreturn(true);
	}

	function is_an_option($option) {
		$log = wpro()->debug->logblock('WPRO_Options::is_an_option($option = "' . $option . '")');
		return $log->logreturn(in_array($option, $this->option_keys));
	}

	function register($option) {
		$log = wpro()->debug->logblock('WPRO_Options::register()');
		if (!in_array($option, $this->option_keys)) {
			$this->option_keys[] = $option;
		}
		return $log->logreturn(true);
	}

	function set($option, $value) {
		$log = wpro()->debug->logblock('WPRO_Options::set($option = "' . $option . '", $value = "' . $value . '")');
		if (!$this->is_an_option($option)) return false;
		return $log->logreturn(update_site_option($option, $value));
	}

}
