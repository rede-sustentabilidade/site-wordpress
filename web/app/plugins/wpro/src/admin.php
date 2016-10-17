<?php

if (!defined('ABSPATH')) exit();

class WPRO_Admin {

	function __construct() {
		$log = wpro()->debug->logblock('WPRO_Admin::__construct()');

		if (!defined('WPRO_ON') || !WPRO_ON) { // Settings in constants. Don't show admin.
			add_action('init', array($this, 'admin_init'));

		}

		return $log->logreturn(true);
	}

	function admin_form() {
		$log = wpro()->debug->logblock('WPRO_Admin::admin_form()');
		if (!$this->is_trusted()) {
			wp_die ( __ ('You do not have sufficient permissions to access this page.'));
		}

		$options = wpro()->options->get_all_options();

		?>
			<div class="wrap wpro-admin">
				<form method="post" action="<?php echo(admin_url('admin-ajax.php')); ?>">
					<h2>WPRO</h2>
					<input type="hidden" name="action" value="wpro_settings" />
					<table class="form-table">
						<tr valign="top">
							<th scope="row">Storage backend</th>
							<td>
								<input id="wpro_backend__radio" type="radio" name="wpro-service" value="" <?php if (!wpro()->backends->is_backend_activated()) echo('checked="checked"'); ?> /> <label for="wpro_backend__radio">Plugin inactive</label><br />
								<?php foreach (wpro()->backends->backend_names() as $backend): ?>
									<?php $radio_id = 'wpro_backend_' . sanitize_title($backend) . '_radio'; ?>
									<input id="<?php echo($radio_id); ?>" type="radio" name="wpro-service" value="<?php echo($backend); ?>" <?php if ($options['wpro-service'] == $backend) echo('checked="checked"'); ?> /> <label for="<?php echo($radio_id); ?>"><?php echo($backend); ?></label><br />
								<?php endforeach; ?>
							</td>
						</tr>
					</table>
					<?php foreach(wpro()->backends->backend_names() as $backend): ?>
						<?php $div_id = 'wpro_backend_' . sanitize_title($backend) . '_div'; ?>
						<div class="wpro-form-block" id="<?php echo($div_id); ?>">
							<?php $backend = wpro()->backends->backend_by_name($backend); ?>
							<?php if (method_exists($backend, 'admin_form')) { $backend->admin_form(); }; ?>
						</div>
					<?php endforeach; ?>
					<div class="wpro-form-block" id="wpro-form-general-settings">
						<h3>General settings</h3>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">Add subfolder to all paths/urls</th>
								<td>
									<input type="text" name="wpro-folder" value="<?php echo(wpro()->options->get('wpro-folder')); ?>" />
									<p class="description">
										Example: If you set this to "<b>MyBlog</b>", your URLs may become something like:<br />
										http://s3-eu-west-1.amazonaws.com/amazonbucket/<b>MyBlog</b>/2014/05/image.jpg
									</p>
								</td>
							</tr>
							<?php if (is_multisite()): ?>
								<tr valign="top">
									<th scope="row">Each mulitsite blog has it's own subdirectory</th>
									<td>
										<input type="checkbox" name="wpro-mu-subdirs" value="1" type="checkbox" <?php
											if (wpro()->options->get_option('wpro-mu-subdirs')) {
												echo('checked="checked"');
											} else {
												// If there are no s3 settings since before, we should default this checkbox to be
												// checked. However, if there ARE s3 settings since before, it should default as
												// unchecked, to preserve backwards compatibility.
												// (We only need backwards compatibility with versions when we only had a S3
												// backend, so we just check the s3 options.)
												if (!wpro()->options->get_option('wpro-aws-key')
												&& !wpro()->options->get_option('wpro-aws-secret')
												&& !wpro()->options->get_option('wpro-aws-bucket')
												&& !wpro()->options->get_option('wpro-aws-cloudfront')
												&& !wpro()->options->get_option('wpro-aws-virthost')
												&& !wpro()->options->get_option('wpro-aws-endpoint')
												&& !wpro()->options->get_option('wpro-aws-ssl')) {

													echo('checked="checked"');

												}
											}
										?> />
										<p class="description">
											Normally, you want this checked. However, for backwards compatibility reasons, you may want to uncheck this box.
										</p>
									</td>
								</tr>
							<?php endif; ?>
							<tr valign="top">
								<th scope="row">Temporary directory</th>
								<td>
									<input type="text" name="wpro-tempdir" value="<?php echo(wpro()->tmpdir->sysTmpDir()); ?>" />
									<p class="description">
										This directory must be writeable for the web server.
										It will be used for temporary storing files during uploads/edits, so it can be on non-persistent storage.
									</p>
								</td>
							</tr>
						</table>
					</div>
					<p class="submit">
						<input type="submit" name="submit" id="submit" class="button button-primary" value="Save settings">
					</p>
				</form>
			</div>
		<?php
		return $log->logreturn(true);
	}


