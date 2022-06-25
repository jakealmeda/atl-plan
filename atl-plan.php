<?php
/**
 * Plugin Name: ATL Plan Field Group
 * Description: Display contents of the ACF field group Plan.
 * Version: 1.0
 * Author: Jake Almeda
 * Author URI: http://smarterwebpackages.com/
 * Network: true
 * License: GPL2
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Call main class
$atl_plan = new AtlasSurvivalSheltersMain();

// Include files
include_once( 'lib/atl-plan-functions.php' );
include_once( 'lib/atl-plan-acf.php' );

// Main class
class AtlasSurvivalSheltersMain {

	// simply return this plugin's main directory
    public function atl_plugin_dir_path() {

        return plugin_dir_path( __FILE__ );

    }

    // hook list
    public $genesis_hooks = array(
		'genesis_before',
		'genesis_before_header',
		'genesis_header',
		'genesis_site_title',
		'genesis_header_right',
		'genesis_site_description',
		'genesis_after_header',
		'genesis_before_content_sidebar_wrap',
		'genesis_before_content',
		'genesis_before_loop',
		'genesis_before_sidebar_widget_area',
		'genesis_after_sidebar_widget_area',
		'genesis_loop',
		'genesis_before_entry',
		'genesis_entry_header',
		'genesis_entry_content',
		'genesis_entry_footer',
		'genesis_after_entry',
		'genesis_after_endwhile',
		'genesis_after_loop',
		'genesis_after_content',
		'genesis_after_content_sidebar_wrap',
		'genesis_before_footer',
		'genesis_footer',
		'genesis_after_footer',
		'genesis_after',
	);

}

// Call sub main class
$atl_plan_2 = new ATLSubMain();