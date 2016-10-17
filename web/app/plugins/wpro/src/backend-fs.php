<?php

if (!defined('ABSPATH')) exit();

class WPRO_Backend_Filesystem {

	// A backend class MUST have:
	// * a NAME constant with a unique name of your backend.
	// * three functions: activate(), admin_form() and deactivate()
	//
	// You probably also want to take care of those three filters:
	// * wpro_backend_file_exists
	// * wpro_backend_store_file
	// * wpro_backend_retrieval_baseurl

	const NAME = 'Custom Filesystem Path';

	// The filters and options registered in the activate() function,
	// must be de-registered in the deactivate() function, or funny stuff
	// will happen.
	function activate() {
		$log = wpro()->debug->logblock('WPRO_Backend_Filesystem::activate()');

		wpro()->options->register('wpro-fs-path');
		wpro()->options->register('wpro-fs-baseurl');

		add_filter('wpro_backend_file_exists', array($this, 'file_exists'), 10, 2);
		add_filter('wpro_backend_store_file', array($this, 'store_file'));
		add_filter('wpro_backend_retrieval_baseurl', array($this, 'url'));

		return $log->logreturn(true);
	}

	// This is the admin form for this backend.
	function admin_form() {
		$log = wpro()->debug->logblock('WPRO_Backend_Filesystem::admin_form()');
		?>
			<h3><?php echo(self::NAME); ?></h3>
			<p class="description">
				Use this backend for storage in a custom filesystem path,
				for example a shared network folder, or such.
			</p>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Filesystem Path</th>
					<td>
						<input type="text" name="wpro-fs-path" value="<?php echo(wpro()->options->get_option('wpro-fs-path')); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Base URL</th>
					<td>
						<input type="text" name="wpro-fs-baseurl" value="<?php echo(wpro()->options->get_option('wpro-fs-baseurl')); ?>" />
						<p class="description">
							This is the URL to your custom path.
							(Your web server must be configured to respond to those requests.)
							<br />
							Example: http://myfakecdn.com/
						</p>
					</td>
				</tr>
			</table>
		<?php
		return $log->logreturn(true);
	}

	function file_exists($exists, $url) {
		$log = wpro()->debug->logblock('WPRO_Backend_Filesystem::file_exists($exists, $url = "' . $url . '")');
		$file = rtrim(wpro()->options->get('wpro-fs-path'), '/') . '/' . trim(wpro()->url->relativePath($url), '/');
		$log->log('$url = ' . $url);
		$log->log('$file = ' . $file);
		return $log->logreturn(file_exists($file));
	}

	function store_file($data) {
		$log = wpro()->debug->logblock('WPRO_Backend_Filesystem::store_file($data)');

		$file = $data['file']; // Where the file is right now (like in /tmp)
		$url = $data['url']; // The URL where it is supposed to be.
		$mime = $data['type']; // Mime type

		$log->log('$file = ' . $file);
		$log->log('$url = ' . $url);
		$log->log('$mime = ' . $mime);

		if (!file_exists($file)) return $log->logreturn(false);

		$path = rtrim(wpro()->options->get('wpro-fs-path'), '/') . '/' . trim(wpro()->url->relativePath($url), '/');

		if (!is_dir(dirname($path))) mkdir(dirname($path), 0777, true);
		if (!is_dir(dirname($path))) return $log->logreturn(false);

		// Renaming is NOT possible.
		// Other functionality requires the file to be at it's temporary upload position.
		// This is just here for reference on how you can NOT do things:
		//if (!rename($file, $path)) return $log->logreturn(false);

		$log->log('Copy ' . $file . ' to ' . $path . '.');
		if (!copy($file, $path)) {
			$log->log('Copying failed.');
			return $log->logreturn(false);
		}

		return $log->logreturn($data);
	}

	function deactivate() {
		$log = wpro()->debug->logblock('WPRO_Backend_Filesystem::deactivate()');

		// The deactivate() function MUST deregister the options that
		// the activate() function registers:
		wpro()->options->deregister('wpro-fs-path');
		wpro()->options->deregister('wpro-fs-baseurl');

		// The deactivate() function MUST remove the filters that
		// the activate() function adds:
		remove_filter('wpro_backend_file_exists', array($this, 'file_exists'));
		remove_filter('wpro_backend_handle_upload', array($this, 'handle_upload'));
		remove_filter('wpro_backend_retrieval_baseurl', array($this, 'url'));

		return $log->logreturn(true);
	}

	function url($value) {
		$log = wpro()->debug->logblock('WPRO_Backend_Filesystem::url()');

		// Remove trailing slashes.
		$url = rtrim(wpro()->options->get('wpro-fs-baseurl'), '/');

		return $log->logreturn($url);
	}

}

function wpro_setup_fs_backend() {
	wpro()->backends->register('WPRO_Backend_Filesystem'); // Name of the class.
}
add_action('wpro_setup_backend', 'wpro_setup_fs_backend');