	function admin_init() {
		$log = wpro()->debug->logblock('WPRO_Admin::admin_init()');

		wp_enqueue_script('wpro_admin', plugins_url('/wpro/js/admin.js'), array('jquery'));

		if ($this->is_trusted()) { // TODO: Check if this is too late to add network_admin_menu hook?
			if (is_multisite()) {
				add_action('network_admin_menu', array($this, 'network_admin_menu'));
			} else {
				add_action('admin_menu', array($this, 'admin_menu')); // Will add the settings menu.
			}
			add_action('wp_ajax_wpro_settings', array($this, 'admin_post')); // Gets called from plugin admin page POST request.
		}
		return $log->logreturn(true);
	}

	function admin_menu() {
		$log = wpro()->debug->logblock('WPRO_Admin::admin_menu()');

		add_options_page('WPRO Plugin Settings', 'WPRO Settings', 'manage_options', 'wpro', array($this, 'admin_form'));
		return $log->logreturn(true);
	}

	function admin_post() {
		$log = wpro()->debug->logblock('WPRO_Admin::admin_post()');
		// We are handling the POST settings stuff ourselves, instead of using the Settings API.
		// This is because the Settings API has no way of storing network wide options in multisite installs.
		if (!$this->is_trusted()) return false;

		// First activate the correct backend,
		// so that wpro()->options->is_an_option() returns
		// the right stuff for the right backend:
		if (isset($_POST['wpro-service']) && $_POST['wpro-service'] !== wpro()->options->get('wpro-service')) {
			wpro()->backends->activate_backend($_POST['wpro-service']);
		}

		// Set the rest of the options:
		foreach ($_POST as $key => $val) {
			if ($key !== 'action' && $key !== 'wpro-service' && $key !== 'submit') {
				if (wpro()->options->is_an_option($key)) {
					wpro()->options->set($key, $val);
				}
			}
		}

		// Maybe that should be fixed in a more generic way... Until then:
		if (is_multisite()) {
			if (!isset($_POST['wpro-mu-subdirs'])) {
				wpro()->options->set('wpro-mu-subdirs', '');
			} else {
				wpro()->options->set('wpro-mu-subdirs', '1');
			}
		}

		// If the selected backend class has a admin_post() function, then run it:
		if (wpro()->backends->is_backend_activated()) {
			$backend = wpro()->backends->active_backend;
			if (method_exists($backend, 'admin_post')) {
				$backend->admin_post();
			}
		}

		// Redirect back (different urls depending on multisite or not):
		if (is_multisite()) {
			$url = admin_url('network/settings.php?page=wpro&updated=true');
		} else {
			$url = admin_url('options-general.php?page=wpro&updated=true');
		}
		header('Location: ' . $url);
		$log->log('Redirect to: ' . $url);
		$log->logblockend();
		exit();
	}

	function is_trusted() {
		$log = wpro()->debug->logblock('WPRO_Admin::is_trusted()');

		if (is_multisite()) {
			if (is_super_admin()) {
				return $log->logreturn(true);
			}
		} else {
			if (current_user_can('manage_options')) {
				return $log->logreturn(true);
			}
		}
		return $log->logreturn(false);
	}

	function network_admin_menu() {
		$log = wpro()->debug->logblock('WPRO_Admin::network_admin_menu()');

		add_submenu_page('settings.php', 'WPRO Plugin Settings', 'WPRO Settings', 'manage_options', 'wpro', array($this, 'admin_form'));
		return $log->logreturn(true);
	}

}
