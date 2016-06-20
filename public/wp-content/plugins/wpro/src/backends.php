<?php

if (!defined('ABSPATH')) exit();

class WPRO_Backends {

	public $active_backend;
	private $backends;

	function __construct() {
		$log = wpro()->debug->logblock('WPRO_Backends::__construct()');

		$this->active_backend = null;
		$this->backends = array();

		return $log->logreturn(true);
	}

	function activate_backend($name) {
		$log = wpro()->debug->logblock('WPRO_Backends::activate_backend()');

		$this->deactivate_backend();
		$this->active_backend = $this->backend_by_name($name);
		if (is_null($this->active_backend)) {
			wpro()->options->set('wpro-service', '');
			return $log->logreturn(false);
		}
		if (method_exists($this->active_backend, 'activate')) {
			$this->active_backend->activate();
		}
		$active_backend = $this->active_backend;
		wpro()->options->set('wpro-service', $active_backend::NAME);
		return $log->logreturn(true);
	}

	function backend_by_name($name) {
		$log = wpro()->debug->logblock('WPRO_Backends::backend_by_name()');
		$name = $this->sanitize_backend_name($name);
		foreach ($this->backends as $key => $val) {
			if ($key == $name) return $log->logreturn($val);
		}
		return $log->logreturn(null);
	}

	function backend_names() {
		$log = wpro()->debug->logblock('WPRO_Backends::backend_names()');
		$result = array_keys($this->backends);
		sort($result);
		return $log->logreturn($result);
	}
	
	function deactivate_backend() {
		$log = wpro()->debug->logblock('WPRO_Backends::deactivate_backend()');
		if (!is_null($this->active_backend)) {
			if (method_exists($this->active_backend, 'deactivate')) {
				$this->active_backend->deactivate();
			}
			wpro()->options->set('wpro-service', '');
			$this->active_backend = null;
		}
		return $log->logreturn(true);
	}

	function has_backend($name) {
		$log = wpro()->debug->logblock('WPRO_Backends::has_backend()');
		$name = $this->sanitize_backend_name($name);
		$names = $this->backend_names();
		return $log->logreturn(in_array($name, $names));
	}

	function is_backend_activated() {
		if ($this->active_backend === null) return false;
		return true;
	}

	function register($backend_class_name) {
		$log = wpro()->debug->logblock('WPRO_Backends::register()');
		if ($this->has_backend($backend_class_name::NAME)) return $log->logreturn(false);
		$this->backends[$backend_class_name::NAME] = new $backend_class_name();
		return $log->logreturn(true);
	}

	function sanitize_backend_name($name) {
		// Not really a sanitizer... Rather a backwards compatibility handler. :)
		if ($name == 's3') $name = 'Amazon S3';
		return $name;
	}

}

