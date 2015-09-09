<?php
/*
Plugin Name: Dyspro Events List
Plugin URI:
Description: Creates a new event content type with simple retrieval through shortcodes.
Version: 0.9
Author: Dyspro Media
Author URI: http://dyspromedia.com
*/

// load configuration variables
require_once(dirname(__FILE__) . '/config.php');

// initialize objects
$del_plugin_manager = new del_plugin_manager ();
$del_location_manager = new del_location_manager ();
$del_date_manager = new del_date_manager ();
$del_settings_manager = new del_settings_manager ();
// $del_shortcode_manager = new del_shortcode_manager (); // TODO: Add shortcode functionality

// add installation script
register_activation_hook (__FILE__, array ($del_plugin_manager, 'activate'));

// set up actions
add_action ('init', array ($del_plugin_manager, 'register_event_post_type'));
add_action ('add_meta_boxes', array ($del_date_manager, 'add_meta_boxes'));
add_action ('add_meta_boxes', array ($del_location_manager, 'add_meta_boxes'));
add_action ('admin_menu', array ($del_settings_manager, 'register_admin_menu_pages'));

// set up shortcodes
// add_shortcode ('del_event_list', array ($del_shortcode_manager, 'build_event_list')); // TODO: Add shortcode functionality
