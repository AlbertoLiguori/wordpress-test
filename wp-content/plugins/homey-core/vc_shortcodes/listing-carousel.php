<?php
/*-----------------------------------------------------------------------------------*/
/*	Properties
/*-----------------------------------------------------------------------------------*/
if( !function_exists('homey_listing_carousel') ) {
	function homey_listing_carousel($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'listing_style' => '',
			'booking_type' => '',
			'listing_type' => '',
			'room_type' => '',
			'listing_country' => '',
			'listing_state' => '',
			'listing_city' => '',
			'listing_area' => '',
			'featured_listing' => '',
			'listing_ids' => '',
			'posts_limit' => '',
			'sort_by' => '',
			'offset' => '',
			'slides_to_show' => '',
			'slides_to_scroll' => '',
			'slide_infinite' => '',
			'slide_auto' => '',
			'auto_speed' => '',
			'navigation' => '',
			'slide_dots' => '',
			'token' => '',
		), $atts));

		ob_start();
		global $template_args;

		//do the query
		$the_query = Homey_Query::get_wp_query($atts); //by ref  do the query;

		if($listing_style == 'card') {
			$main_classes = 'property-module-card listing-carousel-next-prev-'.$token.' property-module-card-slider property-module-card-slider-'.esc_attr__($slides_to_show);
			$sub_classes = 'item-card-slider-view item-card-slider-view-'.esc_attr__($slides_to_show);
		} else {
			$main_classes = 'property-module-grid listing-carousel-next-prev-'.$token.' property-module-grid-slider property-module-grid-slider-'.esc_attr__($slides_to_show);

			$sub_classes = 'item-grid-slider-view item-grid-slider-view-'.esc_attr__($slides_to_show);
		}

		$template_args = array( 'listing-item-view' => 'item-grid-view' );

		if ( $listing_style == 'list' || $listing_style == 'list-v2' ) {
		    $template_args = array( 'listing-item-view' => 'item-list-view' );
		} elseif ( $listing_style == 'card' ) {
		    $template_args = array( 'listing-item-view' => 'item-card-view' );
		}
		
		wp_register_script('listing_caoursel', get_template_directory_uri() . '/js/listing-carousel.js', array('jquery'), HOMEY_THEME_VERSION, true);
		$local_args = array(
			'slides_to_show' => $slides_to_show,
			'slides_to_scroll' => $slides_to_scroll,
			'slide_auto' => $slide_auto,
			'auto_speed' => $auto_speed,
			'slide_dots' => $slide_dots,
			'slide_infinite' => $slide_infinite,
			'navigation' => $navigation,
			'listing_style' => $listing_style
		);
		wp_localize_script('listing_caoursel', 'listing_caoursel_' . $token, $local_args);
		wp_enqueue_script('listing_caoursel');
		?>

		<div class="module-wrap <?php esc_attr_e($main_classes);?>">
			<div class="listing-wrap which-layout-<?php echo $listing_style;?> <?php if(str_contains($listing_style, '2')){ echo 'item-'.grid_list_or_card($listing_style, 1).'-view'; } ?> item-<?php esc_attr_e($listing_style);?>-view">
					<div id="homey-listing-carousel-<?php esc_attr_e($token);?>" data-token="<?php esc_attr_e($token); ?>" class="homey-carousel homey-carouse-elementor <?php esc_attr_e($sub_classes);?>">
						<?php
						if ($the_query->have_posts()) :
							while ($the_query->have_posts()) : $the_query->the_post();

								if($listing_style == 'card') {
									get_template_part('template-parts/listing/listing-card', '', $template_args);
								}elseif($listing_style == 'grid-v2' || $listing_style == 'list-v2') {
                                    get_template_part('template-parts/listing/listing-item-v2', '', $template_args);
                                } else {
									get_template_part('template-parts/listing/listing-item', '', $template_args);
								}

							endwhile;
							Homey_Query::loop_reset_postdata();
						else:
							//get_template_part('template-parts/property', 'none');
						endif;
						?>
				</div>
			</div><!-- grid-listing-page -->
		</div>
		
		<?php
		$result = ob_get_contents();
		ob_end_clean();
		return $result;

	}

	add_shortcode('homey-listing-carousel', 'homey_listing_carousel');
}
?>