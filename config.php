<?php
global $wpdb;

// define paths
define ('DEL_BASE_PATH', dirname (__FILE__));
define ('DEL_BASE_WEB_PATH', plugin_dir_url ( __FILE__ ));

// define roles
define ('DEL_POST_TYPE_NAME', 'del_event');

// default settings
define ('DEL_GOOGLE_MAPS_DEFAULT_ZOOM', 2);
define ('DEL_GOOGLE_MAPS_ADDRESSED_ZOOM', 16);
define ('DEL_GOOGLE_MAPS_DEFAULT_CENTER_LOCATION', 'United States');
define ('DEL_DATE_DEFAULT_START_TIME', 60 * 60 * 8); // 8 hours
define ('DEL_DATE_DEFAULT_DURATION', 60 * 60); // 1 hour
define ('DEL_DATE_TIME_ITERATION_MINUTES', 15);
define ('DEL_DATE_DURATION_ITERATION_MINUTES', 15);

// load support files
require_once (DEL_BASE_PATH . '/classes/del-utilities.php');
require_once (DEL_BASE_PATH . '/classes/del-plugin-manager.php');
require_once (DEL_BASE_PATH . '/classes/del-settings-manager.php');
require_once (DEL_BASE_PATH . '/classes/del-location-manager.php');
require_once (DEL_BASE_PATH . '/classes/del-date-manager.php');
require_once (DEL_BASE_PATH . '/classes/del-shortcode-manager.php');
