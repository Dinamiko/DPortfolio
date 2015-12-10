<?php

global $post;

$client = get_post_meta( $post->ID, '_client', true );
$website = get_post_meta( $post->ID, '_website', true );    	

if( $client != '' || $website != '' ) { ?>

	<div class="dportfolio-before-content">

	<?php

	if( $client != '' ) { ?>

		<p><?php _e( 'Client: ', 'dportfolio' );?><?php echo $client;?></p>

	<?php }

	if( $website != '' ) { ?>

		<p><a href="<?php echo $website;?>" target="_blank"><?php _e( 'Website', 'dportfolio' );?></a></p>

	<?php }

	?>	
		
	</div>

<?php } ?>
