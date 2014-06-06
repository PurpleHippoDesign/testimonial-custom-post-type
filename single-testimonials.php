<?php

/**The custom testimonial post type single post template
 */

/** Force full width layout */
add_filter ( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/** Remove Post Meta and Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');


remove_action ('genesis_loop', 'genesis_do_loop'); // Remove the standard loop
add_action( 'genesis_loop', 'pds_testimonal_loop' ); // Add testimonial post loop

function pds_testimonal_loop() {  





		echo '<div class="testimonials" style="border-bottom:1px solid #DDD;">';
		the_content();
		echo '<div style="margin:20px 0;line-height:20px;text-align:right;color:#999;"><cite>'.genesis_get_custom_field( '_pds_client_name' ).'</cite></div>';			
		echo '</div>';
	
}


genesis();

