<?php
/** Production */
ini_set('display_errors', 0);
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', false);
define( 'WP_DEBUG_LOG', true );

define('SCRIPT_DEBUG', false);
/** Disable all file modifications including updates and update notifications */
define('DISALLOW_FILE_MODS', true);
