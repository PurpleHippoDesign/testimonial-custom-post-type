<?php

/**
 * Template Name: Testimonial Archives
 * Description: Used as a page template to show page contents, followed by a loop through a CPT archive  
 */

add_filter ( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

remove_action ('genesis_loop', 'genesis_do_loop'); // Remove the standard loop

add_action( 'genesis_loop', 'pds_testimonal_loop' ); // Add testimonial post loop

function pds_testimonal_loop() {  

$args = array(
		'post_type' => 'testimonials', 
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '10', 
	);

 	


	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {

		// loop through posts
		while( $loop->have_posts() ): $loop->the_post();




		echo '<div class="testimonials" style="border-bottom:1px solid #DDD;">';
		the_content();
		echo '<div style="margin:20px 0;line-height:20px;text-align:right;color:#999;"><cite>'.genesis_get_custom_field( '_pds_client_name' ).'</cite></div>';			
		echo '</div>';
	


		
		endwhile;



		wp_reset_postdata();
	}

	

}


/** Remove Post Meta and Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');


genesis();

