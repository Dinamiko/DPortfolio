<?php
/**
 *  This template is used to display all media images in the post
 */
?>

<?php 

	global $dportfolio_gallery_atts; 

	// set columns
	$columns = esc_attr( $dportfolio_gallery_atts['columns'] );

	switch ($columns) {

	 	case '1':
	 		$col = 'col1';
	 		break;

	 	case '2':
	 		$col = 'col2';
	 		break;

	 	case '3':
	 		$col = 'col3';
	 		break;

	 	case '4':
	 		$col = 'col4';
	 		break;
	 	
	 	default:
	 		$col = 'col3';
	 		break;

	} 
	
?>

<div class="dportfolio-media-container">

	<div class="gallery-items">

		<?php if ( $images = dportfolio_get_images() ) {

			foreach ($images as $image) {

				//$url = wp_get_attachment_url($image->ID);
				$img = wp_get_attachment_image($image->ID, 'full'); ?>

				<div class="dportfolio-gallery-item <?php echo $col;?>">
					<?php echo $img;?>
				</div>

			<?php }

		} ?>

	</div>

</div>

















