<?php

class WPRO_Gravityforms {

	function __construct() {
		$log = wpro()->debug->logblock('WPRO_Gravityforms::__construct()');
		add_action('gform_after_submission', array($this, 'gravityforms_after_submission'), 10, 2);
		return $log->logreturn(true);
	}

	function gravityforms_after_submission($entry, $form) {
		$log = wpro()->debug->logblock('WPRO_Gravityforms::gravityforms_after_submission()');

		$upload_dir = wp_upload_dir();
		foreach($form['fields'] as $field) {
			if ($field['type'] == 'fileupload') {
				$id = (int) $field['id'];
				$file_to_upload = $entry[$id];
				if($file_to_upload) {
					$url = $entry[$id];
					$file_to_upload = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $file_to_upload);
					$mime = wp_check_filetype($file_to_upload);

					$response = $this->backend->upload($file_to_upload, $url, $mime['type']);
					if (!$response) return $log->logreturn(false);
				}
			}
		}
		return $log->logreturn(true);
	}
}

if (class_exists('GFCommon')) {
	$wpro_gravityforms = new WPRO_Gravityforms();
}
