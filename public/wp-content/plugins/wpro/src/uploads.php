<?php

if (!defined('ABSPATH')) exit();

class WPRO_Uploads {

	public $disableFileDupeControl = false; // Should be false. Could be true for testing purposes only.

	function __construct() {
		$log = wpro()->debug->logblock('WPRO_Uploads::__construct()');

		add_filter('wp_handle_upload', array($this, 'handle_upload'));
		add_filter('wp_generate_attachment_metadata', array($this, 'generate_attachment_metadata')); // We use this filter to store resized versions of the images.
		add_filter('wp_update_attachment_metadata', array($this, 'update_attachment_metadata')); // We use this filter to store resized versions of the images.
		add_filter('wp_get_attachment_metadata', array($this, 'get_attachment_metadata'), 10, 2);

		add_filter('load_image_to_edit_path', array($this, 'load_image_to_edit_path'), 10, 3); // This filter downloads the image to our local temporary directory, prior to editing the image.
		add_filter('load_image_to_edit_filesystempath', array($this, 'load_image_to_edit_filesystempath'), 10, 3);
		add_filter('load_image_to_edit_attachmenturl', array($this, 'load_image_to_edit_attachmenturl'), 10, 3);
		add_filter('wp_upload_bits', array($this, 'upload_bits')); // On XMLRPC uploads, files arrives as strings which we are handling in this filter.
		add_filter('wp_handle_upload_prefilter', array($this, 'handle_upload_prefilter')); // This is where we check for filename dupes (and change them to avoid overwrites).

		return $log->logreturn(true);
	}

	function exists($path) {
		$log = wpro()->debug->logblock('WPRO_Uploads::exists()');

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_URL, $path);
		$result = trim(curl_exec_follow($ch));

		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if ($httpCode != 200) return $log->logreturn(false);

