<?php

class WPRO_WPCLI_Command extends WP_CLI_Command {
	/**
	 * List options.
	 * 
	 * ## OPTIONS
	 * 
	 *     --keys - Only list the option keys, not the values.
	 *
	 * ## EXAMPLES
	 * 
	 *     wp wpro list_options
	 *     wp wpro list_options --keys
	 *
	 * @synopsis
	 */
	function list_options( $args, $assoc_args ) {

		$options = wpro()->options->get_all_options();
		if (isset($assoc_args['keys'])) {
			foreach ($options as $key => $val) {
				echo($key . "\n");
			}
		} else {
			foreach ($options as $key => $val) {
				echo($key . '=' . $val . "\n");
			}
		}

	}

}

WP_CLI::add_command( 'wpro', 'WPRO_WPCLI_Command' );

