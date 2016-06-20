<?php

if (!defined('ABSPATH')) exit();

class WPRO_Http {

	function __construct() {
		$log = wpro()->debug->logblock('WPRO_Http::__construct()');
		return $log->logreturn(true);
	}

	function url_exists($url) {
		$log = wpro()->debug->logblock('WPRO_Http::url_exists($url = "' . $url . '")');

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result = trim(curl_exec_follow($ch));
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if ($httpCode != 200) return $log->logreturn(false);
		return $log->logreturn(true);
	}
}