		return $log->logreturn(true);
	}

	function handle_upload($data) {
		$log = wpro()->debug->logblock('WPRO_Uploads::handle_upload()');

		if (wpro()->backends->is_backend_activated()) {

			if (!file_exists($data['file'])) return false; //TODO: Test what is happening in this situation.

			//OLD WAY: $response = wpro()->backends->active_backend()->upload($data['file'], $data['url'], $data['type']);
			$data = apply_filters('wpro_backend_store_file', $data);

			if (!is_array($data)) {
				$log->log('Some error somewhere: $data after wpro_backend_store_file filter is not an array.');
			}
		}

		return $log->logreturn($data);
	}

	// Handle duplicate filenames:
	// Wordpress never calls the wp_handle_upload_overrides filter properly, so we do not have any good way of setting a callback for wp_unique_filename_callback, which would be the most beautiful way of doing this. So, instead we are usting the wp_handle_upload_prefilter to check for duplicates and rename the files...
	function handle_upload_prefilter($file) {

		// We must sanitize before dupe control...
		$file['name']= sanitize_file_name($file['name']);

		$log = wpro()->debug->logblock('WPRO_Uploads::handle_upload_prefilter()');

		if (wpro()->backends->is_backend_activated() && !$this->disableFileDupeControl) {

			$upload = wp_upload_dir();

			$name = $file['name'];
			$path = trim($upload['url'], '/') . '/' . $name;

			$counter = 0;

			$exists = true;
			while ($exists) {
				$exists = apply_filters('wpro_backend_file_exists', null, $path);
				if (is_null ($exists)) {
					// no wpro_backend_file_exists filter, or the filter returned null.
					// use standard exists check (using http(s) request...)

					$exists = wpro()->http->url_exists($path);
				}

				if ($exists) {
					if (preg_match('/\.([^\.\/]+)$/', $file['name'], $regs)) {
						$ending = '.' . $regs[1];
						$preending = substr($file['name'], 0, 0 - strlen($ending));
						$name = $preending . '_' . $counter . $ending;
					} else {
						$name = $file['name'] . '_' . $counter;
					}
					$path = trim($upload['url'], '/') . '/' . $name;
					$counter++;
				}
			}

			$file['name'] = $name;

		}

		return $log->logreturn($file);
	}

	// Just for logging...
	function load_image_to_edit_filesystempath($filepath, $attachment_id, $size) {
		$log = wpro()->debug->logblock('WPRO_Uploads::load_image_to_edit_filesystempath($filepath = "' . $filepath . '", $attachment_id = ' . $attachment_id . ', $size = ' . $size . ')');
		return $log->logreturn($filepath);
	}

	// Just for logging...
	function load_image_to_edit_attachmenturl($url, $attachment_id, $size) {
		$log = wpro()->debug->logblock('WPRO_Uploads::load_image_to_edit_attachmenturl($url = "' . $url . '", $attachment_id = ' . $attachment_id . ', $size = ' . $size . ')');
		return $log->logreturn($url);
	}

	function load_image_to_edit_path($filepath, $attachment_id, $size) {
		$log = wpro()->debug->logblock('WPRO_Uploads::load_image_to_edit_path($filepath = "' . $filepath . '", $attachment_id = ' . $attachment_id . ', $size = ' . $size . ')');

		if ($filepath === '') {

			// Why is this shit being called with an empty $filepath!?
			$log->log('File path is empty!');

		} else {

			if (file_exists ($filepath)) {

				// When no backend is active:
				// Without this file_exists, during an upload to WordPress,
				// it will try to download the image to it's own path,
				// which results in the upload being 0 bytes in length.

				$log->log("Don't download. File already exists.");

			} else {

				$attachment_url = wp_get_attachment_url( $attachment_id );
				$fileurl = wpro()->url->attachmentUrl($filepath);

				$filepath = wpro()->url->tmpFilePath($filepath);

				$log->log('$attachment_url = "' . $attachment_url . '"');
				$log->log('$fileurl = "' . $fileurl . '"');
				$log->log('$filepath = "' . $filepath . '"');

				if ((substr($fileurl, 0, 7) == 'http://') || (substr($fileurl, 0, 8) == 'https://')) {

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $fileurl);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_AUTOREFERER, true);

					$fh = fopen($filepath, 'w');
					fwrite($fh, curl_exec_follow($ch));
					fclose($fh);

					//$this->removeTemporaryLocalData($filepath);

					return $log->logreturn($filepath);

				}

			}
		}

		return $log->logreturn($filepath);
	}

	function generate_attachment_metadata($data) {
		$log = wpro()->debug->logblock('WPRO_Uploads::generate_attachment_metadata($data = ' . var_export($data, true) . '))');
		return $log->logreturn($this->update_attachment_metadata($data));
	}
	
	function update_attachment_metadata($data) {
		$log = wpro()->debug->logblock('WPRO_Uploads::update_attachment_metadata($data = ' . var_export($data, true) . ')');


		if (!is_array($data) || !isset($data['sizes']) || !is_array($data['sizes'])) return $log->logreturn($data);
		$upload_dir = wp_upload_dir();
		$filepath = $upload_dir['basedir'] . '/' . preg_replace('/^(.+\/)?.+$/', '\\1', $data['file']);
		foreach ($data['sizes'] as $size => $sizedata) {
			$file = $filepath . $sizedata['file'];
			$url = $upload_dir['baseurl'] . substr($file, strlen($upload_dir['basedir']));
			$filetype = wp_check_filetype($file);
			if (is_array($filetype) && isset($filetype['type'])) {
				$mime = $filetype['type'];
			} else {
				$mime = 'application/octet-stream';
			}

			if (wpro()->backends->is_backend_activated()) {
				apply_filters('wpro_backend_store_file', array(
					'file' => $file,
					'url' => $url,
					'type' => $mime
				));
			}
		}

		return $log->logreturn($data);
	}

	// Just for logging what is happening:
	function get_attachment_metadata($data, $id) {
		$log = wpro()->debug->logblock('WPRO_Uploads::get_attachment_metadata($data, $id)');
		$log->log('$id = ' . $id);
		return $log->logreturn($data);
	}

	function upload_bits($data) {
		$log = wpro()->debug->logblock('WPRO_Uploads::upload_bits()');
		$log->log('$data["name"] = "' . $data['name'] . '";');
		$log->log('$data["time"] = "' . $data['time'] . '";');
		$log->log('Data size: ' . strlen($data['bits']));

		if (!wpro()->backends->is_backend_activated()) {
			$log->log('There is no backend.');
			$log->logblockend();
			return $data;
		}

		$ending = '';
		if (preg_match('/\.([^\.\/]+)$/', $data['name'], $regs)) $ending = '.' . $regs[1];

		$tmpfile = wpro()->tmpdir->reqTmpDir() . '/wpro' . time() . rand(0, 999999) . $ending;
		while (file_exists($tmpfile)) $tmpfile = wpro()->tmpdir->reqTmpDir() . '/wpro' . time() . rand(0, 999999) . $ending;

		$fh = fopen($tmpfile, 'wb');
		fwrite($fh, $data['bits']);
		fclose($fh);

		$upload = wp_upload_dir();

		return $log->logreturn(array(
			'file' => $tmpfile,
			'url' => rtrim($upload['url'], '/') . '/' . $data['name'],
			'error' => false
		));
	}


}
