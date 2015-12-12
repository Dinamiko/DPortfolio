<?php 

// show categories in single portfolio

$dportfolio_portfolio_page_show_categories = get_option( 'dportfolio_portfolio_page_show_categories', 'on' );

if( $dportfolio_portfolio_page_show_categories == 'on' ) { ?>

	<?php
	$args = array(
		'post_type' => 'dportfolio',
		'post_status' => 'publish',
		'posts_per_page' => 20
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

			} 

		}

	} ?>

	<div style="margin-top:30px;">
		<?php foreach ( $terms as $term ) { ?>

		<a href="<?php echo get_term_link( $term->term_id, 'dportfolio_categories' );?>">
			<?php echo $term->name;?>
		</a>
					
		<?php } ?>
	</div>

<?php }	?>