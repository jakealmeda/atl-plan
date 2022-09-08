<?php

global $bars;

$mfunc = new ATLSubMain();

// class
$cs = array(
	'manual_class'		=> 'floorplan-main wp-block-group inner-container_large alignfull',
	'item_class' 		=> $mfunc->setup_array_validation( 'wrap_sel', $bars ),
	'block_class'		=> '', // leave blank
);
$css = $mfunc->setup_combine_classes( $cs );
$classes = !empty( $css ) ? ' class="'.$css.'"' : '';

// styles
$ss = array(
	'manual_style'		=> '',
	'item_style' 		=> $mfunc->setup_array_validation( 'wrap_sty', $bars ),
);
$stayls = $mfunc->setup_combine_styles( $ss );
$inline_style = !empty( $stayls ) ? ' style="'.$stayls.'"' : '';

// check fields to show
$bsf = $mfunc->setup_array_validation( "plan_show_fields", $bars );

/**
 * CONTENT | START
 */

// WRAP | OPEN
echo '<div'.$classes.$inline_style.'><div class="wp-block-group__inner-container">';
	
	// INFO
	if( !empty( $bsf ) ) :

		// Group
		$plan_group = get_field( 'plan-group', $pid );
		if( !empty( $plan_group ) ) {
			echo '<div class="item-group">'.$plan_group.'</div>';
		}

		// Label
		$plan_label = $mfunc->setup_array_validation( 'plan_label', $bars );
		if( !empty( $plan_label ) && in_array( 'plan-label', $bsf ) ) {
			echo '<div class="item-label">'.$plan_label.'</div>';
		}

		// Price
		$plan_price = $mfunc->setup_array_validation( 'plan_price', $bars );
		if( !empty( $plan_price ) && in_array( 'plan-price', $bsf ) ) {
			echo '<div class="item-price">'.$plan_price.'</div>';
		} else {
			// if empty or unchecked, show "call for pricing"
			echo '<div class="item-pricemsg">Call for Pricing.</div>';
			echo '<div class="item-pricemsg2">For an immediate quote on Atlas Shelters, please text message Ron at 1-323-353-3506 your desired shelter type + size.</div>';
		}

		// Deal
		$plan_deal = $mfunc->setup_array_validation( 'plan_deal', $bars );
		if( !empty( $plan_deal ) && in_array( 'plan-deal', $bsf ) ) {
			echo '<div class="item-deal">'.$plan_deal.'</div>';
		}

		// Features
		$plan_features = $mfunc->setup_array_validation( 'plan_features', $bars );
		if( !empty( $plan_features ) && in_array( 'plan-features', $bsf ) ) {
			/**
			 * NOTE: last argument of atl_get_tax_terms() is will it be a link or no.
			 * TRUE if you want term permalink, FALSE or remove the argument if not a link
			 */
			echo '<div class="item-features"><ul>'.$mfunc->atl_get_tax_terms( $plan_features, 'feature_list', FALSE ).'</ul></div>';
		}

		// Summary
		$plan_summary = $mfunc->setup_array_validation( "plan_summary", $bars );
		if( !empty( $plan_summary ) && in_array( 'plan-summary', $bsf ) ) {
			echo '<div class="item-summary">'.$plan_summary.'</div>';
		}

		// Pic
		$plan_pic = $mfunc->setup_array_validation( "plan_pic", $bars );
		if( !empty( $plan_pic ) && in_array( 'plan-pic', $bsf ) ) {
			//echo '<div class="item-pic">'.$plan_pic.'</div>';
			$ppic = wp_get_attachment_image_src( $plan_pic, $mfunc->setup_array_validation( "plan_pic_size", $bars ) ? $bars[ "plan_pic_size" ] : 'full' );

			echo '<div class="item-pic">';
				echo '<img src="'.$ppic[ 0 ].'" border="0" />';
			echo '</div>';
		}

		// BG
		$plan_bg = $mfunc->setup_array_validation( "plan_bg", $bars );
		if( !empty( $plan_bg ) && in_array( 'plan-bg', $bsf ) ) {
			//echo '<div class="item-bg">'.$plan_bg.'</div>';
			$pbg = wp_get_attachment_image_src( $plan_bg, $mfunc->setup_array_validation( "plan_bg_size", $bars ) ? $bars[ "plan_bg_size" ] : 'full' );

			echo '<div class="item-background">';
				echo '<img src="'.$pbg[ 0 ].'" border="0" />';
			echo '</div>';
		}

	endif;
	
// WRAP | CLOSE
echo '</div></div>';
