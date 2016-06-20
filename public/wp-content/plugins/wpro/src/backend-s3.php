<?php

if (!defined('ABSPATH')) exit();

class WPRO_Backend_S3 {

	const NAME = 'Amazon S3';

	private $amazon_s3_endpoints = array(
		'US Standard (us-east-1)' => 's3.amazonaws.com',
		'US Standard, North Virginia endpoint (us-east-1)' => 's3-external-1.amazonaws.com',
		'US West, Oregon (us-west-2)' => 's3-us-west-2.amazonaws.com',
		'US West, North California (us-west-1)' => 's3-us-west-1.amazonaws.com',
		'EU, Ireland (eu-west-1)' => 's3-eu-west-1.amazonaws.com',
		'EU, Frankfurt (eu-central-1)' => 's3-eu-central-1.amazonaws.com',
		'Asia Pacific, Singapore (ap-southeast-1)' => 's3-ap-southeast-1.amazonaws.com',
		'Asia Pacific, Sydney (ap-southeast-2)' => 's3-ap-southeast-2.amazonaws.com',
		'Asia Pacific, Tokyo (ap-northeast-1)' => 's3-ap-northeast-1.amazonaws.com',
		'South America, Sao Paulo (sa-east-1)' => 's3-sa-east-1.amazonaws.com'
	);

	function activate() {
		$log = wpro()->debug->logblock('WPRO_Backend_S3::activate()');

		wpro()->options->register('wpro-aws-key');
		wpro()->options->register('wpro-aws-secret');
		wpro()->options->register('wpro-aws-bucket');
		//wpro()->options->register('wpro-aws-cloudfront'); Cloudfront support should be as a CDN.
		wpro()->options->register('wpro-aws-virthost');
		wpro()->options->register('wpro-aws-endpoint');
		wpro()->options->register('wpro-aws-ssl');

		add_filter('wpro_backend_store_file', array($this, 'store_file'));
		add_filter('wpro_backend_retrieval_baseurl', array($this, 'url'));

		return $log->logreturn(true);
	}

	function admin_form() {
		$log = wpro()->debug->logblock('WPRO_Backend_S3::admin_form()');

		?>
			<h3><?php echo(self::NAME); ?></h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">AWS Key</th>
					<td>
						<input type="text" name="wpro-aws-key" value="<?php echo(wpro()->options->get_option('wpro-aws-key')); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">AWS Secret</th>
					<td>
						<input type="text" name="wpro-aws-secret" value="<?php echo(wpro()->options->get_option('wpro-aws-secret')); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Endpoint</th>
					<td>
						<select name="wpro-aws-endpoint">
							<option>-</option>
							<?php
								foreach ($this->amazon_s3_endpoints as $endpoint_name => $endpoint_domain) {
									$selected = '';
									if ($endpoint_domain == wpro()->options->get_option('wpro-aws-endpoint')) {
										$selected = 'selected="selected"';
									}
									?><option value="<?php echo($endpoint_domain); ?>" <?php echo($selected); ?>><?php echo($endpoint_name); ?></option><?php
								}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Use SSL/HTTPS</th>
					<td>
						<input name="wpro-aws-ssl" id="wpro-aws-ssl" value="1" type="checkbox" <?php if (wpro()->options->get_option('wpro-aws-ssl')) echo('checked="checked"'); ?> />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">S3 Bucket</th>
					<td>
						<input type="text" name="wpro-aws-bucket" value="<?php echo(wpro()->options->get_option('wpro-aws-bucket')); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Use bucket name as virtual hostname</th>
					<td>
						<input name="wpro-aws-virthost" id="wpro-aws-virthost" value="1" type="checkbox" <?php if (wpro()->options->get_option('wpro-aws-virthost')) echo('checked="checked"'); ?> />
						<p class="description">
							Check this box if your bucket name is a valid domain name, and the domain is a CNAME alias for Amazon S3.
						</p>
					</td>
				</tr>
			</table>
		<?php
		return $log->logreturn(true);
	}

	function admin_post() {
		$log = wpro()->debug->logblock('WPRO_Backend_S3::admin_post()');

		// The generic admin_post() in admin.php does not handle unchecked checkboxes.
		// Maybe that should be fixed in a more generic way... Until then:
		if (!isset($_POST['wpro-aws-ssl'])) {
			wpro()->options->set('wpro-aws-ssl', '');
		} else {
			wpro()->options->set('wpro-aws-ssl', '1');
		}
		if (!isset($_POST['wpro-aws-virthost'])) {
			wpro()->options->set('wpro-aws-virthost', '');
		} else {
			wpro()->options->set('wpro-aws-virthost', '1');
		}

		return $log->logreturn(true);
	}

