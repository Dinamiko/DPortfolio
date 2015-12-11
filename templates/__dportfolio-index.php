<?php 
/**
* dportfolio-index.php
* This template is used to display the portfolio
*
* Do not edit this template directly, 
* copy this template and paste in your theme inside a directory named dportfolio 
*/ 

// get shortcode attributes
global $dportfolio_atts;
$view = esc_attr( $dportfolio_atts['view'] );
$limit = esc_attr( $dportfolio_atts['limit'] );
$filter = esc_attr( $dportfolio_atts['filter'] );
$filter_type = esc_attr( $dportfolio_atts['filter_type'] );
//echo $view .'<br>'. $limit .'<br>'. $filter .'<br>'. $filter_type;

?>

<div class="dportfolio-container-main">

<?php
	$args = array(
		'post_type' => 'dportfolio',
		'post_status' => 'publish',
		'posts_per_page' => -1
	);

	$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ) {

	   	while ( $the_query->have_posts() ) {
	        $the_query->the_post();
	        global $post;

	        echo '<h1>'.get_the_title().'</h1>';
	        echo '<a href="'. get_permalink( $post->ID ).'">'.get_the_title().'</a>';

			//$terms = get_terms( 'dportfolio_categories' );
	        //echo var_dump($terms);

			/*
			$content .= '<ul class="dportfolio-filters">';					        				
			$content .= '<li data-filter="all">All</li>';

			foreach ( $terms as $term ) { 

				$content .= '<li data-filter="'. $term->slug .'">'. $term->name .'</li>';

			}

			$content .= '</ul>';

			echo $content;
			*/


		}

	} 

	wp_reset_postdata();
?>

</div>

<?php 
/*
				$content = '<div class="dportfolio-container-main">';

				    $args = array(
				    	'post_type' => 'dportfolio',
				    	'post_status' => 'publish',
				    	'posts_per_page'=> -1
				    );
				    
				    $the_query = new WP_Query( $args ); 

					        $content .= '<div class="dportfolio-header">';

					        		if( $a['filter'] == 'true') {

					        			if( $a['filter_type'] == 'checkbox') {

						        			$terms = get_terms( 'dportfolio_categories' ); 

										    $content .= '<div class="dportfolio-filters">';

										        $content .= '<div data-toggle="dportfolio-buttons">';
		
													foreach ( $terms as $term ) { 

											            $content .= '<label class="dportfolio-btn">';
											                $content .= '<input type="checkbox" value="'. $term->slug .'">';
											                $content .= $term->name;
											            $content .= '</label>';

													} 									        

										        $content .= '</div>';

										    $content .= '</div>';					 

					        			} else {
					        				
					        				$terms = get_terms( 'dportfolio_categories' );

					        				$content .= '<ul class="dportfolio-filters">';					        				
												$content .= '<li data-filter="all">All</li>';

												foreach ( $terms as $term ) { 

													$content .= '<li data-filter="'. $term->slug .'">'. $term->name .'</li>';

												}

											$content .= '</ul>';

					        			}

					        		}

					        $content .= '</div>';

					        if( $a['filter_type'] == 'checkbox') {

					        	$content .= '<div id="dportfolio-container">';

					        } else {

					        	$content .= '<div id="dportfolio-container-list">';

					        }					        

							if ( $the_query->have_posts() ) {
						    	    	
						    	while ( $the_query->have_posts() ) {

						    		$the_query->the_post();
						    		global $post;

								    	$terms = get_the_terms( $post->ID, 'dportfolio_categories' );

								    	if ( $terms && ! is_wp_error( $terms ) ) { 

									    	foreach ( $terms as $term ) {

									    		$category = $term->slug;

									    	}

								    	}
					  
							                if( $a['filter_type'] == 'checkbox') {

							                	 $content .='<div class="dportfolio-item '. $category .'">';

							                } else {

							                	 $content .='<div class="dportfolio-item-list '. $category .'">';

							                }

								               
									                $content .='<a href="'. get_the_permalink() .'">';	

														$content .= get_the_post_thumbnail( $post->ID, 'large');

									                    $content .='<div class="dportfolio-item-info">';
									                        $content .='<h3>'. get_the_title() .'</h3>';
									                    $content .='</div>';

									                $content .='</a>';

								             	$content .='</div>';							             
 

						    	}

						    }

						    wp_reset_postdata(); 

							$content .='</div>';

				$content .='</div>';

				echo $content;
*/