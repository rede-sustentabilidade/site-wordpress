<?php

if (!defined('ABSPATH')) exit();

class WPRO_CDN {

	private $cdns;

	function __construct() {
		$log = wpro()->debug->logblock('WPRO_CDN::__construct()');
		$cdns = array();
		return $log->logreturn(true);
	}

}