	function store_file($data) {
		$log = wpro()->debug->logblock('WPRO_Backend_S3::store_file($data)');
		$log->log('$data = ' . var_export($data, true));

		$file = $data['file'];
		$url = wpro()->url->relativePath($data['url']);
		$mime = $data['type'];

		if (!file_exists($file)) {
			$log->log('Error: File does not exist: ' . $file);
			return $log->logreturn(false);
		}

		$fin = fopen($file, 'r');
		if (!$fin) {
			$log->log('Error: Can not open ' . $file . ' for reading.');
			return $log->logreturn(false);
		}

		$fout = fsockopen(wpro()->options->get('wpro-aws-endpoint'), 80, $errno, $errstr, 30);
		if (!$fout) {
			$log->log('Error: Can not open connection to S3 endpoint.');
			return $log->logreturn(false);
		}
		$datetime = gmdate('r');
		$string2sign = $this->string_to_sign_at_upload($mime, $datetime, $url);

		$host = wpro()->options->get('wpro-aws-bucket');
		if (!wpro()->options->get_option('wpro-aws-virthost')) {
			$host .= '.' . wpro()->options->get('wpro-aws-endpoint');
		}

		$query = "PUT /" . $url . " HTTP/1.1\n";
		$query .= "Host: " . $host . "\n";
		$query .= "x-amz-acl: public-read\n";
		$query .= "Connection: keep-alive\n";
		$query .= "Content-Type: " . $mime . "\n";
		$query .= "Content-Length: " . filesize($file) . "\n";
		$query .= "Date: " . $datetime . "\n";
		$query .= "Authorization: AWS " . wpro()->options->get_option('wpro-aws-key') . ":" . $this->amazon_hmac($string2sign) . "\n\n";

		$log->log('$query = "' . $query . '";');

		fwrite($fout, $query);
		while (feof($fin) === false) fwrite($fout, fread($fin, 8192));
		fclose($fin);

		// Get the amazon response:
		$response = '';
		while (!feof($fout)) {
			$response .= fgets($fout, 256);
			if (strpos($response, "\r\n\r\n") !== false) { // Header fully returned.
				if (strpos($response, 'Content-Length: 0') !== false) break; // Return if Content-Length: 0 (and header is fully returned)
				if (substr($response, -7) == "\r\n0\r\n\r\n") break; // Keep-alive responses does not return EOF, they end with this string.
			}
		}

		fclose($fout);

		$log->log('S3 response: ' . $response);

		if (strpos($response, '<Error>') !== false) {
			return $log->logreturn(false);
		}

		return $log->logreturn($data);
	}

	function string_to_sign_at_upload($mime, $datetime, $url) {
		$log = wpro()->debug->logblock('WPRO_Backend_S3::string_to_sign_at_upload($mime = "' . $mime . '", $datetime = "' . $datetime . '", $url = "' . $url . '")');
		$url = wpro()->url->relativePath($url);
		$string = "PUT\n\n" . $mime . "\n" . $datetime . "\nx-amz-acl:public-read\n/" . wpro()->options->get('wpro-aws-bucket') . '/' . $url;
		return $log->logreturn($string);
	}

	function amazon_hmac($string) {
		$log = wpro()->debug->logblock('WPRO_Backend_S3::amazon_hmac()');

		return $log->logreturn(base64_encode(extension_loaded('hash') ?
		hash_hmac('sha1', $string, wpro()->options->get_option('wpro-aws-secret'), true) : pack('H*', sha1(
		(str_pad($this->secret, 64, chr(0x00)) ^ (str_repeat(chr(0x5c), 64))) .
		pack('H*', sha1((str_pad(wpro()->options->get_option('wpro-aws-secret'), 64, chr(0x00)) ^
		(str_repeat(chr(0x36), 64))) . $string))))));
	}


	function deactivate() {
		$log = wpro()->debug->logblock('WPRO_Backend_S3::deactivate()');

		wpro()->options->deregister('wpro-aws-key');
		wpro()->options->deregister('wpro-aws-secret');
		wpro()->options->deregister('wpro-aws-bucket');
		//wpro()->options->deregister('wpro-aws-cloudfront');
		wpro()->options->deregister('wpro-aws-virthost');
		wpro()->options->deregister('wpro-aws-endpoint');
		wpro()->options->deregister('wpro-aws-ssl');

		remove_filter('wpro_backend_handle_upload', array($this, 'handle_upload'));
		remove_filter('wpro_backend_retrieval_baseurl', array($this, 'url'));

		return $log->logreturn(true);
	}

	function url($value) {
		$log = wpro()->debug->logblock('WPRO_Backend_S3::url()');

		$protocol = 'http';
		if (wpro()->options->get('wpro-aws-ssl')) {
			$protocol = 'https';
		}

		if (wpro()->options->get_option('wpro-aws-virthost')) {
			$url = $protocol . '://' . wpro()->options->get('wpro-aws-bucket') . '/';
		} else {
			$url = $protocol . '://' . wpro()->options->get('wpro-aws-bucket') . '.' . wpro()->options->get('wpro-aws-endpoint') . '/';
		}

		if (strlen($folder = trim(wpro()->options->get_option('wpro-folder'), '/'))) {
			$url .= $folder;
		}

		return $log->logreturn($url);
	}

}

function wpro_setup_s3_backend() {
	wpro()->backends->register('WPRO_Backend_S3'); // Name of the class.
}
add_action('wpro_setup_backend', 'wpro_setup_s3_backend');

