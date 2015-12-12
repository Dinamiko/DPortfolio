<?php
/**
 *  This template is used to display DPortfolio index page [dportfolio]
 */
?>

<?php 

	// shortcode attributes
	global $dportfolio_atts; 

	// columns
	$columns = esc_attr( $dportfolio_atts['columns'] );
	$col = 'col'.$columns;

	// filter
	$filter = esc_attr( $dportfolio_atts['filter'] );

	// limit
	$limit = esc_attr( $dportfolio_atts['limit'] );

	// dportfolio options
	$dportfolio_show_content = get_option( 'dportfolio_show_content', 'thumbnail_template_default' );
	$dportfolio_show_content = get_option( 'dportfolio_show_content', 'on' );
	$dportfolio_content_words = get_option( 'dportfolio_content_words', 20 );
	$dportfolio_show_categories = get_option( 'dportfolio_show_categories', 'on' );
	$dportfolio_show_details = get_option( 'dportfolio_show_details', 'on' ); 

?>

<div class="dportfolio-container">

	<?php if( $filter == 'true' ) { ?>

		<div class="dportfolio-nav-filter">

			<div class="filter-options">

				<button class="active" data-group="all">All</button>

				<?php

				$taxonomies = array( 'dportfolio_categories' ); 
				$terms = get_terms($taxonomies);
										
				foreach ( $terms as $term ) { ?>

					<button class="" data-group="<?php echo $term->slug;?>"><?php echo $term->name;?></button>

				<?php }	?>

			</div>

		</div>

	<?php } ?>

	<div class="dportfolio-items-container">

		<div class="dportfolio-items">

			<?php
				$args = array(
					'post_type' => 'dportfolio',
					'post_status' => 'publish',
					'posts_per_page' => $limit
				);
					 
				$the_query = new WP_Query( $args );
					 
				if ( $the_query->have_posts() ) {
					 
					while ( $the_query->have_posts() ) {
					 	$the_query->the_post(); 
				        global $post;
				      
						$terms = get_the_terms( $post->ID, 'dportfolio_categories' );

						$cats_slugs = array(); 
						$cats_ids = array(); 

						if ( $terms && ! is_wp_error( $terms ) ) {
									
							foreach ( $terms as $term ) {

								array_push( $cats_slugs, $term->slug );
								array_push( $cats_ids, $term->term_id );

							}

							$cats_slugs = implode(',', $cats_slugs );
							$cats_ids = implode(',', $cats_ids );

						} ?>

						<div class="dportfolio-item <?php echo $col;?>" data-groups="<?php echo $cats_slugs;?>">

							<?php if ( has_post_thumbnail() ) { ?> 

								<a class="dportfolio-featured-img" href="<?php the_permalink();?>">
									<?php the_post_thumbnail('large'); ?>
								</a>

							<?php } ?>

							<div class="dportfolio-item-info">

								<div class="dportfolio-item-content">
		
									<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>

									<?php if( $dportfolio_show_details == 'on' ) { ?>

										<?php 												
										// dportfolio details (postmeta)
										global $post;
										$client = get_post_meta( $post->ID, '_client', true );
										$website = get_post_meta( $post->ID, '_website', true );   

										if( $client != '' || $website != '' ) { ?>

											<?php if( $client != '' ) { ?>

												<p class="dportfolio-client"><?php _e( '', 'dportfolio' );?><?php echo $client;?></p>

											<?php }

											if( $website != '' ) { ?>

												<p class="dportfolio-website"><a href="<?php echo $website;?>" target="_blank"><?php _e( 'Website', 'dportfolio' );?></a></p>

											<?php } ?>	

										<?php } ?>

									<?php } ?>	

									<?php
										if( $dportfolio_show_content == 'on' ) {
											// IMPORTANT! don't use the_content, the_excerpt or get_the_excerpt here,
											// use get_the_content to prevent PHP memory errors. 
											$content = get_the_content();
											$trimmed = wp_trim_words($content , $dportfolio_content_words ); 
											echo '<p class="dportfolio-website-content">'.$trimmed.'</p>';										
										}
									?>

								</div>

								<?php if( $dportfolio_show_categories == 'on' ) { ?>

									<div class="dportfolio-item-categories-container">
										<?php foreach ( $terms as $term ) { ?>

											<a class="dportfolio-item-categories" href="<?php echo get_term_link( $term->term_id, 'dportfolio_categories' );?>">
												<?php echo $term->name;?>
											</a>
			
										<?php } ?>
									</div>

								<?php }	?>

							</div>															
							
						</div>
					 
				<?php }
					 
				} 
					 
				wp_reset_postdata(); 
			?>

		</div>

	</div>

</div>



















