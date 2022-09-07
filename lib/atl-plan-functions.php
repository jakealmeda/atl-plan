<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class ATLSubMain {

	/**
	 * Main function
	 */
	public function main_plan_function() {

		/*$args = array(
			'plan_label'					=> get_field( 'plan-label' ),
			'plan_price'					=> '$'.number_format( get_field( 'plan-price' ), 2, '.', ','),
			'plan_deal'						=> '$'.number_format( get_field( 'plan-deal' ), 2, '.', ','),
			'plan_features'					=> get_field( 'plan-features' ),
			'plan_summary'					=> get_field( 'plan-summary' ),
			'plan_pic'						=> get_field( 'plan-pic' ),
			'plan_bg'						=> get_field( 'plan-bg' ),
			'plan_template'					=> get_field( 'plan-template' ),
			'plan_show_fields'				=> get_field( 'plan-show-fields' ),
			'plan_status'					=> get_field( 'plan-status' ),
		);*/

		//add_action( get_field( 'plan-hook' ), function() use ( $args ){
		add_action( get_field( 'plan-hook' ), function() {

			global $bars;

			/*echo $this->process_main_plan( $args );
			foreach( $args as $k => $v ) {

				if( $k == 'plan_template' ) {
					$template = $v;
				} else {
					$bars[ $k ] = $v;
				}

			}*/

			// fetch the terms
			$ter = get_the_terms( get_the_ID(), 'feature_list' );
			foreach ( $ter as $term ) {
				$tnames[] = $term->name;
			}

			$pprice = get_field( 'plan-price' );
			$pdeal = get_field( 'plan-deal' );
			
			$bars = array(
				'plan_label'					=> get_field( 'plan-label' ),
				'plan_price'					=> !empty( $pprice ) ? '$'.number_format( get_field( 'plan-price' ), 2, '.', ',') : 'Call for Pricing',
				'plan_deal'						=> !empty( $pdeal ) ? '$'.number_format( get_field( 'plan-deal' ), 2, '.', ',') : '',
				//'plan_features'					=> get_field( 'plan-features' ),
				'plan_features'					=> $tnames,
				'plan_summary'					=> get_field( 'plan-summary' ),
				'plan_pic'						=> get_field( 'plan-pic' ),
				'plan_pic_size'					=> get_field( 'plan-pic-size' ),
				'plan_bg'						=> get_field( 'plan-bg' ),
				'plan_bg_size'					=> get_field( 'plan-bg-size' ),
				'plan_show_fields'				=> get_field( 'plan-show-fields' ),
				'wrap_sel'						=> get_field( 'plan-section-class' ),
				'wrap_sty'						=> get_field( 'plan-section-style' ),
			);

			// display or not?
			if( empty( get_field( 'plan-status' ) ) ) :

				// output
	            echo $this->atl_view_template( get_field( 'plan-template' ), 'views' );

	        endif;

		});

	}


    /**
     * Get VIEW template
     */
    public function atl_view_template( $layout, $dir_ext ) {

        $o = new AtlasSurvivalSheltersMain();

        $layout_file = $o->atl_plugin_dir_path().'templates/'.$dir_ext.'/'.$layout;

        if( is_file( $layout_file ) ) {

            ob_start();

            include $layout_file;

            $new_output = ob_get_clean();

            if( !empty( $new_output ) ) {
                $output = $new_output;
            } else {
                $output = FALSE;
            }


        } else {

            $output = FALSE;

        }

        return $output;

    }


    /**
     * Combine Classes for the template
     */
    public function setup_combine_classes( $classes ) {

        $block_class = !empty( $classes[ 'block_class' ] ) ? $classes[ 'block_class' ] : '';
        $item_class = !empty( $classes[ 'item_class' ] ) ? $classes[ 'item_class' ] : '';
        $manual_class = !empty( $classes[ 'manual_class' ] ) ? $classes[ 'manual_class' ] : '';

        $return = '';
        
        $ar = array( $block_class, $item_class, $manual_class );
        for( $z=0; $z<=( count( $ar ) - 1 ); $z++ ) {

            if( !empty( $ar[ $z ] ) ) {

                $return .= $ar[ $z ];

                if( $z != ( count( $ar ) - 1 ) ) {
                    $return .= ' ';
                }

            }

        }

        return $return;

    }


    /**
     * Combine Classes for the template
     */
    public function setup_combine_styles( $styles ) {

        $manual_style = $styles[ 'manual_style' ];
        $item_style = $styles[ 'item_style' ];

        if( !empty( $manual_style ) && !empty( $item_style ) ) {
                return $manual_style.' '.$item_style;
        } else {

            if( empty( $manual_style ) && !empty( $item_style ) ) {
                return $item_style;
            } else {
                return $manual_style;
            }

        }

    }


    /**
     * Array validation
     */
    public function setup_array_validation( $needles, $haystacks, $args = FALSE ) {

        if( is_array( $haystacks ) && array_key_exists( $needles, $haystacks ) && !empty( $haystacks[ $needles ] ) ) {

            return $haystacks[ $needles ];

        } else {

            return FALSE;

        }

    }


	/**
	* Get Custom Taxonomy Terms
	*/
	public function atl_get_tax_terms( $tid, $taxname, $anchor = FALSE ) {

		$out = '';

		foreach( $tid as $term ) {
			//$t = get_term_by( 'term_id', $term, $taxname );
			$t = get_term_by( 'slug', $term, $taxname );
			if( is_object( $t ) ) {
				if( $anchor !== FALSE ) {
					$out .= '<div class="item-term"><a href="'.get_term_link( $t->term_id ).'">'.$t->name.'</a></div>';
				} else {
					$out .= '<div class="item-term">'.$t->name.'</div>';
				}
			}
			
		}

		return $out;

	}


	/**
	 * Handle the display
	 */
	public function __construct() {

		if( !is_admin() ) {

			add_action( 'wp', array( $this, 'main_plan_function' ) );

		}

	}

}