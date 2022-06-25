<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// AUTO FILL SELECT FOR HOOKS (ACF)
add_filter( 'acf/load_field/name=plan-hook', 'atl_autofill_hooks' );
function atl_autofill_hooks( $field ) {

	$hookers = new AtlasSurvivalSheltersMain();

	$field['choices'] = array();

	//Loop through whatever data you are using, and assign a key/value
	if( is_array( $hookers->genesis_hooks ) ) {

		foreach( $hookers->genesis_hooks as $value ) {

			$field['choices'][$value] = $value;
		}

		return $field;

	}

}

/**
 * Auto select Checkbox options | Fields to Show
 *
 */
add_filter('acf/load_field/name=plan-hook', 'atl_autofill_hooks_default' );
function atl_autofill_hooks_default( $field ) {

	$field['default_value'] = 'genesis_before_content';

	return $field;

}


/**
 * Auto fill Select options | TEMPLATES
 *
 */
add_filter( 'acf/load_field/name=plan-template', 'acf_atl_template_choices' );
function acf_atl_template_choices( $field ) {
    
    $z = new AtlasSurvivalSheltersMain();

    $file_extn = 'php';

    // get all files found in VIEWS folder
    $view_dir = $z->atl_plugin_dir_path().'templates/views/';

    $data_from_dir = setup_pulls_view_files( $view_dir, $file_extn );

    $field['choices'] = array();

    //Loop through whatever data you are using, and assign a key/value
    if( is_array( $data_from_dir ) ) {

        foreach( $data_from_dir as $field_key => $field_value ) {
            $field['choices'][$field_key] = $field_value;
        }

        return $field;

    }
    
}


/**
 * Auto fill Select options | IMAGE SIZES
 *
 */
add_filter( 'acf/load_field/name=plan-pic-size', 'acf_atl_img_sizes' );
add_filter( 'acf/load_field/name=plan-bg-size', 'acf_atl_img_sizes' );
function acf_atl_img_sizes( $field ) {

    $field['choices'] = array();

    foreach( get_intermediate_image_sizes() as $value ) {
        $field['choices'][$value] = $value;
    }

    return $field;

}


/**
 * Pull all files found in $directory but get rid of the dots that scandir() picks up in Linux environments
 *
 */
if( !function_exists( 'setup_pulls_view_files' ) ) {

    function setup_pulls_view_files( $directory, $file_extn ) {

        $out = array();
        
        // get all files inside the directory but remove unnecessary directories
        $ss_plug_dir = array_diff( scandir( $directory ), array( '..', '.' ) );

        foreach( $ss_plug_dir as $filename ) {
            
            if( pathinfo( $filename, PATHINFO_EXTENSION ) == $file_extn ) {
                $out[ $filename ] = pathinfo( $filename, PATHINFO_FILENAME );
            }

        }

        /*foreach ($ss_plug_dir as $value) {
            
            // combine directory and filename
            $file = basename( $directory.$value, $file_extn );
            
            // filter files to include
            if( $file ) {
                $out[ $value ] = $file;
            }

        }*/

        // Return an array of files (without the directory)
        return $out;

    }
    
}